<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instansi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = $sd ? $sd->id : null;

        $search = $request->input('search');

        $gurus = User::where('role', 'guru')
            ->when($instansiId, function($q) use ($instansiId) {
                return $q->where('instansi_id', $instansiId);
            })
            ->when($search, function($q) use ($search) {
                return $q->where(function($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                       ->orWhere('username', 'like', "%{$search}%")
                       ->orWhere('duk', 'like', "%{$search}%");
                });
            })
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('PorosDataHome.guru.index', compact('gurus', 'search', 'sd'));
    }

    /**
     * Store a newly created teacher.
     */
    public function store(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = $sd ? $sd->id : null;

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'duk' => 'nullable|string|max:255|unique:users,duk',
            'role' => ['required', Rule::in(['guru'])],
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'duk' => $request->duk,
            'role' => 'guru',
            'password' => Hash::make($request->password),
            'instansi_id' => $instansiId,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil ditambahkan.');
    }

    /**
     * Update the specified teacher.
     */
    public function update(Request $request, $id)
    {
        $guru = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($guru->id)],
            'duk' => ['nullable', 'string', 'max:255', Rule::unique('users', 'duk')->ignore($guru->id)],
            'role' => ['required', Rule::in(['guru'])],
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'duk' => $request->duk,
            'role' => 'guru',
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $guru->update($data);

        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil diubah.');
    }

    /**
     * Remove the specified teacher.
     */
    public function destroy($id)
    {
        $guru = User::findOrFail($id);

        // Crucial safety measure: set wali kelas reference to null in Kelas first to avoid cascade-deleting the class
        Kelas::where('user_id', $guru->id)->update(['user_id' => null]);

        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil dihapus.');
    }
}
