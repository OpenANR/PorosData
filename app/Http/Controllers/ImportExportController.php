<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class ImportExportController extends Controller
{
    /**
     * Display the import/export dashboard.
     */
    public function index()
    {
        return view('PorosDataHome.import_export.index');
    }

    /**
     * Export all students data to a CSV template format.
     */
    public function exportSiswa()
    {
        // Get all Siswa with User and Kelas relations
        $siswas = Siswa::with(['user', 'kelas'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="data_siswa_porosdata.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($siswas) {
            $file = fopen('php://output', 'w');
            
            // Header matching the requested CSV format
            fputcsv($file, [
                'nisn', 'password', 'status_aktif', 'nama', 'angkatan', 
                'jurusan', 'kelas', 'panggilan', 'jk', 'tmp_lahir', 
                'tgl_lahir', 'agama', 'wn', 'alamat', 'hp', 
                'tb', 'bb', 'anak_ke', 'jml_sdr_kandung', 'yatim', 
                'tinggal_dgn', 'ayah_nama', 'ayah_kerja', 'ayah_hp', 
                'ibu_nama', 'ibu_kerja', 'ibu_hp'
            ]);

            foreach ($siswas as $siswa) {
                fputcsv($file, [
                    $siswa->nisn,
                    $siswa->user->password_plain ?? '',
                    $siswa->status,
                    $siswa->user->name ?? '',
                    $siswa->angkatan,
                    $siswa->jurusan,
                    $siswa->kelas->nama_kelas ?? '',
                    $siswa->nama_panggilan,
                    $siswa->jenis_kelamin,
                    $siswa->tempat_lahir,
                    $siswa->tanggal_lahir,
                    $siswa->agama,
                    $siswa->kewarganegaraan,
                    $siswa->alamat_lengkap,
                    $siswa->nomor_telepon,
                    $siswa->tinggi_badan,
                    $siswa->berat_badan,
                    $siswa->anak_ke,
                    $siswa->jumlah_saudara_kandung,
                    $siswa->status_yatim_piatu,
                    $siswa->tinggal_dengan,
                    $siswa->nama_ayah,
                    $siswa->pekerjaan_ayah,
                    $siswa->nomor_hp_ayah,
                    $siswa->nama_ibu,
                    $siswa->pekerjaan_ibu,
                    $siswa->nomor_hp_ibu
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
