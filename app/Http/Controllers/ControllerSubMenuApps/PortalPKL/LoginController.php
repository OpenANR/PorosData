<?php

namespace App\Http\Controllers\ControllerSubMenuApps\PortalPKL;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show the login form for Portal PKL.
     */
    public function showLoginForm()
    {
        if (session()->has('portalpkl_user_id')) {
            return redirect()->route('portalpkl.index');
        }
        return view('PorosDataHome.SubMenuApplication.PortalPKL.login');
    }

    /**
     * Handle authentication for Portal PKL.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        // Look up user by username
        $user = User::where('username', $username)->first();

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
            // Verify if the role is allowed to access Portal PKL
            if (in_array($user->role, ['superadmin', 'admin', 'pembimbing', 'siswa'])) {
                session(['portalpkl_user_id' => $user->id]);
                
                return redirect()->route('portalpkl.index')
                    ->with('success', 'Selamat datang di Portal PKL, ' . $user->name . '!');
            }

            return back()->withErrors([
                'username' => 'Akses ditolak. Peran Anda tidak diizinkan mengakses Portal PKL.',
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
        session()->forget('portalpkl_user_id');
        
        return redirect()->route('portalpkl.login')
            ->with('success', 'Anda telah berhasil keluar dari Portal PKL.');
    }
}
