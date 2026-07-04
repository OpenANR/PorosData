<?php

namespace App\Http\Controllers\ControllerSubMenuApps\PortalPKL;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MitraDudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminPembimbingController extends Controller
{
    /**
     * Display a listing of the pembimbing users.
     */
    public function index(Request $request)
    {
        $user = $request->get('portalpklUser');
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('portalpkl.dashboard');
        }

        $search = $request->input('search');
        
        $query = User::where('role', 'pembimbing');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%')
                  ->orWhere('id_pembimbing', 'like', '%' . $search . '%');
            });
        }

        // Paginate and load mitras relation
        $pembimbings = $query->with('mitras')->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        // Fetch all Mitra DUDI for checkboxes in creation/edit modals
        $allMitras = MitraDudi::with('pembimbings')->orderBy('nama_perusahaan', 'asc')->get();

        return view('PorosDataHome.SubMenuApplication.PortalPKL.admin.pembimbing', compact('pembimbings', 'allMitras', 'search', 'user'));
    }

    /**
     * Store a newly created pembimbing user in storage.
     */
    public function store(Request $request)
    {
        $user = $request->get('portalpklUser');
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('portalpkl.dashboard');
        }

        $request->validate([
            'id_pembimbing' => ['required', 'string', 'max:255', 'unique:users,id_pembimbing'],
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6'],
            'mitra_ids' => ['nullable', 'array'],
            'mitra_ids.*' => [
                'exists:mitra_dudi,id',
                function ($attribute, $value, $fail) {
                    $isAssigned = \DB::table('pembimbing_mitra_dudi')->where('mitra_dudi_id', $value)->exists();
                    if ($isAssigned) {
                        $fail('Salah satu Industri/Mitra DU/DI yang dipilih sudah didelegasikan ke pembimbing lain.');
                    }
                }
            ],
        ]);

        // Create user with role pembimbing
        $pembimbing = User::create([
            'instansi_id' => $user->instansi_id,
            'id_pembimbing' => $request->input('id_pembimbing'),
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => 'pembimbing',
        ]);

        // Sync Mitra DUDI relations
        if ($request->has('mitra_ids')) {
            $pembimbing->mitras()->sync($request->input('mitra_ids'));
        }

        return redirect()->route('portalpkl.admin.pembimbing.index')
            ->with('success', 'Data Pembimbing berhasil ditambahkan.');
    }

    /**
     * Update the specified pembimbing user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = $request->get('portalpklUser');
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('portalpkl.dashboard');
        }

        $pembimbing = User::where('role', 'pembimbing')->findOrFail($id);

        $request->validate([
            'id_pembimbing' => ['required', 'string', 'max:255', Rule::unique('users', 'id_pembimbing')->ignore($pembimbing->id)],
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($pembimbing->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'mitra_ids' => ['nullable', 'array'],
            'mitra_ids.*' => [
                'exists:mitra_dudi,id',
                function ($attribute, $value, $fail) use ($pembimbing) {
                    $isAssignedToOther = \DB::table('pembimbing_mitra_dudi')
                        ->where('mitra_dudi_id', $value)
                        ->where('pembimbing_id', '!=', $pembimbing->id)
                        ->exists();
                    if ($isAssignedToOther) {
                        $fail('Salah satu Industri/Mitra DU/DI yang dipilih sudah didelegasikan ke pembimbing lain.');
                    }
                }
            ],
        ]);

        $updateData = [
            'id_pembimbing' => $request->input('id_pembimbing'),
            'name' => $request->input('name'),
            'username' => $request->input('username'),
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->input('password'));
        }

        $pembimbing->update($updateData);

        // Sync Mitra DUDI relations
        $pembimbing->mitras()->sync($request->input('mitra_ids', []));

        return redirect()->route('portalpkl.admin.pembimbing.index')
            ->with('success', 'Data Pembimbing berhasil diperbarui.');
    }

    /**
     * Remove the specified pembimbing user from storage.
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->get('portalpklUser');
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('portalpkl.dashboard');
        }

        $pembimbing = User::where('role', 'pembimbing')->findOrFail($id);
        
        // Detach mitras relationship
        $pembimbing->mitras()->detach();
        
        // Delete the user
        $pembimbing->delete();

        return redirect()->route('portalpkl.admin.pembimbing.index')
            ->with('success', 'Data Pembimbing berhasil dihapus.');
    }
}
