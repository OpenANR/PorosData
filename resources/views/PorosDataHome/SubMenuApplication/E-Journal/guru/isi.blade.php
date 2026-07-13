@extends('PorosDataHome.SubMenuApplication.E-Journal.layouts.app')

@section('title', 'Isi Jurnal Baru')
@section('subtitle', 'Form Jurnal & Absensi Kelas')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header Page -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight bg-gradient-to-r from-blue-600 to-indigo-500 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-300">
            Form Jurnal & Absensi
        </h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
            Silakan lengkapi data pembelajaran dan daftar kehadiran siswa untuk kelas yang diajarkan hari ini.
        </p>
    </div>

    <!-- Alert Banner for Missing Assignments -->
    @if($classes->isEmpty() || $mapels->isEmpty())
    <div class="mb-6 p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/20 border border-amber-100 dark:border-amber-900/30 flex items-start gap-3">
        <div class="h-6 w-6 rounded-lg bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 mt-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.008v.008H12v-.008Z" />
            </svg>
        </div>
        <div>
            <span class="block text-xs font-bold text-amber-800 dark:text-amber-300">Penugasan Mengajar Belum Lengkap</span>
            <span class="block text-xs text-amber-650 dark:text-amber-455 mt-0.5">
                Anda belum ditugaskan ke kelas atau mata pelajaran di Portal Utama PorosData. Hubungi administrator sekolah agar Anda dapat mengisi jurnal untuk kelas & mata pelajaran Anda.
            </span>
        </div>
    </div>
    @endif

    <!-- Form Jurnal -->
    <form action="{{ route('ejournal.guru.store') }}" method="POST" id="form-journal" class="space-y-6">
        @csrf

        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-3xl shadow-xl p-6 md:p-8 transition-all duration-300">
            <!-- Row 1: Pilih Kelas dan Mata Pelajaran -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Pilih Kelas -->
                <div>
                    <label for="kelas_id" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Pilih Kelas <span class="text-rose-500">*</span>
                    </label>
                    <select name="kelas_id" id="kelas_id" required
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-semibold cursor-pointer">
                        @if($classes->isEmpty())
                            <option value="">-- Belum Ada Kelas Ditugaskan --</option>
                        @else
                            <option value="">-- Pilih Kelas (Berdasar Jadwal) --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('kelas_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->nama_kelas }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('kelas_id')
                        <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mata Pelajaran -->
                <div>
                    <label for="mata_pelajaran" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Mata Pelajaran <span class="text-rose-500">*</span>
                    </label>
                    <select name="mata_pelajaran" id="mata_pelajaran" required
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-semibold cursor-pointer">
                        @if($mapels->isEmpty())
                            <option value="">-- Belum Ada Mapel Ditugaskan --</option>
                        @else
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mapels as $mapel)
                                <option value="{{ $mapel->nama_mapel }}" {{ old('mata_pelajaran') == $mapel->nama_mapel ? 'selected' : '' }}>
                                    {{ $mapel->nama_mapel }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('mata_pelajaran')
                        <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Row 2: Daftar Hadir Siswa Table -->
            <div class="mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">
                        Daftar Hadir Siswa <span class="text-rose-500">*</span>
                    </label>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/30 border border-blue-100 dark:border-blue-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 1 1 1.063 1.063L12 12.75l-.354-.354a.75.75 0 1 1 1.063-1.063l.041.02ZM12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" />
                        </svg>
                        Lepas centang untuk input A/I/S/P
                    </span>
                </div>

                <!-- Table Container -->
                <div class="border border-slate-100 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm bg-white/20 dark:bg-slate-900/20">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse" id="students-table">
                            <thead>
                                <tr class="bg-slate-100/50 dark:bg-slate-900/60 border-b border-slate-200/50 dark:border-slate-850">
                                    <th class="px-4 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 w-16">No</th>
                                    <th class="px-4 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Nama Siswa</th>
                                    <th class="px-4 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 w-24">Hadir</th>
                                    <th class="px-4 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 w-64">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="students-list">
                                <tr>
                                    <td colspan="4" class="px-4 py-12 text-center text-slate-400 dark:text-slate-500 text-sm font-semibold">
                                        <div class="flex flex-col items-center justify-center gap-3">
                                            <div class="h-10 w-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                                </svg>
                                            </div>
                                            <span>Silakan pilih kelas terlebih dahulu untuk memuat daftar siswa.</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Row 3: Materi / Pembahasan -->
            <div class="mb-6">
                <label for="materi" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Materi / Pembahasan Jurnal <span class="text-rose-500">*</span>
                </label>
                <textarea name="materi" id="materi" rows="5" required
                          placeholder="Tuliskan uraian materi yang diajarkan hari ini..."
                          class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-semibold placeholder:font-normal"></textarea>
                @error('materi')
                    <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                        class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-3.5 rounded-2xl font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-md hover:shadow-lg focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition-all cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                    Kirim Jurnal & Absensi
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const kelasSelect = document.getElementById('kelas_id');
        const studentsList = document.getElementById('students-list');

        // Fetch students dynamically when class is selected
        if (kelasSelect) {
            kelasSelect.addEventListener('change', async function() {
                const kelasId = this.value;

                if (!kelasId) {
                    studentsList.innerHTML = `
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-slate-400 dark:text-slate-500 text-sm font-semibold">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </div>
                                    <span>Silakan pilih kelas terlebih dahulu untuk memuat daftar siswa.</span>
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }

                // Show loading spinner
                studentsList.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-4 py-12 text-center text-slate-400 dark:text-slate-500 text-sm font-semibold">
                            <div class="flex items-center justify-center gap-3">
                                <svg class="animate-spin h-5 w-5 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Memuat daftar siswa...</span>
                            </div>
                        </td>
                    </tr>
                `;

                try {
                    const response = await fetch(`/porosdata/e-journal/kelas/${kelasId}/siswa`);
                    if (!response.ok) throw new Error('Gagal mengambil data siswa');
                    
                    const students = await response.ok ? await response.json() : [];

                    if (students.length === 0) {
                        studentsList.innerHTML = `
                            <tr>
                                <td colspan="4" class="px-4 py-12 text-center text-slate-400 dark:text-slate-500 text-sm font-semibold">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="h-10 w-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                            </svg>
                                        </div>
                                        <span>Tidak ada siswa aktif di kelas ini.</span>
                                    </div>
                                </td>
                            </tr>
                        `;
                        return;
                    }

                    // Render table rows
                    let rowsHtml = '';
                    students.forEach((student, idx) => {
                        rowsHtml += `
                            <tr class="border-b border-slate-100 dark:border-slate-800/60 hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                                <td class="px-4 py-3.5 text-center text-sm font-bold text-slate-500">${idx + 1}</td>
                                <td class="px-4 py-3.5 text-sm font-semibold text-slate-800 dark:text-slate-200">
                                    <div class="flex flex-col">
                                        <span>${student.name}</span>
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500">NISN: ${student.nisn}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <div class="flex items-center justify-center">
                                        <input type="checkbox" name="attendance[${student.id}][hadir]" value="1" checked
                                               class="hadir-checkbox w-5 h-5 rounded-lg border-slate-200 dark:border-slate-800 text-blue-600 focus:ring-blue-500 cursor-pointer transition-all dark:bg-slate-900/50">
                                    </div>
                                </td>
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center justify-center">
                                        <span class="keterangan-text text-xs font-extrabold text-emerald-600 dark:text-emerald-400 px-3.5 py-1.5 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100/50 dark:border-emerald-950/30 rounded-xl block text-center w-full max-w-[200px] transition-all">HADIR</span>
                                        <select name="attendance[${student.id}][keterangan]"
                                                class="keterangan-select hidden text-xs font-bold text-rose-600 dark:text-rose-400 bg-rose-50/50 dark:bg-rose-950/20 border border-rose-100/50 dark:border-rose-950/30 rounded-xl w-full max-w-[200px] px-3.5 py-1.5 focus:ring-rose-500 focus:border-rose-500 transition-all text-center cursor-pointer dark:bg-slate-900/50">
                                            <option value="A" class="font-semibold text-rose-600 dark:text-rose-400">Alpa (A)</option>
                                            <option value="I" class="font-semibold text-amber-600 dark:text-amber-400">Izin (I)</option>
                                            <option value="S" class="font-semibold text-blue-600 dark:text-blue-400">Sakit (S)</option>
                                            <option value="P" class="font-semibold text-purple-600 dark:text-purple-400">Bolos (P)</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });

                    studentsList.innerHTML = rowsHtml;

                } catch (error) {
                    studentsList.innerHTML = `
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-rose-500 text-sm font-semibold">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-rose-50 dark:bg-rose-950/30 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.008v.008H12v-.008Z" />
                                        </svg>
                                    </div>
                                    <span>Gagal memuat data siswa. Coba pilih ulang kelas.</span>
                                </div>
                            </td>
                        </tr>
                    `;
                    console.error(error);
                }
            });
        }

        // Toggle Keterangan column elements based on Hadir checkbox state
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('hadir-checkbox')) {
                const row = e.target.closest('tr');
                if (!row) return;

                const ketText = row.querySelector('.keterangan-text');
                const ketSelect = row.querySelector('.keterangan-select');

                if (ketText && ketSelect) {
                    if (e.target.checked) {
                        ketText.classList.remove('hidden');
                        ketSelect.classList.add('hidden');
                    } else {
                        ketText.classList.add('hidden');
                        ketSelect.classList.remove('hidden');
                    }
                }
            }
        });
    });
</script>
@endpush
