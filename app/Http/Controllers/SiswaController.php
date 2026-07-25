<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\PersetujuanPerubahan;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = $sd ? $sd->id : null;

        $search = $request->input('search');
        $kelasId = $request->input('kelas_id');
        $status = $request->input('status');

        $siswas = Siswa::whereHas('user', function($q) use ($instansiId) {
                if ($instansiId) {
                    $q->where('instansi_id', $instansiId);
                }
            })
            ->when($search, function($q) use ($search) {
                return $q->where(function($sq) use ($search) {
                    $sq->where('nisn', 'like', "%{$search}%")
                       ->orWhereHas('user', function($uq) use ($search) {
                           $uq->where('name', 'like', "%{$search}%")
                              ->orWhere('username', 'like', "%{$search}%");
                       });
                });
            })
            ->when($kelasId, function($q) use ($kelasId) {
                return $q->where('kelas_id', $kelasId);
            })
            ->when($status, function($q) use ($status) {
                return $q->where('status', $status);
            })
            ->with(['user', 'kelas'])
            ->paginate(10);

        // Get all classrooms for filter dropdown
        $classes = Kelas::with('jurusan')->when($instansiId, function($q) use ($instansiId) {
                return $q->where('instansi_id', $instansiId);
            })
            ->orderBy('nama_kelas', 'asc')
            ->get();

        return view('PorosDataHome.siswa.index', compact('siswas', 'classes', 'search', 'kelasId', 'status', 'sd'));
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = $sd ? $sd->id : null;

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'nisn' => 'required|string|max:20|unique:siswa,nisn',
            'kelas_id' => 'required|exists:kelas,id',
            'status' => ['required', Rule::in(['aktif', 'drop_out', 'lulus'])],
            'angkatan' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:Laki-laki,perempuan',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:255',
            'alamat_lengkap' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:255',
            'tinggi_badan' => 'nullable|integer',
            'berat_badan' => 'nullable|integer',
            'anak_ke' => 'nullable|string|max:255',
            'jumlah_saudara_kandung' => 'nullable|integer',
            'status_yatim_piatu' => 'nullable|in:Lengkap,Yatim,Piatu,Yatim Piatu',
            'tinggal_dengan' => 'nullable|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'nomor_hp_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'nomor_hp_ibu' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $instansiId) {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'password_plain' => $request->password,
                'role' => 'siswa',
                'instansi_id' => $instansiId,
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'kelas_id' => $request->kelas_id,
                'nisn' => $request->nisn,
                'status' => $request->status,
                'angkatan' => $request->angkatan,
                'jurusan' => $request->jurusan,
                'nama_panggilan' => $request->nama_panggilan,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'kewarganegaraan' => $request->kewarganegaraan,
                'alamat_lengkap' => $request->alamat_lengkap,
                'nomor_telepon' => $request->nomor_telepon,
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
                'anak_ke' => $request->anak_ke,
                'jumlah_saudara_kandung' => $request->jumlah_saudara_kandung,
                'status_yatim_piatu' => $request->status_yatim_piatu,
                'tinggal_dengan' => $request->tinggal_dengan,
                'nama_ayah' => $request->nama_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'nomor_hp_ayah' => $request->nomor_hp_ayah,
                'nama_ibu' => $request->nama_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'nomor_hp_ibu' => $request->nomor_hp_ibu,
            ]);
        });

        return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil ditambahkan.');
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = $siswa->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'nisn' => ['required', 'string', 'max:20', Rule::unique('siswa', 'nisn')->ignore($siswa->id)],
            'kelas_id' => 'required|exists:kelas,id',
            'status' => ['required', Rule::in(['aktif', 'drop_out', 'lulus'])],
            'angkatan' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:Laki-laki,perempuan',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:255',
            'alamat_lengkap' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:255',
            'tinggi_badan' => 'nullable|integer',
            'berat_badan' => 'nullable|integer',
            'anak_ke' => 'nullable|string|max:255',
            'jumlah_saudara_kandung' => 'nullable|integer',
            'status_yatim_piatu' => 'nullable|in:Lengkap,Yatim,Piatu,Yatim Piatu',
            'tinggal_dengan' => 'nullable|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'nomor_hp_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'nomor_hp_ibu' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $siswa, $user) {
            $userData = [
                'name' => $request->name,
                'username' => $request->username,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
                $userData['password_plain'] = $request->password;
            }

            $user->update($userData);

            $siswa->update([
                'kelas_id' => $request->kelas_id,
                'nisn' => $request->nisn,
                'status' => $request->status,
                'angkatan' => $request->angkatan,
                'jurusan' => $request->jurusan,
                'nama_panggilan' => $request->nama_panggilan,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'kewarganegaraan' => $request->kewarganegaraan,
                'alamat_lengkap' => $request->alamat_lengkap,
                'nomor_telepon' => $request->nomor_telepon,
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
                'anak_ke' => $request->anak_ke,
                'jumlah_saudara_kandung' => $request->jumlah_saudara_kandung,
                'status_yatim_piatu' => $request->status_yatim_piatu,
                'tinggal_dengan' => $request->tinggal_dengan,
                'nama_ayah' => $request->nama_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'nomor_hp_ayah' => $request->nomor_hp_ayah,
                'nama_ibu' => $request->nama_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'nomor_hp_ibu' => $request->nomor_hp_ibu,
            ]);
        });

        return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil diubah.');
    }

    /**
     * Remove the specified student.
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = $siswa->user;

        DB::transaction(function () use ($siswa, $user) {
            // Delete siswa details first (or cascade will delete it, but let's delete user which deletes siswa or vice versa)
            $siswa->delete();
            $user->delete();
        });

        return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil dihapus.');
    }

    /**
     * Display a listing of dropout history for Admin.
     */
    public function riwayatDropout(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first();

        $search = $request->input('search');
        $alasan = $request->input('alasan');

        $query = PersetujuanPerubahan::with(['siswa.user', 'siswa.kelas', 'user'])
            ->where('status', 'disetujui')
            ->where(function($q) {
                $q->where('alasan', 'DropOut Siswa')
                  ->orWhere('data_baru->status', 'drop_out');
            });

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('siswa.user', function($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                       ->orWhere('username', 'like', "%{$search}%");
                })
                ->orWhereHas('siswa', function($sq) use ($search) {
                    $sq->where('nisn', 'like', "%{$search}%");
                })
                ->orWhere('data_lama->name', 'like', "%{$search}%")
                ->orWhere('data_lama->nisn', 'like', "%{$search}%");
            });
        }

        if ($alasan) {
            $query->where('data_baru->alasan_dropout', 'like', "%{$alasan}%");
        }

        $riwayats = $query->orderBy('updated_at', 'desc')->paginate(10);

        // Map class details
        $allClasses = Kelas::all()->keyBy('id');

        foreach ($riwayats as $r) {
            $kelas = null;
            if ($r->siswa && $r->siswa->kelas) {
                $kelas = $r->siswa->kelas;
            } else if (isset($r->data_lama['kelas_id'])) {
                $kelas = $allClasses->get($r->data_lama['kelas_id']);
            }
            $r->nama_kelas = $kelas ? $kelas->nama_kelas : 'Tanpa Kelas';
        }

        // Get unique dropout reasons for filter dropdown
        $dropoutReasons = PersetujuanPerubahan::where('status', 'disetujui')
            ->where(function($q) {
                $q->where('alasan', 'DropOut Siswa')
                  ->orWhere('data_baru->status', 'drop_out');
            })
            ->get()
            ->map(function($item) {
                return $item->data_baru['alasan_dropout'] ?? null;
            })
            ->filter()
            ->unique()
            ->values();

        return view('PorosDataHome.siswa.riwayat_dropout', compact('riwayats', 'dropoutReasons', 'search', 'alasan', 'sd'));
    }
    /**
     * Tampilkan Halaman UI Migrasi Siswa
     */
    public function migrasiIndex(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = $sd ? $sd->id : null;
        
        $classes = Kelas::with('jurusan')->when($instansiId, function($q) use ($instansiId) {
                return $q->where('instansi_id', $instansiId);
            })
            ->orderBy('nama_kelas', 'asc')
            ->get();
            
        return view('PorosDataHome.siswa.migrasi', compact('classes', 'sd'));
    }

    /**
     * Ambil Data Siswa berdasarkan Kelas (AJAX)
     */
    public function migrasiGetSiswa(Request $request)
    {
        $kelasId = $request->query('kelas_id');
        
        if (!$kelasId) {
            return response()->json([]);
        }
        
        $siswas = Siswa::with('user')
            ->where('kelas_id', $kelasId)
            ->where('status', 'aktif')
            ->get()
            ->sortBy(function($siswa) {
                return $siswa->user ? $siswa->user->name : '';
            })->values();
            
        return response()->json($siswas);
    }

    /**
     * Proses Update / Kenaikan Kelas & Kelulusan
     */
    public function migrasiProses(Request $request)
    {
        $request->validate([
            'siswa_ids' => 'required|array',
            'siswa_ids.*' => 'exists:siswa,id',
            'jenis_migrasi' => 'required|in:naik_kelas,lulus',
            'kelas_tujuan' => 'required_if:jenis_migrasi,naik_kelas',
        ]);

        $siswaIds = $request->input('siswa_ids');
        $jenisMigrasi = $request->input('jenis_migrasi');

        DB::transaction(function () use ($siswaIds, $jenisMigrasi, $request) {
            if ($jenisMigrasi === 'lulus') {
                Siswa::whereIn('id', $siswaIds)->update(['status' => 'lulus']);
            } else {
                $kelasTujuan = $request->input('kelas_tujuan');
                Siswa::whereIn('id', $siswaIds)->update(['kelas_id' => $kelasTujuan]);
            }
        });

        return redirect()->route('siswa.migrasi')->with('success', 'Migrasi data siswa berhasil diproses.');
    }
}
