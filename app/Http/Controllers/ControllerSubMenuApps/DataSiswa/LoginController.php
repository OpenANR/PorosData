<?php

namespace App\Http\Controllers\ControllerSubMenuApps\DataSiswa;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show the login form for Data Siswa.
     */
    public function showLoginForm()
    {
        if (session()->has('datasiswa_user_id')) {
            return redirect()->route('datasiswa.index');
        }
        return view('PorosDataHome.SubMenuApplication.DataSiswa.login');
    }

    /**
     * Handle authentication for Data Siswa.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username_or_duk' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $usernameOrDuk = $request->input('username_or_duk');
        $password = $request->input('password');

        // Look up user by username or DUK code
        $user = User::where('username', $usernameOrDuk)
            ->orWhere('duk', $usernameOrDuk)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            // Verify if the role is allowed to access Data Siswa
            // Exclusive only to wali_kelas, admin, and superadmin
            if (in_array($user->role, ['superadmin', 'admin', 'wali_kelas'])) {
                session(['datasiswa_user_id' => $user->id]);
                
                return redirect()->route('datasiswa.index')
                    ->with('success', 'Selamat datang di Portal Data Siswa, ' . $user->name . '!');
            }

            return back()->withErrors([
                'username_or_duk' => 'Akses ditolak. Halaman ini eksklusif hanya untuk Wali Kelas dan Admin.',
            ])->onlyInput('username_or_duk');
        }

        return back()->withErrors([
            'username_or_duk' => 'Username/Kode DUK atau Password salah.',
        ])->onlyInput('username_or_duk');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        session()->forget('datasiswa_user_id');
        
        return redirect()->route('datasiswa.login')
            ->with('success', 'Anda telah berhasil keluar dari Portal Data Siswa.');
    }
}
