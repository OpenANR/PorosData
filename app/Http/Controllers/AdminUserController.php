<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Display a listing of admin and superadmin users.
     */
    public function index(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = $sd ? $sd->id : null;

        $search = $request->input('search');

        // Fetch users who are admin or superadmin
        $admins = User::whereIn('role', ['admin', 'superadmin'])
            ->when($search, function($q) use ($search) {
                return $q->where(function($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                       ->orWhere('username', 'like', "%{$search}%");
                });
            })
            ->orderBy('role', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('PorosDataHome.admin.index', compact('admins', 'search', 'sd'));
    }

    /**
     * Store a newly created admin/superadmin user.
     */
    public function store(Request $request)
    {
        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = $sd ? $sd->id : null;

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'role' => ['required', Rule::in(['admin', 'superadmin'])],
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'password_plain' => $request->password,
            'instansi_id' => $instansiId, // default to the primary SD instansi
        ]);

        return redirect()->route('admin_users.index')->with('success', 'User Admin berhasil ditambahkan.');
    }

    /**
     * Update the specified admin/superadmin user.
     */
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($admin->id)],
            'role' => ['required', Rule::in(['admin', 'superadmin'])],
            'password' => 'nullable|string|min:6',
        ]);

        // Prevent changing own role from superadmin to admin if it's the last superadmin
        if ($admin->id === Auth::id() && $admin->role === 'superadmin' && $request->role !== 'superadmin') {
            $superadminCount = User::where('role', 'superadmin')->count();
            if ($superadminCount <= 1) {
                return redirect()->route('admin_users.index')->withErrors([
                    'role' => 'Anda tidak bisa mengubah peran Anda sendiri karena Anda adalah satu-satunya Superadmin.'
                ]);
            }
        }

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $data['password_plain'] = $request->password;
        }

        $admin->update($data);

        return redirect()->route('admin_users.index')->with('success', 'User Admin berhasil diperbarui.');
    }

    /**
     * Remove the specified admin/superadmin user from storage.
     */
    public function destroy($id)
    {
        $admin = User::findOrFail($id);

        // Prevent self-deletion
        if ($admin->id === Auth::id()) {
            return redirect()->route('admin_users.index')->withErrors([
                'delete' => 'Anda tidak diperbolehkan menghapus akun Anda sendiri yang sedang digunakan.'
            ]);
        }

        // Prevent deleting the last superadmin
        if ($admin->role === 'superadmin') {
            $superadminCount = User::where('role', 'superadmin')->count();
            if ($superadminCount <= 1) {
                return redirect()->route('admin_users.index')->withErrors([
                    'delete' => 'Tidak dapat menghapus satu-satunya akun Superadmin yang tersisa.'
                ]);
            }
        }

        $admin->delete();

        return redirect()->route('admin_users.index')->with('success', 'User Admin berhasil dihapus.');
    }
}
