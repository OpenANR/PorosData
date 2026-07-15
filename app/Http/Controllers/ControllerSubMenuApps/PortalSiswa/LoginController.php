<?php

namespace App\Http\Controllers\ControllerSubMenuApps\PortalSiswa;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show the login form for Portal Siswa.
     */
    public function showLoginForm()
    {
        if (session()->has('portalsiswa_user_id')) {
            return redirect()->route('portalsiswa.dashboard');
        }
        return view('PorosDataHome.SubMenuApplication.PortalSiswa.login');
    }

    /**
     * Handle authentication for Portal Siswa.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username_or_nisn' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $usernameOrNisn = $request->input('username_or_nisn');
        $password = $request->input('password');

        // Look up by username first
        $user = User::where('username', $usernameOrNisn)->first();

        // If not found, look up by NISN in siswa table
        if (!$user) {
            $siswa = Siswa::where('nisn', $usernameOrNisn)->first();
            if ($siswa) {
                $user = $siswa->user;
            }
        }

        $passwordIsValid = false;
        if ($user) {
            if (strpos($user->password, '$2y$') === 0) {
                try {
                    $passwordIsValid = Hash::check($password, $user->password);
                } catch (\RuntimeException $e) {
                    $passwordIsValid = false;
                }
            }
            if (!$passwordIsValid && $password === $user->password) {
                $passwordIsValid = true;
            }
        }

        if ($user && $passwordIsValid) {
            // Verify if the role is 'siswa'
            if ($user->role === 'siswa') {
                session(['portalsiswa_user_id' => $user->id]);
                
                return redirect()->route('portalsiswa.dashboard')
                    ->with('success', 'Selamat datang di Portal Siswa, ' . $user->name . '!');
            }

            return back()->withErrors([
                'username_or_nisn' => 'Akses ditolak. Portal ini khusus untuk Siswa.',
            ])->onlyInput('username_or_nisn');
        }

        return back()->withErrors([
            'username_or_nisn' => 'Username/NISN atau Password salah.',
        ])->onlyInput('username_or_nisn');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        session()->forget('portalsiswa_user_id');
        
        return redirect()->route('portalsiswa.login')
            ->with('success', 'Anda telah berhasil keluar dari Portal Siswa.');
    }
}
