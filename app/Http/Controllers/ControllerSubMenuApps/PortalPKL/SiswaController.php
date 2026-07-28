<?php

namespace App\Http\Controllers\ControllerSubMenuApps\PortalPKL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->get('portalpklUser');
        if ($user->role !== 'siswa') {
            return redirect()->route('portalpkl.index');
        }

        $user->load(['siswa.mitra.pembimbings', 'siswa.kelas', 'instansi']);

        // Get total statistics for the dashboard
        $totalHadir = \App\Models\PklAttendance::where('siswa_id', $user->siswa->id ?? null)->where('status', 'Hadir')->count();
        $totalSakit = \App\Models\PklAttendance::where('siswa_id', $user->siswa->id ?? null)->where('status', 'Sakit')->count();
        $totalIzin = \App\Models\PklAttendance::where('siswa_id', $user->siswa->id ?? null)->where('status', 'Izin')->count();
        $totalPresensi = $totalHadir + $totalSakit + $totalIzin;
        
        $todayAttendance = \App\Models\PklAttendance::where('siswa_id', $user->siswa->id ?? null)
            ->whereDate('tanggal', today())
            ->first();

        return view('PorosDataHome.SubMenuApplication.PortalPKL.siswa', compact('user', 'totalHadir', 'totalSakit', 'totalIzin', 'totalPresensi', 'todayAttendance'));
    }

    public function kehadiran(Request $request)
    {
        $user = $request->get('portalpklUser');
        if ($user->role !== 'siswa') {
            return redirect()->route('portalpkl.index');
        }

        $user->load(['siswa.mitra.pembimbings']);
        $siswa = $user->siswa;
        if (!$siswa || !$siswa->mitra_dudi_id) {
            return view('PorosDataHome.SubMenuApplication.PortalPKL.siswa.kehadiran', [
                'user' => $user,
                'siswa' => $siswa,
                'todayAttendance' => null,
                'error_message' => 'Anda belum ditempatkan di Mitra DU/DI (Tempat PKL). Silakan hubungi admin sekolah.'
            ]);
        }

        $todayAttendance = \App\Models\PklAttendance::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->first();

        // Get history of student attendance
        $historyAttendances = \App\Models\PklAttendance::where('siswa_id', $siswa->id)
            ->orderBy('tanggal', 'desc')
            ->take(15)
            ->get();

        return view('PorosDataHome.SubMenuApplication.PortalPKL.siswa.kehadiran', compact('user', 'siswa', 'todayAttendance', 'historyAttendances'));
    }

    public function storeKehadiran(Request $request)
    {
        $user = $request->get('portalpklUser');
        if ($user->role !== 'siswa') {
            return redirect()->route('portalpkl.index');
        }

        $siswa = $user->siswa;
        if (!$siswa || !$siswa->mitra_dudi_id) {
            return back()->with('error', 'Anda belum ditempatkan di tempat PKL.');
        }

        // Check if already submitted today
        $todayAttendance = \App\Models\PklAttendance::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->first();

        if ($todayAttendance) {
            return back()->with('error', 'Anda sudah melakukan presensi hari ini.');
        }

        $request->validate([
            'status' => ['required', 'string', 'in:Hadir,Sakit,Izin'],
            'journal_kegiatan' => ['required_if:status,Hadir', 'nullable', 'string'],
            'koordinat' => ['required_if:status,Hadir', 'nullable', 'string'],
            'keterangan' => ['required_if:status,Sakit', 'required_if:status,Izin', 'nullable', 'string'],
            'foto_file' => ['nullable', 'image', 'max:5120'], // max 5MB
            'lampiran_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'foto_uri' => ['nullable', 'string'], // base64 string from camera
        ]);

        $foto_path = null;

        // Process photo upload
        if ($request->input('status') === 'Hadir') {
            if ($request->input('foto_source') === 'camera' && $request->input('foto_uri')) {
                // Decode base64 camera image
                $image_data = $request->input('foto_uri');
                $image_data = str_replace('data:image/jpeg;base64,', '', $image_data);
                $image_data = str_replace('data:image/png;base64,', '', $image_data);
                $image_data = str_replace(' ', '+', $image_data);
                $image_name = 'cam_' . time() . '_' . \Illuminate\Support\Str::random(10) . '.jpg';
                
                \Illuminate\Support\Facades\Storage::disk('public')->put('pkl_presensi/' . $image_name, base64_decode($image_data));
                $foto_path = 'pkl_presensi/' . $image_name;
            } elseif ($request->hasFile('foto_file')) {
                $foto_path = $request->file('foto_file')->store('pkl_presensi', 'public');
            }
        } else {
            // For Sakit / Izin, optional attachment (like doctor letter)
            if ($request->hasFile('lampiran_file')) {
                $foto_path = $request->file('lampiran_file')->store('pkl_presensi', 'public');
            }
        }

        \App\Models\PklAttendance::create([
            'siswa_id' => $siswa->id,
            'tanggal' => today()->toDateString(),
            'status' => $request->input('status'),
            'foto' => $foto_path,
            'koordinat' => $request->input('status') === 'Hadir' ? $request->input('koordinat') : null,
            'journal_kegiatan' => $request->input('status') === 'Hadir' ? $request->input('journal_kegiatan') : null,
            'keterangan' => $request->input('status') !== 'Hadir' ? $request->input('keterangan') : null,
        ]);

        return redirect()->route('portalpkl.siswa.kehadiran')
            ->with('success', 'Presensi hari ini (' . $request->input('status') . ') berhasil disimpan.');
    }

    public function riwayat(Request $request)
    {
        $user = $request->get('portalpklUser');
        if ($user->role !== 'siswa') {
            return redirect()->route('portalpkl.index');
        }

        $siswa = $user->siswa;
        if (!$siswa) {
            return redirect()->route('portalpkl.siswa');
        }

        // Fetch all attendances of the student paginated
        $attendances = \App\Models\PklAttendance::where('siswa_id', $siswa->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(15);

        return view('PorosDataHome.SubMenuApplication.PortalPKL.siswa.riwayat', compact('user', 'siswa', 'attendances'));
    }
}
