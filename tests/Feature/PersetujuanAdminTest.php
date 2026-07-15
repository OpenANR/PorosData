<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Instansi;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\PersetujuanPerubahan;

class PersetujuanAdminTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $waliKelas;
    protected $sd;
    protected $kelas;
    protected $siswa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sd = Instansi::create([
            'nama_sekolah' => 'SD Negeri 01 Poros Data',
            'tingkat' => 'SD',
        ]);

        $this->admin = User::create([
            'name' => 'Admin Utama',
            'username' => 'admin_utama',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'instansi_id' => $this->sd->id,
        ]);

        $this->waliKelas = User::create([
            'name' => 'Wali Kelas 1',
            'username' => 'walikelas1',
            'password' => bcrypt('password123'),
            'role' => 'wali_kelas',
            'instansi_id' => $this->sd->id,
        ]);

        $this->kelas = Kelas::create([
            'nama_kelas' => 'Kelas 1',
            'instansi_id' => $this->sd->id,
            'user_id' => $this->waliKelas->id,
        ]);

        $siswaUser = User::create([
            'name' => 'Siswa Test',
            'username' => 'siswa_test',
            'password' => bcrypt('password123'),
            'role' => 'siswa',
            'instansi_id' => $this->sd->id,
        ]);

        $this->siswa = Siswa::create([
            'user_id' => $siswaUser->id,
            'kelas_id' => $this->kelas->id,
            'nisn' => '1111122222',
            'status' => 'aktif',
        ]);
    }

    public function test_admin_can_access_persetujuan_index(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('persetujuan.index'));

        $response->assertStatus(200);
        $response->assertSee('Status Persetujuan Pengajuan');
    }

    public function test_admin_can_approve_edit_student_request(): void
    {
        // Create an edit request
        $persetujuan = PersetujuanPerubahan::create([
            'siswa_id' => $this->siswa->id,
            'user_id' => $this->waliKelas->id,
            'alasan' => 'Edit data siswa',
            'data_lama' => [
                'name' => 'Siswa Test',
                'username' => 'siswa_test',
                'nisn' => '1111122222',
                'kelas_id' => $this->kelas->id,
                'status' => 'aktif',
            ],
            'data_baru' => [
                'name' => 'Siswa Test Updated',
                'username' => 'siswa_updated',
                'nisn' => '3333344444',
                'kelas_id' => $this->kelas->id,
                'status' => 'aktif',
            ],
            'status' => 'proses'
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('persetujuan.terima', $persetujuan->id));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Pengajuan perubahan berhasil disetujui.');

        // Assert database is updated
        $this->assertDatabaseHas('users', [
            'id' => $this->siswa->user_id,
            'name' => 'Siswa Test Updated',
            'username' => 'siswa_updated',
        ]);

        $this->assertDatabaseHas('siswa', [
            'id' => $this->siswa->id,
            'nisn' => '3333344444',
        ]);

        $this->assertDatabaseHas('persetujuan_perubahans', [
            'id' => $persetujuan->id,
            'status' => 'disetujui',
        ]);
    }

    public function test_admin_can_reject_edit_student_request(): void
    {
        // Create an edit request
        $persetujuan = PersetujuanPerubahan::create([
            'siswa_id' => $this->siswa->id,
            'user_id' => $this->waliKelas->id,
            'alasan' => 'Edit data siswa',
            'data_lama' => [
                'name' => 'Siswa Test',
                'username' => 'siswa_test',
                'nisn' => '1111122222',
                'kelas_id' => $this->kelas->id,
                'status' => 'aktif',
            ],
            'data_baru' => [
                'name' => 'Siswa Test Updated',
                'username' => 'siswa_updated',
                'nisn' => '3333344444',
                'kelas_id' => $this->kelas->id,
                'status' => 'aktif',
            ],
            'status' => 'proses'
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('persetujuan.tolak', $persetujuan->id));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Pengajuan perubahan berhasil ditolak.');

        // Assert database is not updated
        $this->assertDatabaseHas('users', [
            'id' => $this->siswa->user_id,
            'name' => 'Siswa Test',
            'username' => 'siswa_test',
        ]);

        $this->assertDatabaseHas('siswa', [
            'id' => $this->siswa->id,
            'nisn' => '1111122222',
        ]);

        $this->assertDatabaseHas('persetujuan_perubahans', [
            'id' => $persetujuan->id,
            'status' => 'ditolak',
        ]);
    }

    public function test_wali_kelas_can_request_student_dropout(): void
    {
        $response = $this->withSession(['datasiswa_user_id' => $this->waliKelas->id])
            ->delete(route('datasiswa.kelola_siswa.destroy', $this->siswa->id), [
                'alasan_dropout' => 'Pindah domisili',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Pengajuan penghapusan data siswa berhasil diajukan dan sedang menunggu persetujuan admin.');

        $this->assertDatabaseHas('persetujuan_perubahans', [
            'siswa_id' => $this->siswa->id,
            'user_id' => $this->waliKelas->id,
            'alasan' => 'DropOut Siswa',
            'status' => 'proses',
        ]);
    }

    public function test_admin_approval_of_dropout_removes_student_from_kelola_siswa_and_moves_to_riwayat_dropout(): void
    {
        // 1. Create dropout request
        $persetujuan = PersetujuanPerubahan::create([
            'siswa_id' => $this->siswa->id,
            'user_id' => $this->waliKelas->id,
            'alasan' => 'DropOut Siswa',
            'data_lama' => [
                'name' => $this->siswa->user->name,
                'username' => $this->siswa->user->username,
                'password' => $this->siswa->user->password_plain,
                'nisn' => $this->siswa->nisn,
                'kelas_id' => $this->siswa->kelas_id,
                'status' => $this->siswa->status,
            ],
            'data_baru' => [
                'status' => 'drop_out',
                'alasan_dropout' => 'Pindah domisili',
            ],
            'status' => 'proses'
        ]);

        // 2. Admin approves it
        $response = $this->actingAs($this->admin)
            ->post(route('persetujuan.terima', $persetujuan->id));

        $response->assertRedirect();

        // Check database status
        $this->assertDatabaseHas('siswa', [
            'id' => $this->siswa->id,
            'status' => 'drop_out',
        ]);

        $this->assertDatabaseHas('persetujuan_perubahans', [
            'id' => $persetujuan->id,
            'status' => 'disetujui',
        ]);

        // 3. Check student is excluded from kelola-siswa
        $response = $this->withSession(['datasiswa_user_id' => $this->waliKelas->id])
            ->get(route('datasiswa.kelola_siswa'));
        $response->assertStatus(200);
        $response->assertDontSee($this->siswa->user->name);

        // 4. Check student is included in riwayat-dropout
        $response = $this->withSession(['datasiswa_user_id' => $this->waliKelas->id])
            ->get(route('datasiswa.riwayat_dropout'));
        $response->assertStatus(200);
        $response->assertSee($this->siswa->user->name);
        $response->assertSee('Pindah domisili');
    }

    public function test_wali_kelas_can_view_status_persetujuan(): void
    {
        // 1. Create a pending request
        $persetujuan = PersetujuanPerubahan::create([
            'siswa_id' => $this->siswa->id,
            'user_id' => $this->waliKelas->id,
            'alasan' => 'Edit data siswa',
            'data_lama' => [
                'name' => $this->siswa->user->name,
                'username' => $this->siswa->user->username,
                'nisn' => $this->siswa->nisn,
                'kelas_id' => $this->siswa->kelas_id,
                'status' => $this->siswa->status,
            ],
            'data_baru' => [
                'name' => 'Name Updated By Wali',
                'username' => $this->siswa->user->username,
                'nisn' => $this->siswa->nisn,
                'kelas_id' => $this->siswa->kelas_id,
                'status' => $this->siswa->status,
            ],
            'status' => 'proses'
        ]);

        // 2. Access status persetujuan page
        $response = $this->withSession(['datasiswa_user_id' => $this->waliKelas->id])
            ->get(route('datasiswa.status_persetujuan'));

        $response->assertStatus(200);
        $response->assertSee('Edit data siswa');
        $response->assertSee($this->siswa->user->name);
    }
}
