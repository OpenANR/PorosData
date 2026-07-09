<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Instansi;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\KategoriMapel;
use Illuminate\Support\Facades\Hash;

class GuruAssignTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $sd;
    protected $kelas1;
    protected $kelas2;
    protected $mapel1;
    protected $mapel2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sd = Instansi::create([
            'nama_sekolah' => 'SD Negeri 01 Poros Data',
            'tingkat' => 'SD',
        ]);

        $this->admin = User::create([
            'name' => 'Admin Test',
            'username' => 'admin_test',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'instansi_id' => $this->sd->id,
        ]);

        $this->kelas1 = Kelas::create([
            'nama_kelas' => 'Kelas 1A',
            'instansi_id' => $this->sd->id,
        ]);

        $this->kelas2 = Kelas::create([
            'nama_kelas' => 'Kelas 2A',
            'instansi_id' => $this->sd->id,
        ]);

        $kategori = KategoriMapel::create([
            'nama_kategori' => 'Umum',
            'instansi_id' => $this->sd->id,
        ]);

        $this->mapel1 = Mapel::create([
            'kode_mapel' => 'IND-01',
            'nama_mapel' => 'Bahasa Indonesia',
            'kategori_mapel_id' => $kategori->id,
            'instansi_id' => $this->sd->id,
        ]);

        $this->mapel2 = Mapel::create([
            'kode_mapel' => 'MAT-01',
            'nama_mapel' => 'Matematika',
            'kategori_mapel_id' => $kategori->id,
            'instansi_id' => $this->sd->id,
        ]);
    }

    public function test_admin_can_create_guru_with_kelas_and_mapel_assignments(): void
    {
        $response = $this->actingAs($this->admin)->post(route('guru.store'), [
            'name' => 'Guru Baru',
            'username' => 'gurubaru',
            'duk' => '1234567890',
            'role' => 'guru',
            'password' => 'password123',
            'kelas_ids' => [$this->kelas1->id, $this->kelas2->id],
            'mapel_ids' => [$this->mapel1->id],
        ]);

        $response->assertRedirect(route('guru.index'));

        $guru = User::where('username', 'gurubaru')->first();
        $this->assertNotNull($guru);
        $this->assertEquals('password123', $guru->password_plain);

        $this->assertDatabaseHas('guru_kelas', [
            'user_id' => $guru->id,
            'kelas_id' => $this->kelas1->id,
        ]);
        $this->assertDatabaseHas('guru_kelas', [
            'user_id' => $guru->id,
            'kelas_id' => $this->kelas2->id,
        ]);
        $this->assertDatabaseHas('guru_mapel', [
            'user_id' => $guru->id,
            'mapel_id' => $this->mapel1->id,
        ]);
        $this->assertDatabaseMissing('guru_mapel', [
            'user_id' => $guru->id,
            'mapel_id' => $this->mapel2->id,
        ]);
    }

    public function test_admin_can_update_guru_assignments(): void
    {
        $guru = User::create([
            'name' => 'Guru Edit',
            'username' => 'guruedit',
            'password' => bcrypt('password123'),
            'password_plain' => 'password123',
            'role' => 'guru',
            'instansi_id' => $this->sd->id,
        ]);

        $guru->guru_kelas()->sync([$this->kelas1->id]);
        $guru->guru_mapel()->sync([$this->mapel1->id]);

        $response = $this->actingAs($this->admin)->put(route('guru.update', $guru->id), [
            'name' => 'Guru Edit Updated',
            'username' => 'guruedit',
            'role' => 'guru',
            'kelas_ids' => [$this->kelas2->id],
            'mapel_ids' => [$this->mapel1->id, $this->mapel2->id],
        ]);

        $response->assertRedirect(route('guru.index'));

        $this->assertDatabaseMissing('guru_kelas', [
            'user_id' => $guru->id,
            'kelas_id' => $this->kelas1->id,
        ]);
        $this->assertDatabaseHas('guru_kelas', [
            'user_id' => $guru->id,
            'kelas_id' => $this->kelas2->id,
        ]);
        $this->assertDatabaseHas('guru_mapel', [
            'user_id' => $guru->id,
            'mapel_id' => $this->mapel1->id,
        ]);
        $this->assertDatabaseHas('guru_mapel', [
            'user_id' => $guru->id,
            'mapel_id' => $this->mapel2->id,
        ]);
    }

    public function test_guru_portal_nilai_dashboard_only_shows_assigned_kelas_and_mapel(): void
    {
        $guru = User::create([
            'name' => 'Guru Nilai',
            'username' => 'gurunilai',
            'password' => bcrypt('password123'),
            'role' => 'guru',
            'instansi_id' => $this->sd->id,
        ]);

        $guru->guru_kelas()->sync([$this->kelas1->id]);
        $guru->guru_mapel()->sync([$this->mapel1->id]);

        $response = $this->withSession(['portalnilai_user_id' => $guru->id])
            ->get(route('portalnilai.guru.dashboard'));

        $response->assertStatus(200);

        // Access the variables passed to the view
        $classes = $response->original->getData()['classes'];
        $mapels = $response->original->getData()['mapels'];

        $this->assertCount(1, $classes);
        $this->assertEquals($this->kelas1->id, $classes->first()->id);

        $this->assertCount(1, $mapels);
        $this->assertEquals($this->mapel1->id, $mapels->first()->id);
    }

    public function test_guru_portal_nilai_authorization_on_endpoints(): void
    {
        $guru = User::create([
            'name' => 'Guru Auth',
            'username' => 'guruauth',
            'password' => bcrypt('password123'),
            'role' => 'guru',
            'instansi_id' => $this->sd->id,
        ]);

        // Assign to kelas1 and mapel1 only
        $guru->guru_kelas()->sync([$this->kelas1->id]);
        $guru->guru_mapel()->sync([$this->mapel1->id]);

        $siswaUser = User::create([
            'name' => 'Siswa Test',
            'username' => 'siswa_test',
            'password' => bcrypt('password123'),
            'role' => 'siswa',
            'instansi_id' => $this->sd->id,
        ]);

        $siswa = Siswa::create([
            'user_id' => $siswaUser->id,
            'kelas_id' => $this->kelas1->id,
            'nisn' => '12345678',
            'status' => 'aktif',
        ]);

        // 1. Check assigned: should return 200
        $response = $this->withSession(['portalnilai_user_id' => $guru->id])
            ->get(route('portalnilai.students.get', [
                'kelas_id' => $this->kelas1->id,
                'mapel_id' => $this->mapel1->id,
            ]));
        $response->assertStatus(200);

        // 2. Check unassigned mapel: should return 403
        $response = $this->withSession(['portalnilai_user_id' => $guru->id])
            ->get(route('portalnilai.students.get', [
                'kelas_id' => $this->kelas1->id,
                'mapel_id' => $this->mapel2->id,
            ]));
        $response->assertStatus(403);

        // 3. Check unassigned kelas: should return 403
        $response = $this->withSession(['portalnilai_user_id' => $guru->id])
            ->get(route('portalnilai.students.get', [
                'kelas_id' => $this->kelas2->id,
                'mapel_id' => $this->mapel1->id,
            ]));
        $response->assertStatus(403);

        // 4. Save grades unassigned: should return 403
        $response = $this->withSession(['portalnilai_user_id' => $guru->id])
            ->post(route('portalnilai.grades.save'), [
                'kelas_id' => $this->kelas2->id,
                'mapel_id' => $this->mapel1->id,
                'payload' => [
                    [
                        'siswa_id' => $siswa->id,
                        'tugas_1' => 85,
                    ]
                ],
            ]);
        $response->assertStatus(403);
    }

    public function test_guru_can_login_to_portal_nilai_with_various_credentials(): void
    {
        $guru = User::create([
            'name' => 'Guru Login Test',
            'username' => 'gurulog',
            'duk' => '199006152015041002',
            'password' => Hash::make('password123'),
            'role' => 'guru',
            'instansi_id' => $this->sd->id,
        ]);

        // 1. Login with username & password
        $response = $this->post(route('portalnilai.login'), [
            'role' => 'guru',
            'username' => 'gurulog',
            'password' => 'password123',
        ]);
        $response->assertRedirect(route('portalnilai.dashboard'));
        $this->assertEquals($guru->id, session('portalnilai_user_id'));
        session()->forget('portalnilai_user_id');

        // 2. Login with DUK as username & password
        $response = $this->post(route('portalnilai.login'), [
            'role' => 'guru',
            'username' => '199006152015041002',
            'password' => 'password123',
        ]);
        $response->assertRedirect(route('portalnilai.dashboard'));
        $this->assertEquals($guru->id, session('portalnilai_user_id'));
        session()->forget('portalnilai_user_id');

        // 3. Login with username & DUK as password
        $response = $this->post(route('portalnilai.login'), [
            'role' => 'guru',
            'username' => 'gurulog',
            'password' => '199006152015041002',
        ]);
        $response->assertRedirect(route('portalnilai.dashboard'));
        $this->assertEquals($guru->id, session('portalnilai_user_id'));
        session()->forget('portalnilai_user_id');

        // 4. Login with DUK as username & DUK as password
        $response = $this->post(route('portalnilai.login'), [
            'role' => 'guru',
            'username' => '199006152015041002',
            'password' => '199006152015041002',
        ]);
        $response->assertRedirect(route('portalnilai.dashboard'));
        $this->assertEquals($guru->id, session('portalnilai_user_id'));
    }
}
