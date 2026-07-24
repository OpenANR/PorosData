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

    /**
     * Import Siswa data from CSV.
     */
    public function importSiswa(Request $request)
    {
        $request->validate([
            'file_csv' => 'required|file',
        ], [
            'file_csv.required' => 'File CSV wajib diunggah.',
        ]);

        $sd = \App\Models\Instansi::where('tingkat', 'SD')->first() ?? \App\Models\Instansi::first();
        $instansiId = $sd ? $sd->id : null;

        $file = $request->file('file_csv');
        $path = $file->getRealPath();
        
        $handle = fopen($path, 'r');
        if ($handle === false) {
            return redirect()->back()->with('error', 'Gagal membuka file CSV.');
        }

        $header = fgetcsv($handle, 2000, ',');
        
        if ($header && count($header) == 1 && strpos($header[0], ';') !== false) {
            rewind($handle);
            $header = fgetcsv($handle, 2000, ';');
            $delimiter = ';';
        } else {
            $delimiter = ',';
        }

        if ($header) {
            $header = array_map(function($h) {
                return trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $h));
            }, $header);
        }

        $map = array_flip($header);
        
        if (!isset($map['nisn']) || !isset($map['nama'])) {
            fclose($handle);
            return redirect()->back()->with('error', 'Format CSV salah. Harus memiliki kolom: nisn, nama.');
        }

        $importedCount = 0;

        while (($row = fgetcsv($handle, 2000, $delimiter)) !== false) {
            if (empty($row) || count($row) < 2) continue;

            $nisn = trim($row[$map['nisn']] ?? '');
            $nama = trim($row[$map['nama']] ?? '');
            $passwordRaw = isset($map['password']) ? trim($row[$map['password']] ?? '') : '';
            $kelasName = isset($map['kelas']) ? trim($row[$map['kelas']] ?? '') : '';

            if (empty($nisn) || empty($nama)) continue;

            $user = \App\Models\User::where('username', $nisn)->first();
            $dataUser = [
                'name' => $nama,
                'username' => $nisn,
                'role' => 'siswa',
                'instansi_id' => $instansiId
            ];
            
            if (!empty($passwordRaw)) {
                $dataUser['password'] = \Illuminate\Support\Facades\Hash::make($passwordRaw);
                $dataUser['password_plain'] = $passwordRaw;
            } elseif (!$user) {
                $dataUser['password'] = \Illuminate\Support\Facades\Hash::make('password123');
                $dataUser['password_plain'] = 'password123';
            }

            if ($user) {
                $user->update($dataUser);
            } else {
                $user = \App\Models\User::create($dataUser);
            }

            $kelasId = null;
            if (!empty($kelasName)) {
                $kelas = \App\Models\Kelas::firstOrCreate(
                    ['instansi_id' => $instansiId, 'nama_kelas' => $kelasName]
                );
                $kelasId = $kelas->id;
            }

            $siswa = \App\Models\Siswa::where('nisn', $nisn)->first();
            $dataSiswa = [
                'user_id' => $user->id,
                'nisn' => $nisn,
                'status' => trim($row[$map['status_aktif']] ?? 'Aktif'),
                'angkatan' => trim($row[$map['angkatan']] ?? ''),
                'jurusan' => trim($row[$map['jurusan']] ?? ''),
                'kelas_id' => $kelasId,
                'nama_panggilan' => trim($row[$map['panggilan']] ?? ''),
                'jenis_kelamin' => trim($row[$map['jk']] ?? ''),
                'tempat_lahir' => trim($row[$map['tmp_lahir']] ?? ''),
                'tanggal_lahir' => trim($row[$map['tgl_lahir']] ?? null),
                'agama' => trim($row[$map['agama']] ?? ''),
                'kewarganegaraan' => trim($row[$map['wn']] ?? ''),
                'alamat_lengkap' => trim($row[$map['alamat']] ?? ''),
                'nomor_telepon' => trim($row[$map['hp']] ?? ''),
                'tinggi_badan' => trim($row[$map['tb']] ?? null),
                'berat_badan' => trim($row[$map['bb']] ?? null),
                'anak_ke' => trim($row[$map['anak_ke']] ?? null),
                'jumlah_saudara_kandung' => trim($row[$map['jml_sdr_kandung']] ?? null),
                'status_yatim_piatu' => trim($row[$map['yatim']] ?? ''),
                'tinggal_dengan' => trim($row[$map['tinggal_dgn']] ?? ''),
                'nama_ayah' => trim($row[$map['ayah_nama']] ?? ''),
                'pekerjaan_ayah' => trim($row[$map['ayah_kerja']] ?? ''),
                'nomor_hp_ayah' => trim($row[$map['ayah_hp']] ?? ''),
                'nama_ibu' => trim($row[$map['ibu_nama']] ?? ''),
                'pekerjaan_ibu' => trim($row[$map['ibu_kerja']] ?? ''),
                'nomor_hp_ibu' => trim($row[$map['ibu_hp']] ?? ''),
            ];

            foreach (['tanggal_lahir', 'tinggi_badan', 'berat_badan', 'anak_ke', 'jumlah_saudara_kandung'] as $field) {
                if (empty($dataSiswa[$field])) {
                    $dataSiswa[$field] = null;
                }
            }

            if ($siswa) {
                $siswa->update($dataSiswa);
            } else {
                \App\Models\Siswa::create($dataSiswa);
            }

            $importedCount++;
        }

        fclose($handle);

        return redirect()->route('import-export.index')
            ->with('success', "Berhasil mengimpor {$importedCount} data Siswa.");
    }

    /**
     * Delete all Siswa data.
     */
    public function resetSiswa(Request $request)
    {
        try {
            \DB::beginTransaction();
            
            // Hapus semua data di tabel siswa terlebih dahulu
            \App\Models\Siswa::query()->delete();
            
            // Hapus akun user yang memiliki role siswa
            \App\Models\User::where('role', 'siswa')->delete();
            
            \DB::commit();
            
            return redirect()->route('import-export.index')
                ->with('success', 'Seluruh data siswa berhasil dihapus secara permanen.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data siswa: ' . $e->getMessage());
        }
    }
}
