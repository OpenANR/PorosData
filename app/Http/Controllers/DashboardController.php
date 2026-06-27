<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Instansi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get primary SD instansi (or first one)
        $instansi = Instansi::where('tingkat', 'SD')->first();
        if (!$instansi) {
            $instansi = Instansi::first(); // Fallback
        }

        $instansiId = $instansi ? $instansi->id : null;

        // Count stats
        $totalSiswa = Siswa::whereHas('user', function($q) use ($instansiId) {
            if ($instansiId) {
                $q->where('instansi_id', $instansiId);
            }
        })->count();

        $totalGuru = User::whereIn('role', ['guru', 'wali_kelas'])
            ->when($instansiId, function($q) use ($instansiId) {
                return $q->where('instansi_id', $instansiId);
            })->count();

        $totalKelas = Kelas::when($instansiId, function($q) use ($instansiId) {
            return $q->where('instansi_id', $instansiId);
        })->count();

        // Student status distributions
        $siswaAktif = Siswa::where('status', 'aktif')->count();
        $siswaDO = Siswa::where('status', 'drop_out')->count();
        $siswaLulus = Siswa::where('status', 'lulus')->count();

        // Student counts per class
        $kelasStats = Kelas::when($instansiId, function($q) use ($instansiId) {
            return $q->where('instansi_id', $instansiId);
        })->withCount('wali_kelas')->get()->map(function($kelas) {
            $siswaCount = Siswa::where('kelas_id', $kelas->id)->count();
            return [
                'nama' => $kelas->nama_kelas,
                'siswa_count' => $siswaCount,
                'wali_kelas' => $kelas->wali_kelas ? $kelas->wali_kelas->name : 'Belum ditentukan'
            ];
        });

        return view('PorosDataHome.index', compact(
            'instansi',
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'siswaAktif',
            'siswaDO',
            'siswaLulus',
            'kelasStats'
        ));
    }
}
