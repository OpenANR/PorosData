<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use App\Models\Instansi;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of classes.
     */
    public function index(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first() ?? Instansi::first();
        $instansiId = $sd ? $sd->id : null;

        $search = $request->input('search');

        $classes = Kelas::when($instansiId, function($q) use ($instansiId) {
                return $q->where('instansi_id', $instansiId);
            })
            ->when($search, function($q) use ($search) {
                return $q->where('nama_kelas', 'like', "%{$search}%");
            })
            ->with('wali_kelas')
            ->orderBy('nama_kelas', 'asc')
            ->paginate(10);

        // Get available teachers with role wali_kelas
        $teachers = User::where('role', 'wali_kelas')
            ->when($instansiId, function($q) use ($instansiId) {
                return $q->where('instansi_id', $instansiId);
            })
            ->orderBy('name', 'asc')
            ->get();

        $jurusans = collect();
        if ($sd && in_array($sd->tingkat, ['SMA', 'SMK'])) {
            $jurusans = Jurusan::where('instansi_id', $instansiId)->orderBy('nama_jurusan', 'asc')->get();
        }

        return view('PorosDataHome.kelas.index', compact('classes', 'teachers', 'search', 'sd', 'jurusans'));
    }

    /**
     * Store a newly created class.
     */
    public function store(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first() ?? Instansi::first();
        if (!$sd) {
            return redirect()->back()->with('error', 'Instansi belum dikonfigurasi. Harap hubungi Superadmin.');
        }

        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'jurusan_id' => 'nullable|exists:jurusans,id',
        ]);

        // Optional: ensure this teacher is not already assigned as Wali Kelas elsewhere
        if ($request->filled('user_id')) {
            $alreadyAssigned = Kelas::where('user_id', $request->user_id)->exists();
            if ($alreadyAssigned) {
                return redirect()->back()->withInput()->with('error', 'Guru ini sudah menjadi Wali Kelas di kelas lain.');
            }
        }

        Kelas::create([
            'instansi_id' => $sd->id,
            'nama_kelas' => $request->nama_kelas,
            'user_id' => $request->user_id ?: null,
            'jurusan_id' => $request->jurusan_id ?: null,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Data Kelas berhasil ditambahkan.');
    }

    /**
     * Update the specified class.
     */
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'jurusan_id' => 'nullable|exists:jurusans,id',
        ]);

        if ($request->filled('user_id') && $request->user_id != $kelas->user_id) {
            $alreadyAssigned = Kelas::where('user_id', $request->user_id)->exists();
            if ($alreadyAssigned) {
                return redirect()->back()->withInput()->with('error', 'Guru ini sudah menjadi Wali Kelas di kelas lain.');
            }
        }

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'user_id' => $request->user_id ?: null,
            'jurusan_id' => $request->jurusan_id ?: null,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Data Kelas berhasil diubah.');
    }

    /**
     * Remove the specified class.
     */
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);

        // Before deleting, check if there are students in this class
        // (the database is configured cascadeOnDelete, but warning or prevention is better if they have students)
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Data Kelas berhasil dihapus.');
    }
}
