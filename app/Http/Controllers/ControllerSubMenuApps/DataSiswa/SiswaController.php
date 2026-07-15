<?php

namespace App\Http\Controllers\ControllerSubMenuApps\DataSiswa;

use App\Http\Controllers\Controller;
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
     * Display a listing of students for Data Siswa sub-menu.
     */
    public function index(Request $request)
    {
        // Get authenticated user
        $user = User::find(session('datasiswa_user_id'));
        if (!$user) {
            return redirect()->route('datasiswa.login');
        }

        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = $sd ? $sd->id : null;

        $search = $request->input('search');
        $kelasId = $request->input('kelas_id');
        $status = $request->input('status');

        // Filter based on role
        if ($user->role === 'wali_kelas') {
            // Wali kelas only sees the class they supervise
            $classes = Kelas::where('user_id', $user->id)
                ->orderBy('nama_kelas', 'asc')
                ->get();
            $classIds = $classes->pluck('id')->toArray();
            
            // If they don't supervise any class, they see nothing
            if (empty($classIds)) {
                $siswas = Siswa::whereRaw('1 = 0')->paginate(10);
            } else {
                $siswas = Siswa::whereIn('kelas_id', $classIds)
                    ->where('status', '!=', 'drop_out')
                    ->when($search, function($q) use ($search) {
                        return $q->where(function($sq) use ($search) {
                            $sq->where('nisn', 'like', "%{$search}%")
                               ->orWhereHas('user', function($uq) use ($search) {
                                   $uq->where('name', 'like', "%{$search}%")
                                      ->orWhere('username', 'like', "%{$search}%");
                               });
                        });
                    })
                    ->when($kelasId, function($q) use ($kelasId, $classIds) {
                        // Ensure they can only filter within their supervised classes
                        if (in_array($kelasId, $classIds)) {
                            return $q->where('kelas_id', $kelasId);
                        }
                        return $q->whereIn('kelas_id', $classIds);
                    })
                    ->when($status, function($q) use ($status) {
                        return $q->where('status', $status);
                    })
                    ->with(['user', 'kelas'])
                    ->paginate(10);
            }
        } else {
            // Admin or Superadmin sees all classes/students
            $classes = Kelas::when($instansiId, function($q) use ($instansiId) {
                    return $q->where('instansi_id', $instansiId);
                })
                ->orderBy('nama_kelas', 'asc')
                ->get();

            $siswas = Siswa::whereHas('user', function($q) use ($instansiId) {
                    if ($instansiId) {
                        $q->where('instansi_id', $instansiId);
                    }
                })
                ->where('status', '!=', 'drop_out')
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
        }

        return view('PorosDataHome.SubMenuApplication.DataSiswa.kelola_siswa', compact('siswas', 'classes', 'search', 'kelasId', 'status', 'sd', 'user'));
    }

    /**
     * Update the specified student in Data Siswa sub-menu.
     */
    public function update(Request $request, $id)
    {
        $user = User::find(session('datasiswa_user_id'));
        if (!$user) {
            return redirect()->route('datasiswa.login');
        }

        $siswa = Siswa::findOrFail($id);

        // Security check for Wali Kelas: ensure they only edit student of their supervised class
        if ($user->role === 'wali_kelas') {
            $supervisedClassIds = Kelas::where('user_id', $user->id)->pluck('id')->toArray();
            if (!in_array($siswa->kelas_id, $supervisedClassIds)) {
                abort(403, 'Unauthorized action.');
            }
        }

        $studentUser = $siswa->user;

        $rules = [
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($studentUser->id)],
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
        ];

        if ($request->status === 'drop_out') {
            $rules['alasan_dropout'] = 'required|string';
        }

        $request->validate($rules);

        // Security check for classes selection if Wali Kelas
        if ($user->role === 'wali_kelas') {
            $supervisedClassIds = Kelas::where('user_id', $user->id)->pluck('id')->toArray();
            if (!in_array($request->kelas_id, $supervisedClassIds)) {
                return back()->withErrors(['kelas_id' => 'Wali Kelas hanya dapat memindahkan siswa ke kelas yang diampunya.']);
            }
        }

        if ($user->role === 'wali_kelas') {
            // Check if there is already a pending request for this student
            $existing = PersetujuanPerubahan::where('siswa_id', $siswa->id)
                ->where('status', 'proses')
                ->first();
            if ($existing) {
                return redirect()->route('datasiswa.kelola_siswa')->with('error', 'Siswa ini sudah memiliki pengajuan perubahan yang sedang diproses.');
            }

            PersetujuanPerubahan::create([
                'siswa_id' => $siswa->id,
                'user_id' => $user->id,
                'alasan' => 'Edit data siswa',
                'data_lama' => [
                    'name' => $studentUser->name,
                    'username' => $studentUser->username,
                    'password' => $studentUser->password_plain,
                    'nisn' => $siswa->nisn,
                    'kelas_id' => $siswa->kelas_id,
                    'status' => $siswa->status,
                    'angkatan' => $siswa->angkatan,
                    'jurusan' => $siswa->jurusan,
                    'nama_panggilan' => $siswa->nama_panggilan,
                    'jenis_kelamin' => $siswa->jenis_kelamin,
                    'tempat_lahir' => $siswa->tempat_lahir,
                    'tanggal_lahir' => $siswa->tanggal_lahir,
                    'agama' => $siswa->agama,
                    'kewarganegaraan' => $siswa->kewarganegaraan,
                    'alamat_lengkap' => $siswa->alamat_lengkap,
                    'nomor_telepon' => $siswa->nomor_telepon,
                    'tinggi_badan' => $siswa->tinggi_badan,
                    'berat_badan' => $siswa->berat_badan,
                    'anak_ke' => $siswa->anak_ke,
                    'jumlah_saudara_kandung' => $siswa->jumlah_saudara_kandung,
                    'status_yatim_piatu' => $siswa->status_yatim_piatu,
                    'tinggal_dengan' => $siswa->tinggal_dengan,
                    'nama_ayah' => $siswa->nama_ayah,
                    'pekerjaan_ayah' => $siswa->pekerjaan_ayah,
                    'nomor_hp_ayah' => $siswa->nomor_hp_ayah,
                    'nama_ibu' => $siswa->nama_ibu,
                    'pekerjaan_ibu' => $siswa->pekerjaan_ibu,
                    'nomor_hp_ibu' => $siswa->nomor_hp_ibu,
                ],
                'data_baru' => [
                    'name' => $request->name,
                    'username' => $request->username,
                    'password' => $request->filled('password') ? $request->password : null,
                    'nisn' => $request->nisn,
                    'kelas_id' => $request->kelas_id,
                    'status' => $request->status,
                    'alasan_dropout' => $request->alasan_dropout,
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
                ],
                'status' => 'proses'
            ]);

            return redirect()->route('datasiswa.kelola_siswa')->with('success', 'Perubahan data siswa berhasil diajukan dan sedang menunggu persetujuan admin.');
        }

        // Admin/Superadmin updates directly
        DB::transaction(function () use ($request, $siswa, $studentUser, $user) {
            $userData = [
                'name' => $request->name,
                'username' => $request->username,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
                $userData['password_plain'] = $request->password;
            }

            $studentUser->update($userData);

            $oldStatus = $siswa->status;

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

            if ($request->status === 'drop_out' && $oldStatus !== 'drop_out') {
                PersetujuanPerubahan::create([
                    'siswa_id' => $siswa->id,
                    'user_id' => $user->id,
                    'alasan' => 'DropOut Siswa',
                    'data_lama' => [
                        'name' => $studentUser->name,
                        'username' => $studentUser->username,
                        'password' => $studentUser->password_plain,
                        'nisn' => $siswa->nisn,
                        'kelas_id' => $siswa->kelas_id,
                        'status' => $oldStatus,
                    ],
                    'data_baru' => [
                        'status' => 'drop_out',
                        'alasan_dropout' => $request->input('alasan_dropout', 'Dikeluarkan oleh Admin'),
                    ],
                    'status' => 'disetujui'
                ]);
            }
        });

        return redirect()->route('datasiswa.kelola_siswa')->with('success', 'Data Siswa berhasil diubah.');
    }

    /**
     * Remove the specified student in Data Siswa sub-menu.
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find(session('datasiswa_user_id'));
        if (!$user) {
            return redirect()->route('datasiswa.login');
        }

        $siswa = Siswa::findOrFail($id);

        // Security check for Wali Kelas: ensure they only delete student of their supervised class
        if ($user->role === 'wali_kelas') {
            $supervisedClassIds = Kelas::where('user_id', $user->id)->pluck('id')->toArray();
            if (!in_array($siswa->kelas_id, $supervisedClassIds)) {
                abort(403, 'Unauthorized action.');
            }
        }

        if ($user->role === 'wali_kelas') {
            $request->validate([
                'alasan_dropout' => 'required|string',
            ]);

            // Check if there is already a pending request for this student
            $existing = PersetujuanPerubahan::where('siswa_id', $siswa->id)
                ->where('status', 'proses')
                ->first();
            if ($existing) {
                return redirect()->route('datasiswa.kelola_siswa')->with('error', 'Siswa ini sudah memiliki pengajuan perubahan yang sedang diproses.');
            }

            PersetujuanPerubahan::create([
                'siswa_id' => $siswa->id,
                'user_id' => $user->id,
                'alasan' => 'DropOut Siswa',
                'data_lama' => [
                    'name' => $siswa->user->name,
                    'username' => $siswa->user->username,
                    'password' => $siswa->user->password_plain,
                    'nisn' => $siswa->nisn,
                    'kelas_id' => $siswa->kelas_id,
                    'status' => $siswa->status,
                ],
                'data_baru' => [
                    'status' => 'drop_out',
                    'alasan_dropout' => $request->alasan_dropout,
                ],
                'status' => 'proses'
            ]);

            return redirect()->route('datasiswa.kelola_siswa')->with('success', 'Pengajuan penghapusan data siswa berhasil diajukan dan sedang menunggu persetujuan admin.');
        }

        $studentUser = $siswa->user;

        DB::transaction(function () use ($siswa, $studentUser) {
            $siswa->delete();
            $studentUser->delete();
        });

        return redirect()->route('datasiswa.kelola_siswa')->with('success', 'Data Siswa berhasil dihapus.');
    }

    /**
     * Display status of changes/approvals.
     */
    public function statusPersetujuan(Request $request)
    {
        $user = User::find(session('datasiswa_user_id'));
        if (!$user) {
            return redirect()->route('datasiswa.login');
        }

        $search = $request->input('search');
        $statusFilter = $request->input('status');

        $query = PersetujuanPerubahan::with(['siswa.user', 'user']);

        if ($user->role === 'wali_kelas') {
            $query->where('user_id', $user->id);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('siswa.user', function($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                       ->orWhere('username', 'like', "%{$search}%");
                })
                ->orWhereHas('siswa', function($sq) use ($search) {
                    $sq->where('nisn', 'like', "%{$search}%");
                })
                ->orWhereHas('user', function($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%");
                });
            });
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $persetujuans = $query->orderBy('created_at', 'desc')->paginate(10);

        // Fetch all classes to map class details easily
        $allClasses = Kelas::all()->keyBy('id');

        foreach ($persetujuans as $p) {
            $kelas = Kelas::where('user_id', $p->user_id)->first();
            $p->nama_kelas = $kelas ? $kelas->nama_kelas : 'Tanpa Kelas';
        }

        return view('PorosDataHome.SubMenuApplication.DataSiswa.status_persetujuan', compact('persetujuans', 'search', 'statusFilter', 'user', 'allClasses'));
    }

    /**
     * Cancel a pending change request.
     */
    public function cancelPersetujuan($id)
    {
        $user = User::find(session('datasiswa_user_id'));
        if (!$user) {
            return redirect()->route('datasiswa.login');
        }

        $persetujuan = PersetujuanPerubahan::findOrFail($id);

        if ($user->role === 'wali_kelas' && $persetujuan->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($persetujuan->status !== 'proses') {
            return back()->with('error', 'Hanya pengajuan dengan status proses yang dapat dibatalkan.');
        }

        $persetujuan->delete();

        return back()->with('success', 'Pengajuan perubahan berhasil dibatalkan.');
    }

    /**
     * Display a listing of dropout history.
     */
    public function riwayatDropout(Request $request)
    {
        $user = User::find(session('datasiswa_user_id'));
        if (!$user) {
            return redirect()->route('datasiswa.login');
        }

        $search = $request->input('search');
        $alasan = $request->input('alasan');

        $query = PersetujuanPerubahan::with(['siswa.user', 'siswa.kelas', 'user'])
            ->where('status', 'disetujui')
            ->where(function($q) {
                $q->where('alasan', 'DropOut Siswa')
                  ->orWhere('data_baru->status', 'drop_out');
            });

        // Filter based on role
        if ($user->role === 'wali_kelas') {
            $supervisedClassIds = Kelas::where('user_id', $user->id)->pluck('id')->toArray();
            if (empty($supervisedClassIds)) {
                $query->whereRaw('1 = 0');
            } else {
                $query->where(function($q) use ($supervisedClassIds) {
                    $q->whereHas('siswa', function($sq) use ($supervisedClassIds) {
                        $sq->whereIn('kelas_id', $supervisedClassIds);
                    })
                    ->orWhereIn('data_lama->kelas_id', $supervisedClassIds);
                });
            }
        }

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
        $reasonsQuery = PersetujuanPerubahan::where('status', 'disetujui')
            ->where(function($q) {
                $q->where('alasan', 'DropOut Siswa')
                  ->orWhere('data_baru->status', 'drop_out');
            });
        if ($user->role === 'wali_kelas') {
            $supervisedClassIds = Kelas::where('user_id', $user->id)->pluck('id')->toArray();
            if (empty($supervisedClassIds)) {
                $reasonsQuery->whereRaw('1 = 0');
            } else {
                $reasonsQuery->where(function($q) use ($supervisedClassIds) {
                    $q->whereHas('siswa', function($sq) use ($supervisedClassIds) {
                        $sq->whereIn('kelas_id', $supervisedClassIds);
                    })
                    ->orWhereIn('data_lama->kelas_id', $supervisedClassIds);
                });
            }
        }
        $dropoutReasons = $reasonsQuery->get()
            ->map(function($item) {
                return $item->data_baru['alasan_dropout'] ?? null;
            })
            ->filter()
            ->unique()
            ->values();

        $sd = Instansi::where('tingkat', 'SD')->first();

        return view('PorosDataHome.SubMenuApplication.DataSiswa.riwayat_dropout', compact('riwayats', 'dropoutReasons', 'search', 'alasan', 'user', 'sd'));
    }
}
