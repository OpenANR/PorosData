<?php

namespace App\Http\Controllers\ControllerSubMenuApps\PortalPKL;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\MitraDudi;
use App\Models\Kelas;
use Illuminate\Http\Request;

class AdminSiswaController extends Controller
{
    /**
     * Display a listing of the Siswa PKL.
     */
    public function index(Request $request)
    {
        $user = $request->get('portalpklUser');
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('portalpkl.dashboard');
        }

        $search = $request->input('search');
        $kelasFilter = $request->input('kelas');
        $mitraFilter = $request->input('mitra');

        // Start querying Siswa PKL
        $query = Siswa::with(['user', 'kelas', 'mitra.pembimbings'])->where('is_pkl', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%')
                      ->orWhere('username', 'like', '%' . $search . '%');
                })->orWhere('nisn', 'like', '%' . $search . '%');
            });
        }

        if ($kelasFilter) {
            $query->where('kelas_id', $kelasFilter);
        }

        if ($mitraFilter) {
            if ($mitraFilter === 'belum_ditentukan') {
                $query->whereNull('mitra_dudi_id');
            } else {
                $query->where('mitra_dudi_id', $mitraFilter);
            }
        }

        // Paginate students
        $siswas = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Fetch all Mitra DUDI for the dropdown in the edit modal and filter
        $allMitras = MitraDudi::orderBy('nama_perusahaan', 'asc')->get();
        
        // Fetch only Kelas XII for filter dropdown
        $allKelas = Kelas::where('nama_kelas', 'like', 'XII%')->orderBy('nama_kelas', 'asc')->get();

        // Fetch students who are not in PKL and are in class XII
        $eligibleSiswas = Siswa::with(['user', 'kelas'])
            ->where('is_pkl', false)
            ->whereHas('kelas', function ($q) {
                $q->where('nama_kelas', 'like', 'XII%')->orWhere('nama_kelas', 'like', '12%');
            })
            ->get()
            ->sortBy('user.name');

        return view('PorosDataHome.SubMenuApplication.PortalPKL.admin.siswa', compact('siswas', 'allMitras', 'allKelas', 'eligibleSiswas', 'search', 'kelasFilter', 'mitraFilter', 'user'));
    }

    /**
     * Store newly assigned Siswa PKL.
     */
    public function store(Request $request)
    {
        $user = $request->get('portalpklUser');
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('portalpkl.dashboard');
        }

        $request->validate([
            'siswa_ids' => ['required', 'array'],
            'siswa_ids.*' => ['exists:siswa,id'],
        ]);

        $count = Siswa::whereIn('id', $request->input('siswa_ids'))->update(['is_pkl' => true]);

        return redirect()->route('portalpkl.admin.siswa.index')
            ->with('success', $count . ' Siswa berhasil ditambahkan sebagai peserta PKL.');
    }

    /**
     * Update the Mitra DU/DI for the specified Siswa PKL.
     */
    public function update(Request $request, $id)
    {
        $user = $request->get('portalpklUser');
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('portalpkl.dashboard');
        }

        $request->validate([
            'mitra_dudi_id' => ['nullable', 'exists:mitra_dudi,id'],
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'mitra_dudi_id' => $request->input('mitra_dudi_id'),
        ]);

        return redirect()->route('portalpkl.admin.siswa.index')
            ->with('success', 'Tempat PKL siswa ' . $siswa->user->name . ' berhasil diperbarui.');
    }

    /**
     * Remove the Mitra DU/DI assignment for the specified Siswa PKL (set to null) and remove from PKL.
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->get('portalpklUser');
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('portalpkl.dashboard');
        }

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'mitra_dudi_id' => null,
            'is_pkl' => false,
        ]);

        return redirect()->route('portalpkl.admin.siswa.index')
            ->with('success', 'Siswa ' . $siswa->user->name . ' berhasil dikeluarkan dari daftar peserta PKL.');
    }
}
