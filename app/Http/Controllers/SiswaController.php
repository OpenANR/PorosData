<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
        $classes = Kelas::when($instansiId, function($q) use ($instansiId) {
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
        ]);

        DB::transaction(function () use ($request, $instansiId) {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'siswa',
                'instansi_id' => $instansiId,
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'kelas_id' => $request->kelas_id,
                'nisn' => $request->nisn,
                'status' => $request->status,
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
        ]);

        DB::transaction(function () use ($request, $siswa, $user) {
            $userData = [
                'name' => $request->name,
                'username' => $request->username,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            $siswa->update([
                'kelas_id' => $request->kelas_id,
                'nisn' => $request->nisn,
                'status' => $request->status,
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
}
