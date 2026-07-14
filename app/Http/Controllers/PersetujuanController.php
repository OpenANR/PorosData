<?php

namespace App\Http\Controllers;

use App\Models\PersetujuanPerubahan;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PersetujuanController extends Controller
{
    /**
     * Display a listing of approvals for the Admin.
     */
    public function index(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = $sd ? $sd->id : null;

        $search = $request->input('search');
        $statusFilter = $request->input('status');

        $query = PersetujuanPerubahan::with(['siswa.user', 'user']);

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
            $kelas = null;
            if ($p->siswa && $p->siswa->kelas) {
                $kelas = $p->siswa->kelas;
            } else if (isset($p->data_lama['kelas_id'])) {
                $kelas = Kelas::find($p->data_lama['kelas_id']);
            }
            $p->nama_kelas = $kelas ? $kelas->nama_kelas : 'Tanpa Kelas';
        }

        return view('PorosDataHome.persetujuan.index', compact('persetujuans', 'search', 'statusFilter', 'allClasses', 'sd'));
    }

    /**
     * Approve the change request.
     */
    public function terima($id)
    {
        $persetujuan = PersetujuanPerubahan::findOrFail($id);

        if ($persetujuan->status !== 'proses') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        DB::transaction(function () use ($persetujuan) {
            $siswa = $persetujuan->siswa;
            $user = $siswa->user;
            $dataBaru = $persetujuan->data_baru;

            // Update user data if present
            $userData = [];
            if (isset($dataBaru['name'])) {
                $userData['name'] = $dataBaru['name'];
            }
            if (isset($dataBaru['username'])) {
                $userData['username'] = $dataBaru['username'];
            }
            if (isset($dataBaru['password']) && !empty($dataBaru['password'])) {
                $userData['password'] = Hash::make($dataBaru['password']);
                $userData['password_plain'] = $dataBaru['password'];
            }

            if (!empty($userData)) {
                $user->update($userData);
            }

            // Update student details if present
            $siswaData = [];
            if (isset($dataBaru['kelas_id'])) {
                $siswaData['kelas_id'] = $dataBaru['kelas_id'];
            }
            if (isset($dataBaru['nisn'])) {
                $siswaData['nisn'] = $dataBaru['nisn'];
            }
            if (isset($dataBaru['status'])) {
                $siswaData['status'] = $dataBaru['status'];
            }

            if (!empty($siswaData)) {
                $siswa->update($siswaData);
            }

            // Update status of approval
            $persetujuan->update([
                'status' => 'disetujui'
            ]);
        });

        return back()->with('success', 'Pengajuan perubahan berhasil disetujui.');
    }

    /**
     * Reject the change request.
     */
    public function tolak($id)
    {
        $persetujuan = PersetujuanPerubahan::findOrFail($id);

        if ($persetujuan->status !== 'proses') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $persetujuan->update([
            'status' => 'ditolak'
        ]);

        return back()->with('success', 'Pengajuan perubahan berhasil ditolak.');
    }
}
