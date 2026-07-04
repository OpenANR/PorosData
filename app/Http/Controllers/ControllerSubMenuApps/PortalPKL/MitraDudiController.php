<?php

namespace App\Http\Controllers\ControllerSubMenuApps\PortalPKL;

use App\Http\Controllers\Controller;
use App\Models\MitraDudi;
use Illuminate\Http\Request;

class MitraDudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->get('portalpklUser');
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('portalpkl.dashboard');
        }

        $search = $request->input('search');
        
        $query = MitraDudi::query();

        if ($search) {
            $query->where('nama_perusahaan', 'like', '%' . $search . '%')
                  ->orWhere('alamat', 'like', '%' . $search . '%');
        }

        $mitras = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('PorosDataHome.SubMenuApplication.PortalPKL.admin.mitra', compact('mitras', 'search', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->get('portalpklUser');
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('portalpkl.dashboard');
        }

        $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'koordinat' => ['nullable', 'string', 'max:255'],
        ]);

        MitraDudi::create([
            'nama_perusahaan' => $request->input('nama_perusahaan'),
            'alamat' => $request->input('alamat'),
            'koordinat' => $request->input('koordinat'),
        ]);

        return redirect()->route('portalpkl.admin.mitra.index')
            ->with('success', 'Data Mitra Perusahaan berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = $request->get('portalpklUser');
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('portalpkl.dashboard');
        }

        $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'koordinat' => ['nullable', 'string', 'max:255'],
        ]);

        $mitra = MitraDudi::findOrFail($id);
        $mitra->update([
            'nama_perusahaan' => $request->input('nama_perusahaan'),
            'alamat' => $request->input('alamat'),
            'koordinat' => $request->input('koordinat'),
        ]);

        return redirect()->route('portalpkl.admin.mitra.index')
            ->with('success', 'Data Mitra Perusahaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->get('portalpklUser');
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('portalpkl.dashboard');
        }

        $mitra = MitraDudi::findOrFail($id);
        $mitra->delete();

        return redirect()->route('portalpkl.admin.mitra.index')
            ->with('success', 'Data Mitra Perusahaan berhasil dihapus.');
    }
}
