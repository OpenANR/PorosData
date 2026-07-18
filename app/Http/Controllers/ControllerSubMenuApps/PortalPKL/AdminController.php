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

        // Calculate attendance stats for today
        $todayHadir = \App\Models\PklAttendance::whereDate('tanggal', today())->where('status', 'Hadir')->count();
        $todaySakit = \App\Models\PklAttendance::whereDate('tanggal', today())->where('status', 'Sakit')->count();
        $todayIzin = \App\Models\PklAttendance::whereDate('tanggal', today())->where('status', 'Izin')->count();

        return view('PorosDataHome.SubMenuApplication.PortalPKL.admin', compact('user', 'mitraCount', 'pembimbingCount', 'siswaCount', 'todayHadir', 'todaySakit', 'todayIzin'));
    }

    public function kehadiran(Request $request)
    {
        $user = $request->get('portalpklUser');
        if ($user->role !== 'admin') {
            return redirect()->route('portalpkl.index');
        }

        $search = $request->input('search');
        $status = $request->input('status');
        $tanggal = $request->input('tanggal', today()->toDateString()); // Default filter to today

        // Base Query
        $query = \App\Models\PklAttendance::with(['siswa.user', 'siswa.kelas', 'siswa.mitra.pembimbings']);

        // Filter by Date
        if ($tanggal) {
            $query->where('tanggal', $tanggal);
        }

        // Filter by Status
        if ($status) {
            $query->where('status', $status);
        }

        // Search by student name or NISN
        if ($search) {
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nisn', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($qu) use ($search) {
                      $qu->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $attendances = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Get overall statistics for the filtered date (or today)
        $statDate = $tanggal ?: today()->toDateString();
        $totalSiswa = \App\Models\Siswa::count();
        $stats = [
            'date' => $statDate,
            'hadir' => \App\Models\PklAttendance::where('tanggal', $statDate)->where('status', 'Hadir')->count(),
            'sakit' => \App\Models\PklAttendance::where('tanggal', $statDate)->where('status', 'Sakit')->count(),
            'izin' => \App\Models\PklAttendance::where('tanggal', $statDate)->where('status', 'Izin')->count(),
            'total_siswa' => $totalSiswa,
        ];
        $stats['belum_presensi'] = max(0, $totalSiswa - ($stats['hadir'] + $stats['sakit'] + $stats['izin']));

        return view('PorosDataHome.SubMenuApplication.PortalPKL.admin.kehadiran', compact('user', 'attendances', 'stats', 'search', 'status', 'tanggal'));
    }

    public function destroyKehadiran(Request $request, $id)
    {
        $user = $request->get('portalpklUser');
        if ($user->role !== 'admin') {
            return redirect()->route('portalpkl.index');
        }

        $attendance = \App\Models\PklAttendance::findOrFail($id);

        // Delete associated photo if exists
        if ($attendance->foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($attendance->foto);
        }

        $studentName = $attendance->siswa->user->name ?? 'Siswa';
        $attendance->delete();

        return redirect()->route('portalpkl.admin.kehadiran')
            ->with('success', 'Data presensi dari ' . $studentName . ' berhasil dihapus.');
    }
}
