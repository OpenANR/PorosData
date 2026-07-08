<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\KategoriMapel;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MapelController extends Controller
{
    /**
     * Display a listing of subjects and categories.
     */
    public function index(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = Auth::user()->instansi_id ?? ($sd ? $sd->id : null);

        $search = $request->input('search');

        // Fetch categories scoped to instansi or global (null)
        $categories = KategoriMapel::where(function($q) use ($instansiId) {
                $q->where('instansi_id', $instansiId)
                  ->orWhereNull('instansi_id');
            })
            ->orderBy('nama_kategori', 'asc')
            ->get();

        // Fetch subjects
        $mapels = Mapel::when($instansiId, function($q) use ($instansiId) {
                return $q->where('instansi_id', $instansiId);
            })
            ->when($search, function($q) use ($search) {
                return $q->where(function($sq) use ($search) {
                    $sq->where('kode_mapel', 'like', "%{$search}%")
                       ->orWhere('nama_mapel', 'like', "%{$search}%")
                       ->orWhereHas('kategori', function($kq) use ($search) {
                           $kq->where('nama_kategori', 'like', "%{$search}%");
                       });
                });
            })
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('PorosDataHome.mapel.index', compact('mapels', 'categories', 'search', 'sd'));
    }

    /**
     * Store a newly created subject.
     */
    public function store(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = Auth::user()->instansi_id ?? ($sd ? $sd->id : null);

        $request->validate([
            'kode_mapel' => 'required|string|max:255',
            'nama_mapel' => 'required|string|max:255',
            'kategori_mapel_id' => 'required|exists:kategori_mapel,id',
        ]);

        // Check if subject code already exists for this instansi
        $exists = Mapel::where('instansi_id', $instansiId)
            ->where('kode_mapel', $request->kode_mapel)
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Kode Mapel ini sudah digunakan di instansi Anda.');
        }

        Mapel::create([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'kategori_mapel_id' => $request->kategori_mapel_id,
            'instansi_id' => $instansiId,
        ]);

        return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    /**
     * Update the specified subject.
     */
    public function update(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = Auth::user()->instansi_id ?? ($sd ? $sd->id : null);

        $request->validate([
            'kode_mapel' => 'required|string|max:255',
            'nama_mapel' => 'required|string|max:255',
            'kategori_mapel_id' => 'required|exists:kategori_mapel,id',
        ]);

        // Check if new subject code already exists for another subject in this instansi
        $exists = Mapel::where('instansi_id', $instansiId)
            ->where('kode_mapel', $request->kode_mapel)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Kode Mapel ini sudah digunakan oleh mata pelajaran lain.');
        }

        $mapel->update([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'kategori_mapel_id' => $request->kategori_mapel_id,
        ]);

        return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified subject.
     */
    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();

        return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran berhasil dihapus.');
    }

    /**
     * Store a newly created category.
     */
    public function storeKategori(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = Auth::user()->instansi_id ?? ($sd ? $sd->id : null);

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        // Avoid duplicate category names for the same instansi or global
        $exists = KategoriMapel::where('nama_kategori', $request->nama_kategori)
            ->where(function($q) use ($instansiId) {
                $q->where('instansi_id', $instansiId)
                  ->orWhereNull('instansi_id');
            })
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Kategori ini sudah ada.');
        }

        KategoriMapel::create([
            'nama_kategori' => $request->nama_kategori,
            'instansi_id' => $instansiId,
        ]);

        return redirect()->route('mapel.index')->with('success', 'Kategori Mapel berhasil ditambahkan.');
    }

    /**
     * Update the specified category.
     */
    public function updateKategori(Request $request, $id)
    {
        $category = KategoriMapel::findOrFail($id);
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = Auth::user()->instansi_id ?? ($sd ? $sd->id : null);

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        // Make sure it doesn't conflict
        $exists = KategoriMapel::where('nama_kategori', $request->nama_kategori)
            ->where('id', '!=', $id)
            ->where(function($q) use ($instansiId) {
                $q->where('instansi_id', $instansiId)
                  ->orWhereNull('instansi_id');
            })
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Kategori dengan nama ini sudah ada.');
        }

        $category->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('mapel.index')->with('success', 'Kategori Mapel berhasil diperbarui.');
    }

    /**
     * Remove the specified category.
     */
    public function destroyKategori($id)
    {
        $category = KategoriMapel::findOrFail($id);
        
        // Prevent deleting global system default categories (Umum, Matematika, Praktik where instansi_id is null)
        if ($category->instansi_id === null) {
            return redirect()->route('mapel.index')->with('error', 'Kategori bawaan sistem tidak boleh dihapus.');
        }

        $category->delete();

        return redirect()->route('mapel.index')->with('success', 'Kategori Mapel berhasil dihapus.');
    }
}
