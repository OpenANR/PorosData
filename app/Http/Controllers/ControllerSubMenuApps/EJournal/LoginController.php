<?php

namespace App\Http\Controllers\ControllerSubMenuApps\EJournal;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show the login form for E-Journal.
     */
    public function showLoginForm()
    {
        if (session()->has('ejournal_user_id')) {
            return redirect()->route('ejournal.index');
        }
        return view('PorosDataHome.SubMenuApplication.E-Journal.login');
    }

    /**
     * Handle authentication for E-Journal.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username_or_duk' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $usernameOrDuk = $request->input('username_or_duk');
        $password = $request->input('password');

        // Look up user by username or duk
        $user = User::where('username', $usernameOrDuk)
            ->orWhere('duk', $usernameOrDuk)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            // Verify if the role is allowed to access e-journal
            if (in_array($user->role, ['superadmin', 'admin', 'guru', 'wali_kelas'])) {
                session(['ejournal_user_id' => $user->id]);
                
                return redirect()->route('ejournal.index')
                    ->with('success', 'Selamat datang di E-Journal, ' . $user->name . '!');
            }

            return back()->withErrors([
                'username_or_duk' => 'Akses ditolak. Peran Anda tidak diizinkan mengakses E-Journal.',
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
        session()->forget('ejournal_user_id');
        
        return redirect()->route('ejournal.login')
            ->with('success', 'Anda telah berhasil keluar dari E-Journal.');
    }
}
