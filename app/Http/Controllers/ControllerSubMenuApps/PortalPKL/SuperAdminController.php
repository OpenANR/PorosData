<?php

namespace App\Http\Controllers\ControllerSubMenuApps\PortalPKL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->get('portalpklUser');
        if ($user->role !== 'superadmin') {
            return redirect()->route('portalpkl.index');
        }
        return view('PorosDataHome.SubMenuApplication.PortalPKL.superadmin', compact('user'));
    }
}
