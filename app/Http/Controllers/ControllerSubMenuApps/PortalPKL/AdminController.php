<?php

namespace App\Http\Controllers\ControllerSubMenuApps\PortalPKL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->get('portalpklUser');
        if ($user->role !== 'admin') {
            return redirect()->route('portalpkl.index');
        }
        $mitraCount = \App\Models\MitraDudi::count();
        $pembimbingCount = \App\Models\User::where('role', 'pembimbing')->count();
        $siswaCount = \App\Models\Siswa::count();
        return view('PorosDataHome.SubMenuApplication.PortalPKL.admin', compact('user', 'mitraCount', 'pembimbingCount', 'siswaCount'));
    }
}
