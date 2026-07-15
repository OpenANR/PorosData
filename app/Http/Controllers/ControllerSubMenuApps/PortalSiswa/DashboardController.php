<?php

namespace App\Http\Controllers\ControllerSubMenuApps\PortalSiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the student portal dashboard with full identity details.
     */
    public function index(Request $request)
    {
        $user = $request->get('portalsiswaUser');
        
        // Ensure relations are fully loaded
        $user->load(['siswa.kelas.wali_kelas']);
        
        $siswa = $user->siswa;
        
        return view('PorosDataHome.SubMenuApplication.PortalSiswa.dashboard', compact('user', 'siswa'));
    }
}
