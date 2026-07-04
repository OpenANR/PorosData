<?php

namespace App\Http\Controllers\ControllerSubMenuApps\PortalPKL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Redirect to the respective role's dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->get('portalpklUser');

        if (!$user) {
            return redirect()->route('portalpkl.login');
        }

        switch ($user->role) {
            case 'superadmin':
                return redirect()->route('portalpkl.superadmin');
            case 'admin':
                return redirect()->route('portalpkl.admin');
            case 'pembimbing':
                return redirect()->route('portalpkl.pembimbing');
            case 'siswa':
                return redirect()->route('portalpkl.siswa');
            default:
                session()->forget('portalpkl_user_id');
                return redirect()->route('portalpkl.login')->withErrors([
                    'username' => 'Role Anda tidak memiliki hak akses.',
                ]);
        }
    }
}
