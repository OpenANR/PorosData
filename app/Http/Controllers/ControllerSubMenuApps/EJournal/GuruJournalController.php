<?php

namespace App\Http\Controllers\ControllerSubMenuApps\EJournal;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Journal;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruJournalController extends Controller
{
    /**
     * Show the page to fill a new journal (Isi Journal Baru).
     */
    public function isi()
    {
        $userId = session('ejournal_user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('ejournal.login');
        }

        // Fetch classes for this teacher's instansi (specifically SD)
        $classes = Kelas::where('instansi_id', $user->instansi_id)->get();

        return view('PorosDataHome.SubMenuApplication.E-Journal.guru.isi', compact('classes', 'user'));
    }

    /**
     * Get students in a specific class for dynamic loading.
     */
    public function getSiswa($kelas_id)
    {
        $students = Siswa::with('user')
            ->where('kelas_id', $kelas_id)
            ->where('status', 'aktif')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'name' => $s->user->name,
                    'nisn' => $s->nisn
                ];
            });

        return response()->json($students);
    }

    /**
     * Store new journal submission and student attendance.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => ['required', 'exists:kelas,id'],
            'mata_pelajaran' => ['required', 'string', 'max:255'],
            'materi' => ['required', 'string'],
            'attendance' => ['nullable', 'array'],
        ]);

        $userId = session('ejournal_user_id');

        DB::transaction(function () use ($request, $userId) {
            // 1. Create the journal entry
            $journal = Journal::create([
                'user_id' => $userId,
                'kelas_id' => $request->input('kelas_id'),
                'mata_pelajaran' => $request->input('mata_pelajaran'),
                'materi' => $request->input('materi'),
            ]);

            // 2. Create attendance entries
            if ($request->has('attendance')) {
                foreach ($request->input('attendance') as $siswaId => $data) {
                    $hadir = isset($data['hadir']) && $data['hadir'] == '1';
                    $status = $hadir ? 'Hadir' : ($data['keterangan'] ?? 'A');

                    Attendance::create([
                        'journal_id' => $journal->id,
                        'siswa_id' => $siswaId,
                        'status' => $status,
                    ]);
                }
            }
        });

        return redirect()->route('ejournal.guru.riwayat')
            ->with('success', 'Jurnal dan absensi berhasil dikirim!');
    }

    /**
     * Show the journal history page (Riwayat Journal).
     */
    public function riwayat()
    {
        $userId = session('ejournal_user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('ejournal.login');
        }

        // Fetch journals submitted by this teacher
        $journals = Journal::with(['kelas', 'attendances.siswa.user'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('PorosDataHome.SubMenuApplication.E-Journal.guru.riwayat', compact('journals', 'user'));
    }
}
