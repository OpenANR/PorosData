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
        
        // Fetch all Mitra DUDI for checkboxes in edit modal
        $allMitras = MitraDudi::with('pembimbings')->orderBy('nama_perusahaan', 'asc')->get();
        
        // Fetch all users with role 'guru' or 'wali_kelas' for creation modal
        $allGurus = User::whereIn('role', ['guru', 'wali_kelas'])->orderBy('name', 'asc')->get();

        return view('PorosDataHome.SubMenuApplication.PortalPKL.admin.pembimbing', compact('pembimbings', 'allMitras', 'allGurus', 'search', 'user'));
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
            'guru_ids' => ['required', 'array'],
            'guru_ids.*' => ['exists:users,id'],
        ]);

        $gurus = User::whereIn('id', $request->input('guru_ids'))->whereIn('role', ['guru', 'wali_kelas'])->get();
        
        $count = 0;
        foreach ($gurus as $guru) {
            $updateData = ['role' => 'pembimbing'];
            
            if (empty($guru->id_pembimbing)) {
                // Generate simple ID Pembimbing based on user ID
                $updateData['id_pembimbing'] = 'PEM-' . str_pad($guru->id, 4, '0', STR_PAD_LEFT);
            }
            
            $guru->update($updateData);
            $count++;
        }

        return redirect()->route('portalpkl.admin.pembimbing.index')
            ->with('success', $count . ' Guru berhasil ditugaskan sebagai Pembimbing.');
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
        
        // Revert role to guru and clear id_pembimbing instead of deleting the user
        $pembimbing->update([
            'role' => 'guru',
            'id_pembimbing' => null,
        ]);

        return redirect()->route('portalpkl.admin.pembimbing.index')
            ->with('success', 'Data Pembimbing berhasil dihapus dan dikembalikan sebagai Guru.');
    }
}
