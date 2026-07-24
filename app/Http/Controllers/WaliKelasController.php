<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instansi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class WaliKelasController extends Controller
{
    /**
     * Display a listing of class advisors.
     */
    public function index(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first() ?? Instansi::first();
        $instansiId = $sd ? $sd->id : null;

        $search = $request->input('search');

        $walikelas = User::where('role', 'wali_kelas')
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
            ->with('classes')
            ->orderBy('name', 'asc')
            ->paginate(10);

        $kelas_tersedia = Kelas::when($instansiId, function($q) use ($instansiId) {
            return $q->where('instansi_id', $instansiId);
        })->orderBy('nama_kelas', 'asc')->get();

        return view('PorosDataHome.kelolaWaliKelas', compact('walikelas', 'search', 'sd', 'kelas_tersedia'));
    }

    /**
     * Store a newly created class advisor.
     */
    public function store(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first() ?? Instansi::first();
        $instansiId = $sd ? $sd->id : null;

        $request->validate([
            'name' => 'required|string|max:255',
            'duk' => 'required|string|max:255|unique:users,duk|unique:users,username',
            'password' => 'required|string|min:6',
            'kelas_diampu' => 'nullable|exists:kelas,id',
        ], [
            'duk.unique' => 'Kode DUK sudah terdaftar.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->duk, // Login using DUK
            'duk' => $request->duk,
            'role' => 'wali_kelas',
            'password' => Hash::make($request->password),
            'password_plain' => $request->password,
            'instansi_id' => $instansiId,
        ]);

        if ($request->filled('kelas_diampu')) {
            Kelas::where('id', $request->kelas_diampu)->update(['user_id' => $user->id]);
        }

        return redirect()->route('walikelas.index')->with('success', 'Akun Wali Kelas berhasil ditambahkan.');
    }

    /**
     * Update the specified class advisor.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'duk' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'duk')->ignore($user->id),
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:6',
            'kelas_diampu' => 'nullable|exists:kelas,id',
        ], [
            'duk.unique' => 'Kode DUK sudah terdaftar.',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->duk, // Update login username to match new DUK
            'duk' => $request->duk,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $data['password_plain'] = $request->password;
        }

        $user->update($data);

        // Remove user_id from all their current classes
        Kelas::where('user_id', $user->id)->update(['user_id' => null]);

        // Assign to new class if selected
        if ($request->filled('kelas_diampu')) {
            Kelas::where('id', $request->kelas_diampu)->update(['user_id' => $user->id]);
        }

        return redirect()->route('walikelas.index')->with('success', 'Data Wali Kelas berhasil diubah.');
    }

    /**
     * Remove the specified class advisor.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Crucial safety measure: set wali kelas reference to null in Kelas first to avoid cascade-deleting the class
        Kelas::where('user_id', $user->id)->update(['user_id' => null]);

        $user->delete();

        return redirect()->route('walikelas.index')->with('success', 'Akun Wali Kelas berhasil dihapus.');
    }

    /**
     * Export Wali Kelas data to CSV.
     */
    public function exportCsv()
    {
        $sd = Instansi::where('tingkat', 'SD')->first() ?? Instansi::first();
        $instansiId = $sd ? $sd->id : null;

        $walikelas = User::where('role', 'wali_kelas')
            ->when($instansiId, function($q) use ($instansiId) {
                return $q->where('instansi_id', $instansiId);
            })
            ->with('classes')
            ->orderBy('name', 'asc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="data_wali_kelas.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($walikelas) {
            $file = fopen('php://output', 'w');
            
            // Header columns matching the screenshot exactly
            fputcsv($file, ['kode_duk', 'password', 'nama', 'kelas_ditugaskan']);

            foreach ($walikelas as $user) {
                $classNames = $user->classes->pluck('nama_kelas')->join(', ');
                
                // Export password directly as it is stored in plain-text column
                fputcsv($file, [
                    $user->duk,
                    $user->password_plain ?? '',
                    $user->name,
                    $classNames
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import Wali Kelas data from CSV.
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'file_csv' => 'required|file',
        ], [
            'file_csv.required' => 'File CSV wajib diunggah.',
        ]);

        $sd = Instansi::where('tingkat', 'SD')->first() ?? Instansi::first();
        $instansiId = $sd ? $sd->id : null;

        if (!$instansiId) {
            return redirect()->back()->with('error', 'Instansi belum dikonfigurasi.');
        }

        $file = $request->file('file_csv');
        $path = $file->getRealPath();
        
        // Open file
        $handle = fopen($path, 'r');
        if ($handle === false) {
            return redirect()->back()->with('error', 'Gagal membuka file CSV.');
        }

        // Read header row
        $header = fgetcsv($handle, 1000, ',');
        
        // Check delimiter (if comma doesn't work, try semicolon)
        if ($header && count($header) == 1 && strpos($header[0], ';') !== false) {
            rewind($handle);
            $header = fgetcsv($handle, 1000, ';');
            $delimiter = ';';
        } else {
            $delimiter = ',';
        }

        // Clean headers (remove BOM or spaces)
        if ($header) {
            $header = array_map(function($h) {
                return trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $h));
            }, $header);
        }

        // Map header indices
        $map = array_flip($header);
        
        // Validate required headers
        if (!isset($map['kode_duk']) || !isset($map['nama'])) {
            fclose($handle);
            return redirect()->back()->with('error', 'Format CSV salah. Harus memiliki kolom: kode_duk, nama.');
        }

        $importedCount = 0;

        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            // Skip empty rows
            if (empty($row) || count($row) < 2) continue;

            $kodeDuk = trim($row[$map['kode_duk']] ?? '');
            $nama = trim($row[$map['nama']] ?? '');
            $passwordRaw = isset($map['password']) ? trim($row[$map['password']] ?? '') : '';
            $kelasDitugaskan = isset($map['kelas_ditugaskan']) ? trim($row[$map['kelas_ditugaskan']] ?? '') : '';

            if (empty($kodeDuk) || empty($nama)) continue;

            // Find existing user by DUK or Username
            $user = User::where('duk', $kodeDuk)
                ->orWhere('username', $kodeDuk)
                ->first();

            $data = [
                'name' => $nama,
                'username' => $kodeDuk,
                'duk' => $kodeDuk,
                'role' => 'wali_kelas',
                'instansi_id' => $instansiId,
            ];

            if (!empty($passwordRaw)) {
                $data['password'] = Hash::make($passwordRaw);
                $data['password_plain'] = $passwordRaw;
            } elseif (!$user) {
                // If new user and password is empty, set default password
                $data['password'] = Hash::make('password123');
                $data['password_plain'] = 'password123';
            }

            if ($user) {
                $user->update($data);
            } else {
                $user = User::create($data);
            }

            // Sync assigned classes
            $oldClassIds = Kelas::where('user_id', $user->id)->pluck('id')->toArray();
            $newClassIds = [];

            if (!empty($kelasDitugaskan)) {
                // Allow splitting classes by comma or semicolon
                $kelasSplitter = strpos($kelasDitugaskan, ';') !== false ? ';' : ',';
                $classNames = array_map('trim', explode($kelasSplitter, $kelasDitugaskan));
                
                foreach ($classNames as $className) {
                    if (empty($className)) continue;
                    $class = Kelas::updateOrCreate(
                        ['instansi_id' => $instansiId, 'nama_kelas' => $className],
                        ['user_id' => $user->id]
                    );
                    $newClassIds[] = $class->id;
                }
            }

            // Remove assignments from classes no longer specified
            $removedClassIds = array_diff($oldClassIds, $newClassIds);
            if (!empty($removedClassIds)) {
                Kelas::whereIn('id', $removedClassIds)->update(['user_id' => null]);
            }

            $importedCount++;
        }

        fclose($handle);

        return redirect()->route('walikelas.index')
            ->with('success', "Berhasil mengimpor {$importedCount} data Wali Kelas.");
    }
}
