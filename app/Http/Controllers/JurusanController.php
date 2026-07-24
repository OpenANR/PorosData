<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Jurusan;
use App\Models\Instansi;

class JurusanController extends Controller
{
    public function store(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first() ?? Instansi::first();
        
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
        ]);

        Jurusan::create([
            'instansi_id' => $sd->id,
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->back()->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->back()->with('success', 'Jurusan berhasil dihapus.');
    }
}
