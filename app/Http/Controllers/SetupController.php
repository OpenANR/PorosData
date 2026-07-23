<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instansi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SetupController extends Controller
{
    public function showForm()
    {
        // Jika instansi sudah ada, redirect ke dashboard
        if (Instansi::count() > 0) {
            return redirect()->route('dashboard');
        }

        return view('PorosDataHome.setup');
    }

    public function processSetup(Request $request)
    {
        if (Instansi::count() > 0) {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'password' => 'nullable|string|min:6|confirmed',
            'nama_sekolah' => 'required|string|max:255',
            'tingkat' => 'required|in:SD,SMP,SMA,SMK',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ], [
            'username.unique' => 'Username tersebut sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nama_sekolah.required' => 'Nama Sekolah wajib diisi.',
            'tingkat.required' => 'Tingkat Instansi wajib dipilih.',
            'tingkat.in' => 'Tingkat Instansi tidak valid.',
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus jpeg, png, jpg, atau svg.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
        ]);

        $user = Auth::user();
        $user->username = $request->username;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->password_plain = $request->password;
        }
        $user->save();

        $logoPath = null;
        if ($request->hasFile('logo')) {
            // Simpan ke storage/app/public/logos
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        Instansi::create([
            'nama_sekolah' => $request->nama_sekolah,
            'tingkat' => $request->tingkat,
            'logo' => $logoPath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Setup instansi berhasil disimpan.');
    }
}
