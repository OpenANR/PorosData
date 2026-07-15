<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Instansi;
use Illuminate\Support\Facades\Hash;

class PortalSiswaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login page loads successfully.
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get(route('portalsiswa.login'));

        $response->assertStatus(200);
        $response->assertSee('Portal Siswa');
        $response->assertSee('SDN 01 Poros Data');
    }

    /**
     * Test dashboard is protected by middleware.
     */
    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get(route('portalsiswa.dashboard'));

        $response->assertRedirect(route('portalsiswa.login'));
    }

    /**
     * Test logging in via username works.
     */
    public function test_student_can_login_using_username(): void
    {
        $instansi = Instansi::create([
            'nama_sekolah' => 'SD Negeri 01 Poros Data',
            'tingkat' => 'SD',
        ]);

        $kelas = Kelas::create([
            'instansi_id' => $instansi->id,
            'nama_kelas' => 'VI A',
        ]);

        $user = User::create([
            'name' => 'Siswa Test',
            'username' => 'siswatest',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);

        $siswa = Siswa::create([
            'user_id' => $user->id,
            'kelas_id' => $kelas->id,
            'nisn' => '99887766',
            'status' => 'aktif',
        ]);

        $response = $this->post('/porosdata/portalsiswa/login', [
            'username_or_nisn' => 'siswatest',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('portalsiswa.dashboard'));
        $this->assertEquals($user->id, session('portalsiswa_user_id'));
    }

    /**
     * Test logging in via NISN works.
     */
    public function test_student_can_login_using_nisn(): void
    {
        $instansi = Instansi::create([
            'nama_sekolah' => 'SD Negeri 01 Poros Data',
            'tingkat' => 'SD',
        ]);

        $kelas = Kelas::create([
            'instansi_id' => $instansi->id,
            'nama_kelas' => 'VI A',
        ]);

        $user = User::create([
            'name' => 'Siswa Test',
            'username' => 'siswatest',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);

        $siswa = Siswa::create([
            'user_id' => $user->id,
            'kelas_id' => $kelas->id,
            'nisn' => '99887766',
            'status' => 'aktif',
        ]);

        $response = $this->post('/porosdata/portalsiswa/login', [
            'username_or_nisn' => '99887766',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('portalsiswa.dashboard'));
        $this->assertEquals($user->id, session('portalsiswa_user_id'));
    }

    /**
     * Test login failure for non-siswa role.
     */
    public function test_non_student_cannot_login_to_student_portal(): void
    {
        $user = User::create([
            'name' => 'Guru Test',
            'username' => 'gurutest',
            'password' => Hash::make('password123'),
            'role' => 'guru',
        ]);

        $response = $this->post('/porosdata/portalsiswa/login', [
            'username_or_nisn' => 'gurutest',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('username_or_nisn');
        $this->assertNull(session('portalsiswa_user_id'));
    }

    /**
     * Test login failure with incorrect credentials.
     */
    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::create([
            'name' => 'Siswa Test',
            'username' => 'siswatest',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);

        $response = $this->post('/porosdata/portalsiswa/login', [
            'username_or_nisn' => 'siswatest',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('username_or_nisn');
        $this->assertNull(session('portalsiswa_user_id'));
    }

    /**
     * Test logout deletes the independent session key.
     */
    public function test_student_can_logout(): void
    {
        $user = User::create([
            'name' => 'Siswa Test',
            'username' => 'siswatest',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);

        $this->withSession(['portalsiswa_user_id' => $user->id]);

        $response = $this->post(route('portalsiswa.logout'));

        $response->assertRedirect(route('portalsiswa.login'));
        $this->assertNull(session('portalsiswa_user_id'));
    }
}
