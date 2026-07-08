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
        $isAdmin = ($user && in_array($user->role, ['admin', 'superadmin'])) || ($user && $user->id === 999999);

        if ($isAdmin) {
            $classes = Kelas::orderBy('nama_kelas', 'asc')->get();
            $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        } else {
            $sd = Instansi::where('tingkat', 'SD')->first();
            $instansiId = ($user && $user->instansi_id) ? $user->instansi_id : ($sd ? $sd->id : null);

            // Fetch classrooms
            $classes = Kelas::where('instansi_id', $instansiId)
                ->orderBy('nama_kelas', 'asc')
                ->get();

            // Fetch subjects
            $mapels = Mapel::where(function($q) use ($instansiId) {
                    $q->where('instansi_id', $instansiId)
                      ->orWhereNull('instansi_id');
                })
                ->orderBy('nama_mapel', 'asc')
                ->get();
        }

        return view('PorosDataHome.SubMenuApplication.PortalNilai.dashboard', compact('user', 'classes', 'mapels'));
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
            'tugas_buka' => 'required',
            'tugas_tutup' => 'required',
            'asas_buka' => 'required',
            'asas_tutup' => 'required',
        ]);

        PortalNilaiSetting::updateOrCreate(
            ['instansi_id' => $instansiId],
            [
                'tugas_buka' => date('Y-m-d H:i:s', strtotime($request->tugas_buka)),
                'tugas_tutup' => date('Y-m-d H:i:s', strtotime($request->tugas_tutup)),
                'asas_buka' => date('Y-m-d H:i:s', strtotime($request->asas_buka)),
                'asas_tutup' => date('Y-m-d H:i:s', strtotime($request->asas_tutup)),
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
        
        $isAksesBuka = $isAdmin ? true : ($settings ? ($now->greaterThanOrEqualTo($settings->asas_buka) && $now->lessThanOrEqualTo($settings->asas_tutup)) : true);
        $isAksesTugasBuka = $isAdmin ? true : ($settings ? ($now->greaterThanOrEqualTo($settings->tugas_buka) && $now->lessThanOrEqualTo($settings->tugas_tutup)) : true);

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
        if (!$isAdmin) {
            $settings = PortalNilaiSetting::where('instansi_id', $instansiId)->first();
            if (!$settings) {
                $settings = PortalNilaiSetting::whereNull('instansi_id')->first();
            }
            $now = now();
            $isAksesBuka = $settings ? ($now->greaterThanOrEqualTo($settings->asas_buka) && $now->lessThanOrEqualTo($settings->asas_tutup)) : true;
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
}
