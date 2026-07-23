<?php

namespace App\Http\Controllers\ControllerSubMenuApps\PortalNilai;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show the login form for Portal Nilai.
     */
    public function showLoginForm()
    {
        if (session()->has('portalnilai_user_id')) {
            return redirect()->route('portalnilai.dashboard');
        }
        return view('PorosDataHome.SubMenuApplication.PortalNilai.login');
    }

    /**
     * Handle authentication for Portal Nilai.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        // Check if Administrator and matches dummy credentials
        if ($username === 'admin_nilai' && $password === 'admin123') {
            session(['portalnilai_user_id' => 'dummy_admin']);
            return redirect()->route('portalnilai.dashboard')
                ->with('success', 'Selamat datang di Portal Nilai (Administrator Dummy)!');
        }

        // Look up user in the database by username or DUK code
        $user = User::where(function($q) use ($username) {
            $q->where('username', $username)
              ->orWhere('duk', $username);
        })->first();

        $passwordIsValid = false;
        if ($user) {
            if (strpos($user->password, '$2y$') === 0) {
                try {
                    $passwordIsValid = Hash::check($password, $user->password);
                } catch (\RuntimeException $e) {
                    $passwordIsValid = false;
                }
            }
            if (!$passwordIsValid && ($password === $user->password || ($user->duk && $password === $user->duk))) {
                $passwordIsValid = true;
            }
        }

        // Allow password check using either actual hashed password or DUK code matching plain password
        if ($user && $passwordIsValid) {
            // Verify if the role is allowed to access Portal Nilai
            if (in_array($user->role, ['superadmin', 'admin', 'guru', 'wali_kelas'])) {
                session(['portalnilai_user_id' => $user->id]);
                return redirect()->route('portalnilai.dashboard')
                    ->with('success', 'Selamat datang di Portal Nilai, ' . $user->name . '!');
            }

            return back()->withErrors([
                'username' => 'Akses ditolak. Peran Anda tidak diizinkan untuk mengakses Portal Nilai.',
            ])->onlyInput('username');
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah.',
        ])->onlyInput('username');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        session()->forget('portalnilai_user_id');
        
        return redirect()->route('portalnilai.login')
            ->with('success', 'Anda telah berhasil keluar dari Portal Nilai.');
    }
}
