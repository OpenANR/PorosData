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

        $mitraIds = $user->mitras->pluck('id');
        $siswaIds = \App\Models\Siswa::whereIn('mitra_dudi_id', $mitraIds)->pluck('id');
        $siswaCount = $siswaIds->count();
        $mitraCount = $mitraIds->count();

        $today = today()->toDateString();
        $hadir = \App\Models\PklAttendance::whereIn('siswa_id', $siswaIds)->where('tanggal', $today)->where('status', 'Hadir')->count();
        $sakit = \App\Models\PklAttendance::whereIn('siswa_id', $siswaIds)->where('tanggal', $today)->where('status', 'Sakit')->count();
        $izin = \App\Models\PklAttendance::whereIn('siswa_id', $siswaIds)->where('tanggal', $today)->where('status', 'Izin')->count();
        $belumPresensi = max(0, $siswaCount - ($hadir + $sakit + $izin));

        return view('PorosDataHome.SubMenuApplication.PortalPKL.pembimbing', compact(
            'user', 
            'siswaCount', 
            'mitraCount',
            'hadir',
            'sakit',
            'izin',
            'belumPresensi'
        ));
    }

    public function monitoring(Request $request)
    {
        $user = $request->get('portalpklUser');
        if ($user->role !== 'pembimbing') {
            return redirect()->route('portalpkl.index');
        }

        $search = $request->input('search');
        $status = $request->input('status');
        $tanggal = $request->input('tanggal', today()->toDateString()); // Default filter to today

        // Get the mitras and student IDs assigned to this pembimbing
        $mitraIds = $user->mitras->pluck('id');
        $siswaIds = \App\Models\Siswa::whereIn('mitra_dudi_id', $mitraIds)->pluck('id');

        // Base Query
        $query = \App\Models\PklAttendance::whereIn('siswa_id', $siswaIds)
            ->with(['siswa.user', 'siswa.kelas', 'siswa.mitra.pembimbings']);

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

        // Get statistics scoped to this pembimbing's students
        $statDate = $tanggal ?: today()->toDateString();
        $totalSiswa = $siswaIds->count();
        
        $hadir = \App\Models\PklAttendance::whereIn('siswa_id', $siswaIds)->where('tanggal', $statDate)->where('status', 'Hadir')->count();
        $sakit = \App\Models\PklAttendance::whereIn('siswa_id', $siswaIds)->where('tanggal', $statDate)->where('status', 'Sakit')->count();
        $izin = \App\Models\PklAttendance::whereIn('siswa_id', $siswaIds)->where('tanggal', $statDate)->where('status', 'Izin')->count();

        $stats = [
            'date' => $statDate,
            'hadir' => $hadir,
            'sakit' => $sakit,
            'izin' => $izin,
            'total_siswa' => $totalSiswa,
            'belum_presensi' => max(0, $totalSiswa - ($hadir + $sakit + $izin)),
        ];

        return view('PorosDataHome.SubMenuApplication.PortalPKL.pembimbing.monitoring', compact('user', 'attendances', 'stats', 'search', 'status', 'tanggal'));
    }

    public function destroyKehadiran(Request $request, $id)
    {
        $user = $request->get('portalpklUser');
        if ($user->role !== 'pembimbing') {
            return redirect()->route('portalpkl.index');
        }

        $mitraIds = $user->mitras->pluck('id');
        $siswaIds = \App\Models\Siswa::whereIn('mitra_dudi_id', $mitraIds)->pluck('id');

        $attendance = \App\Models\PklAttendance::whereIn('siswa_id', $siswaIds)->findOrFail($id);

        // Delete associated photo if exists
        if ($attendance->foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($attendance->foto);
        }

        $studentName = $attendance->siswa->user->name ?? 'Siswa';
        $attendance->delete();

        return redirect()->route('portalpkl.pembimbing.monitoring')
            ->with('success', 'Data presensi dari ' . $studentName . ' berhasil dihapus.');
    }

    public function siswa(Request $request)
    {
        $user = $request->get('portalpklUser');
        if ($user->role !== 'pembimbing') {
            return redirect()->route('portalpkl.index');
        }

        $search = $request->input('search');

        // Get the mitras assigned to this pembimbing
        $mitraIds = $user->mitras->pluck('id');

        // Query only students assigned to these mitras
        $query = \App\Models\Siswa::whereIn('mitra_dudi_id', $mitraIds)
            ->with(['user', 'kelas', 'mitra.pembimbings']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($qu) use ($search) {
                    $qu->where('name', 'like', '%' . $search . '%')
                      ->orWhere('username', 'like', '%' . $search . '%');
                })->orWhere('nisn', 'like', '%' . $search . '%');
            });
        }

        $siswas = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('PorosDataHome.SubMenuApplication.PortalPKL.pembimbing.siswa', compact('user', 'siswas', 'search'));
    }
}
