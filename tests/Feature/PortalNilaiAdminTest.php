<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Instansi;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\PortalNilaiSetting;
use App\Models\PortalNilaiNilai;

class PortalNilaiAdminTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $sd;
    protected $kelas;
    protected $mapel;
    protected $siswa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sd = Instansi::create([
            'nama_sekolah' => 'SD Negeri 01 Poros Data',
            'tingkat' => 'SD',
        ]);

        $this->admin = User::create([
            'name' => 'Admin Test',
            'username' => 'admin_nilai',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'instansi_id' => $this->sd->id,
        ]);

        $this->kelas = Kelas::create([
            'nama_kelas' => 'Kelas 1A',
            'instansi_id' => $this->sd->id,
        ]);

        $this->mapel = Mapel::create([
            'kode_mapel' => 'IND-01',
            'nama_mapel' => 'Bahasa Indonesia',
            'kategori_mapel_id' => 1, // Seeded by default in migration
            'instansi_id' => $this->sd->id,
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
            'nisn' => '12345678',
            'status' => 'aktif',
        ]);
    }

    public function test_admin_can_access_dashboard_after_login_session(): void
    {
        // Mock authentication via Portal Nilai session key
        $response = $this->withSession(['portalnilai_user_id' => $this->admin->id])
            ->get(route('portalnilai.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Portal Penilaian');
    }

    public function test_admin_can_get_settings(): void
    {
        $response = $this->withSession(['portalnilai_user_id' => $this->admin->id])
            ->get(route('portalnilai.settings.get'));

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'data' => ['tugas_buka', 'tugas_tutup', 'asas_buka', 'asas_tutup']]);
    }

    public function test_admin_can_save_settings(): void
    {
        $response = $this->withSession(['portalnilai_user_id' => $this->admin->id])
            ->post(route('portalnilai.settings.save'), [
                'tugas_buka' => '2026-07-08T12:00',
                'tugas_tutup' => '2026-07-10T12:00',
                'asas_buka' => '2026-07-08T12:00',
                'asas_tutup' => '2026-07-10T12:00',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        
        $this->assertDatabaseHas('portal_nilai_settings', [
            'instansi_id' => $this->sd->id,
            'tugas_buka' => '2026-07-08 12:00:00',
        ]);
    }

    public function test_admin_can_get_student_grades(): void
    {
        $response = $this->withSession(['portalnilai_user_id' => $this->admin->id])
            ->get(route('portalnilai.students.get', [
                'kelas_id' => $this->kelas->id,
                'mapel_id' => $this->mapel->id
            ]));

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_admin_can_save_grades(): void
    {
        $response = $this->withSession(['portalnilai_user_id' => $this->admin->id])
            ->post(route('portalnilai.grades.save'), [
                'kelas_id' => $this->kelas->id,
                'mapel_id' => $this->mapel->id,
                'payload' => [
                    [
                        'siswa_id' => $this->siswa->id,
                        'tugas_1' => 85,
                        'tugas_2' => 90,
                        'asts' => 80,
                        'tugas_4' => 88,
                        'tugas_5' => 92,
                        'mode_asas' => 'FastTrack',
                        'pg_asas' => '23',
                        'essai_asas' => '8,8,4,8,8',
                        'murni_asas' => 86,
                        'perbaikan' => null,
                        'ketuntasan' => 'TUNTAS',
                        'nilai_akhir' => 87,
                    ]
                ]
            ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('portal_nilai_nilai', [
            'siswa_id' => $this->siswa->id,
            'nilai_akhir' => 87,
        ]);
    }
}
