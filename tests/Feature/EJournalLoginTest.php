<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EJournalLoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login page loads successfully.
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get(route('ejournal.login'));

        $response->assertStatus(200);
        $response->assertSee('SD Negeri 01 Poros Data');
        $response->assertSee('E-Jurnal Guru');
    }

    /**
     * Test dashboard is protected by middleware.
     */
    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get(route('ejournal.index'));

        $response->assertRedirect(route('ejournal.login'));
    }

    /**
     * Test logging in via username works.
     */
    public function test_user_can_login_using_username(): void
    {
        $user = User::create([
            'name' => 'Pak Budi',
            'username' => 'budi',
            'duk' => '12345',
            'password' => Hash::make('password123'),
            'role' => 'guru',
        ]);

        $response = $this->post('/porosdata/e-journal/login', [
            'username_or_duk' => 'budi',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('ejournal.index'));
        $this->assertEquals($user->id, session('ejournal_user_id'));
    }

    /**
     * Test logging in via DUK code works.
     */
    public function test_user_can_login_using_duk(): void
    {
        $user = User::create([
            'name' => 'Bu Siti',
            'username' => 'siti',
            'duk' => '54321',
            'password' => Hash::make('secretpassword'),
            'role' => 'guru',
        ]);

        $response = $this->post('/porosdata/e-journal/login', [
            'username_or_duk' => '54321',
            'password' => 'secretpassword',
        ]);

        $response->assertRedirect(route('ejournal.index'));
        $this->assertEquals($user->id, session('ejournal_user_id'));
    }

    /**
     * Test login failure with incorrect credentials.
     */
    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::create([
            'name' => 'Bu Siti',
            'username' => 'siti',
            'duk' => '54321',
            'password' => Hash::make('secretpassword'),
            'role' => 'guru',
        ]);

        $response = $this->post('/porosdata/e-journal/login', [
            'username_or_duk' => '54321',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('username_or_duk');
        $this->assertNull(session('ejournal_user_id'));
    }

    /**
     * Test logout deletes the independent session key.
     */
    public function test_user_can_logout(): void
    {
        $user = User::create([
            'name' => 'Bu Siti',
            'username' => 'siti',
            'duk' => '54321',
            'password' => Hash::make('secretpassword'),
            'role' => 'guru',
        ]);

        $this->withSession(['ejournal_user_id' => $user->id]);

        $response = $this->post(route('ejournal.logout'));

        $response->assertRedirect(route('ejournal.login'));
        $this->assertNull(session('ejournal_user_id'));
    }
}
