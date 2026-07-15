<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Instansi;
use App\Models\Kelas;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class WaliKelasCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $sd;

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
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'instansi_id' => $this->sd->id,
        ]);
    }

    /**
     * Test admin can create wali_kelas and password is stored as plain-text.
     */
    public function test_admin_can_create_wali_kelas_with_plain_text_password(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('walikelas.store'), [
                'name' => 'Wali Kelas Test',
                'duk' => '99998888',
                'password' => 'myplaintextpassword',
                'kelas_diampu' => 'Kelas 1A',
            ]);

        $response->assertRedirect(route('walikelas.index'));

        // Retrieve created user
        $user = User::where('duk', '99998888')->first();
        $this->assertNotNull($user);
        $this->assertEquals('myplaintextpassword', $user->password);
    }

    /**
     * Test admin can update wali_kelas and password is saved as plain-text.
     */
    public function test_admin_can_update_wali_kelas_with_plain_text_password(): void
    {
        $user = User::create([
            'name' => 'Old Name',
            'username' => '88887777',
            'duk' => '88887777',
            'password' => 'oldpassword',
            'role' => 'wali_kelas',
            'instansi_id' => $this->sd->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->put(route('walikelas.update', $user->id), [
                'name' => 'Updated Name',
                'duk' => '88887777',
                'password' => 'newplaintextpassword',
                'kelas_diampu' => 'Kelas 1B',
            ]);

        $response->assertRedirect(route('walikelas.index'));

        $user->refresh();
        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('newplaintextpassword', $user->password);
    }

    /**
     * Test logging in via sub-menu apps logins works with plain text password.
     */
    public function test_wali_kelas_can_login_using_plain_text_password(): void
    {
        $user = User::create([
            'name' => 'Wali Kelas Login Test',
            'username' => '77776666',
            'duk' => '77776666',
            'password' => 'secret123',
            'role' => 'wali_kelas',
            'instansi_id' => $this->sd->id,
        ]);

        // 1. DataSiswa Login
        $response = $this->post('/porosdata/datasiswa/login', [
            'username_or_duk' => '77776666',
            'password' => 'secret123',
        ]);
        $response->assertRedirect(route('datasiswa.index'));
        $this->assertEquals($user->id, session('datasiswa_user_id'));

        // Reset session
        session()->forget('datasiswa_user_id');

        // 2. PortalNilai Login
        $response = $this->post('/porosdata/portalnilai/login', [
            'role' => 'wali_kelas',
            'username' => '77776666',
            'password' => 'secret123',
        ]);
        $response->assertRedirect(route('portalnilai.dashboard'));
        $this->assertEquals($user->id, session('portalnilai_user_id'));

        // Reset session
        session()->forget('portalnilai_user_id');

        // 3. EJournal Login
        $response = $this->post('/porosdata/e-journal/login', [
            'username_or_duk' => '77776666',
            'password' => 'secret123',
        ]);
        $response->assertRedirect(route('ejournal.index'));
        $this->assertEquals($user->id, session('ejournal_user_id'));
    }

    /**
     * Test import CSV saves passwords as plain-text.
     */
    public function test_csv_import_saves_wali_kelas_passwords_as_plain_text(): void
    {
        $csvContent = "kode_duk,password,nama,kelas_ditugaskan\n";
        $csvContent .= "66665555,csvpassword123,Wali Kelas CSV,Kelas 2A\n";

        $file = UploadedFile::fake()->createWithContent('walikelas.csv', $csvContent);

        $response = $this->actingAs($this->admin)
            ->post(route('walikelas.import'), [
                'file_csv' => $file,
            ]);

        $response->assertRedirect(route('walikelas.index'));

        $user = User::where('duk', '66665555')->first();
        $this->assertNotNull($user);
        $this->assertEquals('Wali Kelas CSV', $user->name);
        $this->assertEquals('csvpassword123', $user->password);
    }
}
