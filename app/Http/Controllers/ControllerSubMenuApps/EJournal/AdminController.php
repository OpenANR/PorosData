<?php

namespace App\Http\Controllers\ControllerSubMenuApps\EJournal;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Journal;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show all submitted journals (Data Jurnal Masuk).
     */
    public function index()
    {
        $userId = session('ejournal_user_id');
        $user = User::find($userId);

        if (!$user || !in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('ejournal.guru.isi');
        }

        // Fetch all journals submitted in the database
        $journals = Journal::with(['user', 'kelas', 'attendances.siswa.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('PorosDataHome.SubMenuApplication.E-Journal.admin.index', compact('journals', 'user'));
    }

    /**
     * Show teachers list (Kelola Guru - Read Only).
     */
    public function kelolaGuru()
    {
        $userId = session('ejournal_user_id');
        $user = User::find($userId);

        if (!$user || !in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('ejournal.guru.isi');
        }

        // Fetch all teachers in the database
        $teachers = User::whereIn('role', ['guru', 'wali_kelas'])->get();

        return view('PorosDataHome.SubMenuApplication.E-Journal.admin.guru', compact('teachers', 'user'));
    }

    /**
     * Show students list (Kelola Siswa - Read Only) with class filter.
     */
    public function kelolaSiswa(Request $request)
    {
        $userId = session('ejournal_user_id');
        $user = User::find($userId);

        if (!$user || !in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('ejournal.guru.isi');
        }

        // Fetch all classes for the filter dropdown
        $classes = Kelas::all();

        // Filter by class if selected
        $kelasId = $request->input('kelas_id');

        $query = Siswa::with(['user', 'kelas']);

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $students = $query->get();

        return view('PorosDataHome.SubMenuApplication.E-Journal.admin.siswa', compact('students', 'classes', 'kelasId', 'user'));
    }
}
