<?php

namespace App\Http\Controllers\ControllerSubMenuApps\EJournal;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Dispatch user to their role-specific dashboard.
     */
    public function index()
    {
        $user = User::find(session('ejournal_user_id'));
        
        if ($user && in_array($user->role, ['guru', 'wali_kelas', 'pembimbing'])) {
            return redirect()->route('ejournal.guru.isi');
        }
        
        return redirect()->route('ejournal.admin.index');
    }
}
