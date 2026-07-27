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
        $siswaQuery = Siswa::whereHas('user', function($q) use ($instansiId) {
            if ($instansiId) {
                $q->where('instansi_id', $instansiId);
            }
        });

        $totalSiswa = $siswaQuery->count();
        $totalSiswaLaki = (clone $siswaQuery)->where('jenis_kelamin', 'Laki-laki')->count();
        $totalSiswaPerempuan = (clone $siswaQuery)->where('jenis_kelamin', 'perempuan')->count();

        $totalGuru = User::whereIn('role', ['guru', 'wali_kelas', 'pembimbing'])
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
            $siswaLakiCount = Siswa::where('kelas_id', $kelas->id)->where('jenis_kelamin', 'Laki-laki')->count();
            $siswaPerempuanCount = Siswa::where('kelas_id', $kelas->id)->where('jenis_kelamin', 'perempuan')->count();
            return [
                'nama' => $kelas->nama_kelas,
                'siswa_count' => $siswaCount,
                'siswa_laki_count' => $siswaLakiCount,
                'siswa_perempuan_count' => $siswaPerempuanCount,
                'wali_kelas' => $kelas->wali_kelas ? $kelas->wali_kelas->name : 'Belum ditentukan'
            ];
        });

        $totalWaliKelas = User::where('role', 'wali_kelas')
            ->when($instansiId, function($q) use ($instansiId) {
                return $q->where('instansi_id', $instansiId);
            })->count();

        $totalPersetujuan = \App\Models\PersetujuanPerubahan::where('status', 'proses')
            ->when($instansiId, function($q) use ($instansiId) {
                return $q->whereHas('siswa.user', function($query) use ($instansiId) {
                    $query->where('instansi_id', $instansiId);
                });
            })->count();

        $totalMapel = \App\Models\Mapel::when($instansiId, function($q) use ($instansiId) {
            return $q->where('instansi_id', $instansiId);
        })->count();

        return view('PorosDataHome.index', compact(
            'instansi',
            'totalSiswa',
            'totalSiswaLaki',
            'totalSiswaPerempuan',
            'totalGuru',
            'totalKelas',
            'siswaAktif',
            'siswaDO',
            'siswaLulus',
            'kelasStats',
            'totalWaliKelas',
            'totalPersetujuan',
            'totalMapel'
        ));
    }
}
