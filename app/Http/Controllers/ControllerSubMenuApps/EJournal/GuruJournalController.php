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

        // Fetch classes assigned to this teacher in PorosData
        $classes = $user->guru_kelas()->get();

        // Fetch subjects assigned to this teacher in PorosData
        $mapels = $user->guru_mapel()->get();

        return view('PorosDataHome.SubMenuApplication.E-Journal.guru.isi', compact('classes', 'mapels', 'user'));
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
    public function riwayat(Request $request)
    {
        $userId = session('ejournal_user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('ejournal.login');
        }

        // Fetch classes assigned to this teacher in PorosData
        $classes = $user->guru_kelas()->get();

        // Fetch unique subjects submitted by this teacher for the dropdown filter
        $subjects = Journal::where('user_id', $userId)
            ->whereNotNull('mata_pelajaran')
            ->distinct()
            ->orderBy('mata_pelajaran', 'asc')
            ->pluck('mata_pelajaran');

        // Get filter inputs
        $kelasId = $request->input('kelas_id');
        $mataPelajaran = $request->input('mata_pelajaran');

        // Query journals
        $query = Journal::with(['kelas', 'attendances.siswa.user'])
            ->where('user_id', $userId);

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        if ($mataPelajaran) {
            $query->where('mata_pelajaran', $mataPelajaran);
        }

        $journals = $query->orderBy('created_at', 'desc')->get();

        return view('PorosDataHome.SubMenuApplication.E-Journal.guru.riwayat', compact(
            'journals',
            'classes',
            'subjects',
            'kelasId',
            'mataPelajaran',
            'user'
        ));
    }
}
