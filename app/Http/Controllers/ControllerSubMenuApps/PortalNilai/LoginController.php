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
            'role' => ['required', 'string', 'in:guru,wali_kelas,admin'],
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $role = $request->input('role');
        $username = $request->input('username');
        $password = $request->input('password');

        // Check if Administrator and matches dummy credentials
        if ($role === 'admin') {
            if ($username === 'admin_nilai' && $password === 'admin123') {
                session(['portalnilai_user_id' => 'dummy_admin']);
                return redirect()->route('portalnilai.dashboard')
                    ->with('success', 'Selamat datang di Portal Nilai (Administrator Dummy)!');
            }
        }

        // Look up user in the database by username or DUK code
        $user = User::where(function($q) use ($username) {
            $q->where('username', $username)
              ->orWhere('duk', $username);
        })->first();

        // Allow password check using either actual hashed password or DUK code matching plain password
        if ($user && (Hash::check($password, $user->password) || ($user->duk && $password === $user->duk))) {
            // Verify if the role matches the selected role
            // Guru Pengajar can be 'guru', Wali Kelas must be 'wali_kelas', Administrator must be 'admin' or 'superadmin'
            $roleIsValid = false;
            if ($role === 'guru' && $user->role === 'guru') {
                $roleIsValid = true;
            } elseif ($role === 'wali_kelas' && $user->role === 'wali_kelas') {
                $roleIsValid = true;
            } elseif ($role === 'admin' && in_array($user->role, ['admin', 'superadmin'])) {
                $roleIsValid = true;
            }

            if ($roleIsValid) {
                session(['portalnilai_user_id' => $user->id]);
                return redirect()->route('portalnilai.dashboard')
                    ->with('success', 'Selamat datang di Portal Nilai, ' . $user->name . '!');
            }

            return back()->withErrors([
                'username' => 'Akses ditolak. Peran Anda tidak sesuai dengan opsi login yang dipilih.',
            ])->onlyInput('username', 'role');
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah.',
        ])->onlyInput('username', 'role');
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
