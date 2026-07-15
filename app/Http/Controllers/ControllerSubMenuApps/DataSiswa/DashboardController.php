<?php

namespace App\Http\Controllers\ControllerSubMenuApps\DataSiswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Instansi;
use App\Models\PersetujuanPerubahan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the Data Siswa dashboard with dynamic statistics.
     */
    public function index(Request $request)
    {
        // Get authenticated user
        $user = $request->get('datasiswaUser') ?? User::find(session('datasiswa_user_id'));
        if (!$user) {
            return redirect()->route('datasiswa.login');
        }

        $sd = Instansi::where('tingkat', 'SD')->first();
        $instansiId = $sd ? $sd->id : null;

        // Current time context
        $now = now();
        $semesterStart = $now->month >= 7 
            ? Carbon::create($now->year, 7, 1, 0, 0, 0)
            : Carbon::create($now->year, 1, 1, 0, 0, 0);

        // 1. Total Siswa Aktif & Siswa Baru Count
        if ($user->role === 'wali_kelas') {
            $supervisedClassIds = Kelas::where('user_id', $user->id)->pluck('id')->toArray();
            
            if (empty($supervisedClassIds)) {
                $totalSiswaAktif = 0;
                $siswaBaruCount = 0;
            } else {
                $totalSiswaAktif = Siswa::whereIn('kelas_id', $supervisedClassIds)
                    ->where('status', 'aktif')
                    ->count();
                $siswaBaruCount = Siswa::whereIn('kelas_id', $supervisedClassIds)
                    ->where('status', 'aktif')
                    ->where('created_at', '>=', $semesterStart)
                    ->count();
            }
        } else {
            // Admin or Superadmin
            $totalSiswaAktif = Siswa::where('status', 'aktif')
                ->when($instansiId, function($q) use ($instansiId) {
                    return $q->whereHas('user', function($uq) use ($instansiId) {
                        $uq->where('instansi_id', $instansiId);
                    });
                })
                ->count();

            $siswaBaruCount = Siswa::where('status', 'aktif')
                ->when($instansiId, function($q) use ($instansiId) {
                    return $q->whereHas('user', function($uq) use ($instansiId) {
                        $uq->where('instansi_id', $instansiId);
                    });
                })
                ->where('created_at', '>=', $semesterStart)
                ->count();
        }

        // 2. Total Dropout (corresponds to approved Dropout status change requests)
        $dropoutQuery = PersetujuanPerubahan::where('status', 'disetujui')
            ->where(function($q) {
                $q->where('alasan', 'DropOut Siswa')
                  ->orWhere('data_baru->status', 'drop_out');
            });

        if ($user->role === 'wali_kelas') {
            $supervisedClassIds = Kelas::where('user_id', $user->id)->pluck('id')->toArray();
            if (empty($supervisedClassIds)) {
                $dropoutQuery->whereRaw('1 = 0');
            } else {
                $dropoutQuery->where(function($q) use ($supervisedClassIds) {
                    $q->whereHas('siswa', function($sq) use ($supervisedClassIds) {
                        $sq->whereIn('kelas_id', $supervisedClassIds);
                    })
                    ->orWhereIn('data_lama->kelas_id', $supervisedClassIds);
                });
            }
        }
        $totalDropout = $dropoutQuery->count();

        // Calculate current school academic year
        $year = $now->year;
        $schoolYear = $now->month >= 7 
            ? $year . '/' . ($year + 1)
            : ($year - 1) . '/' . $year;

        // 3. Persetujuan Pending (corresponds to pending status change requests)
        $pendingQuery = PersetujuanPerubahan::where('status', 'proses');
        if ($user->role === 'wali_kelas') {
            $pendingQuery->where('user_id', $user->id);
        }
        $persetujuanPending = $pendingQuery->count();

        return view('PorosDataHome.SubMenuApplication.DataSiswa.index', compact(
            'totalSiswaAktif',
            'siswaBaruCount',
            'totalDropout',
            'schoolYear',
            'persetujuanPending',
            'user'
        ));
    }
}
