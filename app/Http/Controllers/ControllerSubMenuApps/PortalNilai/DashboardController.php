<?php

namespace App\Http\Controllers\ControllerSubMenuApps\PortalNilai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the Portal Nilai dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->get('portalnilaiUser');
        return view('PorosDataHome.SubMenuApplication.PortalNilai.dashboard', compact('user'));
    }
}
