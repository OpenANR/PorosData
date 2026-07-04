<?php

namespace App\Http\Controllers\ControllerSubMenuApps\PortalPKL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembimbingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->get('portalpklUser');
        if ($user->role !== 'pembimbing') {
            return redirect()->route('portalpkl.index');
        }
        return view('PorosDataHome.SubMenuApplication.PortalPKL.pembimbing', compact('user'));
    }
}
