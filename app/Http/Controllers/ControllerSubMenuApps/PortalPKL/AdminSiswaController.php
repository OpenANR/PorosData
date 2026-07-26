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
        $query = Siswa::with(['user', 'kelas', 'mitra.pembimbings']);

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
        
        // Fetch all Kelas for filter dropdown
        $allKelas = Kelas::orderBy('nama_kelas', 'asc')->get();

        return view('PorosDataHome.SubMenuApplication.PortalPKL.admin.siswa', compact('siswas', 'allMitras', 'allKelas', 'search', 'kelasFilter', 'mitraFilter', 'user'));
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
     * Remove the Mitra DU/DI assignment for the specified Siswa PKL (set to null).
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
        ]);

        return redirect()->route('portalpkl.admin.siswa.index')
            ->with('success', 'Penempatan PKL siswa ' . $siswa->user->name . ' berhasil dihapus/dibatalkan.');
    }
}
