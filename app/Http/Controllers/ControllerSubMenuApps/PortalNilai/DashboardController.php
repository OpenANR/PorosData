<?php

namespace App\Http\Controllers\ControllerSubMenuApps\PortalNilai;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Instansi;
use App\Models\PortalNilaiSetting;
use App\Models\PortalNilaiNilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the Portal Nilai dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->get('portalnilaiUser');
        if (!$user) {
            return redirect()->route('portalnilai.login');
        }

        $isAdmin = in_array($user->role, ['admin', 'superadmin']) || $user->id === 999999;
        if ($isAdmin) {
            return redirect()->route('portalnilai.admin.dashboard');
        } elseif ($user->role === 'wali_kelas') {
            return redirect()->route('portalnilai.walikelas.dashboard');
        } elseif ($user->role === 'guru') {
            return redirect()->route('portalnilai.guru.dashboard');
        }

        return redirect()->route('portalnilai.login');
    }

    public function adminDashboard(Request $request)
    {
        $user = $request->get('portalnilaiUser');
        $classes = Kelas::orderBy('nama_kelas', 'asc')->get();
        $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        $totalStudents = Siswa::where('status', 'aktif')->count();
        
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = $sd ? $sd->id : null;
        $accessSettings = PortalNilaiSetting::where('instansi_id', $instansiId)->first();
        if (!$accessSettings) {
            $accessSettings = PortalNilaiSetting::whereNull('instansi_id')->first();
        }

        return view('PorosDataHome.SubMenuApplication.PortalNilai.admin.dashboard', compact('user', 'classes', 'mapels', 'totalStudents', 'accessSettings'));
    }

    public function adminInputNilai(Request $request)
    {
        $user = $request->get('portalnilaiUser');
        $classes = Kelas::orderBy('nama_kelas', 'asc')->get();
        $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();

        return view('PorosDataHome.SubMenuApplication.PortalNilai.admin.inputNilai', compact('user', 'classes', 'mapels'));
    }

    public function adminJadwal(Request $request)
    {
        $user = $request->get('portalnilaiUser');
        return view('PorosDataHome.SubMenuApplication.PortalNilai.admin.jadwal', compact('user'));
    }

    public function walikelasDashboard(Request $request)
    {
        $user = $request->get('portalnilaiUser');
        $classes = Kelas::where('user_id', $user->id)->get();
        
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = $user->instansi_id ?? ($sd ? $sd->id : null);
        
        $mapels = Mapel::where(function($q) use ($instansiId) {
                $q->where('instansi_id', $instansiId)
                  ->orWhereNull('instansi_id');
            })
            ->orderBy('nama_mapel', 'asc')
            ->get();
        if ($mapels->isEmpty()) {
            $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        }

        $totalStudents = Siswa::where('status', 'aktif')
            ->whereHas('kelas', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->count();

        $accessSettings = PortalNilaiSetting::where('instansi_id', $instansiId)->first();
        if (!$accessSettings) {
            $accessSettings = PortalNilaiSetting::whereNull('instansi_id')->first();
        }

        return view('PorosDataHome.SubMenuApplication.PortalNilai.wali_kelas.dashboard', compact('user', 'classes', 'mapels', 'totalStudents', 'accessSettings'));
    }

    public function walikelasViewNilai(Request $request)
    {
        $user = $request->get('portalnilaiUser');
        $classes = Kelas::where('user_id', $user->id)->get();

        return view('PorosDataHome.SubMenuApplication.PortalNilai.wali_kelas.viewNilai', compact('user', 'classes'));
    }

    public function guruDashboard(Request $request)
    {
        $user = $request->get('portalnilaiUser');
        
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = $user->instansi_id ?? ($sd ? $sd->id : null);
        
        // Only get classes assigned to the Guru
        $classes = $user->guru_kelas()
            ->orderBy('nama_kelas', 'asc')
            ->get();
        $classIds = $classes->pluck('id')->toArray();

        // Only get mapels assigned to the Guru
        $mapels = $user->guru_mapel()
            ->orderBy('nama_mapel', 'asc')
            ->get();

        // Total active students in assigned classes
        $totalStudents = Siswa::where('status', 'aktif')
            ->whereIn('kelas_id', $classIds)
            ->count();

        $accessSettings = PortalNilaiSetting::where('instansi_id', $instansiId)->first();
        if (!$accessSettings) {
            $accessSettings = PortalNilaiSetting::whereNull('instansi_id')->first();
        }

        return view('PorosDataHome.SubMenuApplication.PortalNilai.guru.dashboard', compact('user', 'classes', 'mapels', 'totalStudents', 'accessSettings'));
    }

    public function guruInputNilai(Request $request)
    {
        $user = $request->get('portalnilaiUser');
        
        // Only get classes assigned to the Guru
        $classes = $user->guru_kelas()
            ->orderBy('nama_kelas', 'asc')
            ->get();

        // Only get mapels assigned to the Guru
        $mapels = $user->guru_mapel()
            ->orderBy('nama_mapel', 'asc')
            ->get();

        return view('PorosDataHome.SubMenuApplication.PortalNilai.guru.inputNilai', compact('user', 'classes', 'mapels'));
    }

    /**
     * Get access settings for the current instansi.
     */
    public function getSettings(Request $request)
    {
        $user = $request->get('portalnilaiUser');
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = ($user && $user->instansi_id) ? $user->instansi_id : ($sd ? $sd->id : null);

        $settings = PortalNilaiSetting::where('instansi_id', $instansiId)->first();
        if (!$settings) {
            $settings = PortalNilaiSetting::whereNull('instansi_id')->first();
        }

        // Format dates for input field compatibility
        return response()->json([
            'status' => 'success',
            'data' => [
                'tugas_buka' => $settings && $settings->tugas_buka ? date('Y-m-d\TH:i', strtotime($settings->tugas_buka)) : '',
                'tugas_tutup' => $settings && $settings->tugas_tutup ? date('Y-m-d\TH:i', strtotime($settings->tugas_tutup)) : '',
                'asas_buka' => $settings && $settings->asas_buka ? date('Y-m-d\TH:i', strtotime($settings->asas_buka)) : '',
                'asas_tutup' => $settings && $settings->asas_tutup ? date('Y-m-d\TH:i', strtotime($settings->asas_tutup)) : '',
            ]
        ]);
    }

    /**
     * Save access settings.
     */
    public function saveSettings(Request $request)
    {
        $user = $request->get('portalnilaiUser');
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = ($user && $user->instansi_id) ? $user->instansi_id : ($sd ? $sd->id : null);

        $request->validate([
            'tugas_buka' => 'nullable',
            'tugas_tutup' => 'nullable',
            'asas_buka' => 'nullable',
            'asas_tutup' => 'nullable',
        ]);

        $tugas_buka = $request->tugas_buka ? date('Y-m-d H:i:s', strtotime($request->tugas_buka)) : null;
        $tugas_tutup = $request->tugas_tutup ? date('Y-m-d H:i:s', strtotime($request->tugas_tutup)) : null;
        $asas_buka = $request->asas_buka ? date('Y-m-d H:i:s', strtotime($request->asas_buka)) : null;
        $asas_tutup = $request->asas_tutup ? date('Y-m-d H:i:s', strtotime($request->asas_tutup)) : null;

        PortalNilaiSetting::updateOrCreate(
            ['instansi_id' => $instansiId],
            [
                'tugas_buka' => $tugas_buka,
                'tugas_tutup' => $tugas_tutup,
                'asas_buka' => $asas_buka,
                'asas_tutup' => $asas_tutup,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal Akses Penilaian Berhasil Disimpan!'
        ]);
    }

    /**
     * Get student list and existing grades for a class and subject.
     */
    public function getStudentsData(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapel,id',
        ]);

        $user = $request->get('portalnilaiUser');
        $kelas = Kelas::findOrFail($request->kelas_id);
        $instansiId = $kelas->instansi_id;

        // Check if Guru is assigned to requested class and subject
        $isAdmin = ($user && in_array($user->role, ['admin', 'superadmin'])) || ($user && $user->id === 999999);
        if ($user && $user->role === 'guru' && !$isAdmin) {
            $hasKelas = $user->guru_kelas()->where('kelas.id', $request->kelas_id)->exists();
            $hasMapel = $user->guru_mapel()->where('mapel.id', $request->mapel_id)->exists();
            if (!$hasKelas || !$hasMapel) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda tidak memiliki akses ke kelas atau mata pelajaran ini!'
                ], 403);
            }
        }

        // Fetch students in this class
        $students = Siswa::where('kelas_id', $request->kelas_id)
            ->with('user')
            ->get();

        // Fetch subject details
        $mapel = Mapel::with('kategori')->findOrFail($request->mapel_id);
        $mapelType = $mapel->kategori ? $mapel->kategori->nama_kategori : 'Umum';

        // Check if access is open
        $settings = PortalNilaiSetting::where('instansi_id', $instansiId)->first();
        if (!$settings) {
            $settings = PortalNilaiSetting::whereNull('instansi_id')->first();
        }

        $now = now();
        $isAdmin = ($user && in_array($user->role, ['admin', 'superadmin'])) || ($user && $user->id === 999999);
        
        $isAksesBuka = true;
        $isAksesTugasBuka = true;
        if (!$isAdmin && $settings) {
            if (!empty($settings->asas_buka) && !empty($settings->asas_tutup)) {
                $isAksesBuka = ($now->greaterThanOrEqualTo($settings->asas_buka) && $now->lessThanOrEqualTo($settings->asas_tutup));
            }
            if (!empty($settings->tugas_buka) && !empty($settings->tugas_tutup)) {
                $isAksesTugasBuka = ($now->greaterThanOrEqualTo($settings->tugas_buka) && $now->lessThanOrEqualTo($settings->tugas_tutup));
            }
        }

        // Compile students and grades data
        $data = [];
        foreach ($students as $siswa) {
            $nilai = PortalNilaiNilai::where('kelas_id', $request->kelas_id)
                ->where('mapel_id', $request->mapel_id)
                ->where('siswa_id', $siswa->id)
                ->first();

            $data[] = [
                'nisn' => $siswa->nisn,
                'nama' => $siswa->user->name,
                'siswa_id' => $siswa->id,
                'tugas_1' => $nilai ? $nilai->tugas_1 : null,
                'tugas_2' => $nilai ? $nilai->tugas_2 : null,
                'asts' => $nilai ? $nilai->asts : null,
                'tugas_4' => $nilai ? $nilai->tugas_4 : null,
                'tugas_5' => $nilai ? $nilai->tugas_5 : null,
                'mode_asas' => $nilai ? $nilai->mode_asas : 'Benar',
                'pg_asas' => $nilai ? $nilai->pg_asas : '',
                'essai_asas' => $nilai ? $nilai->essai_asas : '',
                'murni_asas' => $nilai ? $nilai->murni_asas : null,
                'perbaikan' => $nilai ? $nilai->perbaikan : null,
                'ketuntasan' => $nilai ? $nilai->ketuntasan : '-',
                'nilai_akhir' => $nilai ? $nilai->nilai_akhir : 0,
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'isAksesBuka' => $isAksesBuka,
            'isAksesTugasBuka' => $isAksesTugasBuka,
            'tipeMapel' => $mapelType
        ]);
    }

    /**
     * Save student grades.
     */
    public function saveGrades(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapel,id',
            'payload' => 'required|array',
        ]);

        $user = $request->get('portalnilaiUser');
        $kelas = Kelas::findOrFail($request->kelas_id);
        $instansiId = $kelas->instansi_id;

        // Access checks if not admin
        $isAdmin = ($user && in_array($user->role, ['admin', 'superadmin'])) || ($user && $user->id === 999999);
        
        // Check if Guru is assigned to requested class and subject
        if ($user && $user->role === 'guru' && !$isAdmin) {
            $hasKelas = $user->guru_kelas()->where('kelas.id', $request->kelas_id)->exists();
            $hasMapel = $user->guru_mapel()->where('mapel.id', $request->mapel_id)->exists();
            if (!$hasKelas || !$hasMapel) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal Menyimpan: Anda tidak memiliki akses ke kelas atau mata pelajaran ini!'
                ], 403);
            }
        }
        if (!$isAdmin) {
            $settings = PortalNilaiSetting::where('instansi_id', $instansiId)->first();
            if (!$settings) {
                $settings = PortalNilaiSetting::whereNull('instansi_id')->first();
            }
            $now = now();
            $isAksesBuka = true;
            if ($settings && !empty($settings->asas_buka) && !empty($settings->asas_tutup)) {
                $isAksesBuka = ($now->greaterThanOrEqualTo($settings->asas_buka) && $now->lessThanOrEqualTo($settings->asas_tutup));
            }
            if (!$isAksesBuka) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal Menyimpan: Waktu Pengisian Nilai Telah Ditutup!'
                ], 403);
            }
        }

        // Loop and save each student grade
        foreach ($request->payload as $item) {
            PortalNilaiNilai::updateOrCreate(
                [
                    'kelas_id' => $request->kelas_id,
                    'mapel_id' => $request->mapel_id,
                    'siswa_id' => $item['siswa_id'],
                ],
                [
                    'user_id' => ($user && $user->id !== 999999) ? $user->id : null,
                    'tugas_1' => ($item['tugas_1'] !== '' && $item['tugas_1'] !== null) ? (float)$item['tugas_1'] : null,
                    'tugas_2' => ($item['tugas_2'] !== '' && $item['tugas_2'] !== null) ? (float)$item['tugas_2'] : null,
                    'asts' => ($item['asts'] !== '' && $item['asts'] !== null) ? (float)$item['asts'] : null,
                    'tugas_4' => ($item['tugas_4'] !== '' && $item['tugas_4'] !== null) ? (float)$item['tugas_4'] : null,
                    'tugas_5' => ($item['tugas_5'] !== '' && $item['tugas_5'] !== null) ? (float)$item['tugas_5'] : null,
                    'mode_asas' => $item['mode_asas'] ?? null,
                    'pg_asas' => $item['pg_asas'] ?? null,
                    'essai_asas' => $item['essai_asas'] ?? null,
                    'murni_asas' => ($item['murni_asas'] !== '' && $item['murni_asas'] !== null) ? (float)$item['murni_asas'] : null,
                    'perbaikan' => ($item['perbaikan'] !== '' && $item['perbaikan'] !== null) ? (float)$item['perbaikan'] : null,
                    'ketuntasan' => $item['ketuntasan'] ?? null,
                    'nilai_akhir' => ($item['nilai_akhir'] !== '' && $item['nilai_akhir'] !== null) ? (float)$item['nilai_akhir'] : null,
                ]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Seluruh Data Nilai Berhasil Disimpan!'
        ]);
    }

    /**
     * Get class summary grades for Wali Kelas (all students, all subjects).
     */
    public function getWaliKelasData(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $user = $request->get('portalnilaiUser');
        $kelas = Kelas::findOrFail($request->kelas_id);
        $instansiId = $kelas->instansi_id;

        // Fetch students in this class
        $students = Siswa::where('kelas_id', $request->kelas_id)
            ->with('user')
            ->get();

        // Fetch all subjects (mapels) in this school
        $mapels = Mapel::where(function($q) use ($instansiId) {
                $q->where('instansi_id', $instansiId)
                  ->orWhereNull('instansi_id');
            })
            ->orderBy('nama_mapel', 'asc')
            ->get();
        if ($mapels->isEmpty()) {
            $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        }

        // Compile student grades for each mapel
        $data = [];
        foreach ($students as $siswa) {
            $grades = [];
            foreach ($mapels as $mapel) {
                $nilai = PortalNilaiNilai::where('kelas_id', $request->kelas_id)
                    ->where('mapel_id', $mapel->id)
                    ->where('siswa_id', $siswa->id)
                    ->first();
                
                $grades[$mapel->id] = $nilai ? $nilai->nilai_akhir : null;
            }

            $data[] = [
                'nisn' => $siswa->nisn,
                'nama' => $siswa->user->name,
                'siswa_id' => $siswa->id,
                'grades' => $grades
            ];
        }

        // Format mapels for header construction
        $mapelList = [];
        foreach ($mapels as $m) {
            $mapelList[] = [
                'id' => $m->id,
                'nama' => strtoupper($m->nama_mapel)
            ];
        }

        return response()->json([
            'status' => 'success',
            'students' => $data,
            'mapels' => $mapelList
        ]);
    }
}
