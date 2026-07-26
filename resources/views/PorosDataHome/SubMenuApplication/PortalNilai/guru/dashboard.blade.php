@extends('PorosDataHome.SubMenuApplication.PortalNilai.layouts.app')

@section('title', 'Dashboard Guru - Portal Nilai')
@section('page_title', 'Dashboard')

@section('content')
<div class="flex flex-col gap-8">
    <!-- Welcome Card -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-indigo-500 to-violet-500 text-white p-6 md:p-8 shadow-xl shadow-indigo-100 dark:shadow-none mb-2">
        <div class="relative z-10 max-w-xl">
            <h2 class="text-3xl font-extrabold tracking-tight mb-2">Selamat Datang di Portal Penilaian!</h2>
            <p class="text-indigo-100 text-sm md:text-base leading-relaxed mb-4">Gunakan menu di sidebar kiri untuk mengakses fitur penginputan nilai siswa dan pengaturan jadwal akses pengisian nilai akhir.</p>
            @php
                $userRole = $portalnilaiUser->role ?? 'guru';
                $roleLabel = match (strtolower($userRole)) {
                    'admin', 'superadmin', 'administrator' => 'ADMIN',
                    'wali_kelas' => 'WALI KELAS',
                    'guru' => 'GURU',
                    default => strtoupper(str_replace('_', ' ', $userRole)),
                };
            @endphp
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white/10 text-xs font-semibold backdrop-blur-sm">
                <i class="fa-solid fa-circle-user"></i>
                <span>Peran: {{ $roleLabel }}</span>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-72 h-72">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
            </svg>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-2">
        <!-- Card 1: Kelas -->
        <div class="glass-panel border border-slate-200/60 dark:border-slate-800/80 rounded-2xl p-6 shadow-sm flex items-center justify-between hover:shadow-lg hover:shadow-indigo-50/20 dark:hover:shadow-none hover:border-indigo-500/50 transition-all duration-300">
            <div class="space-y-1">
                <span class="block text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Jumlah Kelas</span>
                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $classes->count() }}</h3>
                <span class="text-xs font-medium text-slate-400 flex items-center gap-1">
                    Kelas Terdaftar
                </span>
            </div>
            <div class="h-14 w-14 rounded-2xl bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-school text-2xl"></i>
            </div>
        </div>

        <!-- Card 2: Mapel -->
        <div class="glass-panel border border-slate-200/60 dark:border-slate-800/80 rounded-2xl p-6 shadow-sm flex items-center justify-between hover:shadow-lg hover:shadow-blue-50/20 dark:hover:shadow-none hover:border-blue-500/50 transition-all duration-300">
            <div class="space-y-1">
                <span class="block text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Mata Pelajaran</span>
                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $mapels->count() }}</h3>
                <span class="text-xs font-medium text-slate-400 flex items-center gap-1">
                    Mapel Aktif
                </span>
            </div>
            <div class="h-14 w-14 rounded-2xl bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-book-open text-2xl"></i>
            </div>
        </div>

        <!-- Card 3: Siswa -->
        <div class="glass-panel border border-slate-200/60 dark:border-slate-800/80 rounded-2xl p-6 shadow-sm flex items-center justify-between hover:shadow-lg hover:shadow-emerald-50/20 dark:hover:shadow-none hover:border-emerald-500/50 transition-all duration-300">
            <div class="space-y-1">
                <span class="block text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Siswa Aktif</span>
                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $totalStudents }}</h3>
                <span class="text-xs font-medium text-slate-400 flex items-center gap-1">
                    Siswa Terdata
                </span>
            </div>
            <div class="h-14 w-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-users text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Schedule Status Cards -->
    @php
        $now = now();
        $isTugasOpen = $accessSettings ? ($now->greaterThanOrEqualTo($accessSettings->tugas_buka) && $now->lessThanOrEqualTo($accessSettings->tugas_tutup)) : true;
        $isAsasOpen = $accessSettings ? ($now->greaterThanOrEqualTo($accessSettings->asas_buka) && $now->lessThanOrEqualTo($accessSettings->asas_tutup)) : true;
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Tugas & ASTS Card -->
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-2xl p-6 shadow-sm flex flex-col gap-5 hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800/60 pb-3.5">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-file-pen"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm">Jadwal Tugas & ASTS</h4>
                        <p class="text-xs text-slate-400 dark:text-slate-500">Pengisian nilai tugas & ujian tengah semester.</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $isTugasOpen ? 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/40' : 'bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-900/40' }}">
                    {{ $isTugasOpen ? 'Terbuka' : 'Terkunci' }}
                </span>
            </div>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                    <span>Waktu Buka:</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $accessSettings ? date('d F Y, H:i', strtotime($accessSettings->tugas_buka)) : '-' }}</span>
                </div>
                <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                    <span>Waktu Tutup:</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $accessSettings ? date('d F Y, H:i', strtotime($accessSettings->tugas_tutup)) : '-' }}</span>
                </div>
            </div>
        </div>

        <!-- ASAS Genap Card -->
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-2xl p-6 shadow-sm flex flex-col gap-5 hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800/60 pb-3.5">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm">Jadwal ASAS GENAP</h4>
                        <p class="text-xs text-slate-400 dark:text-slate-500">Pengisian nilai ujian akhir semester genap.</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $isAsasOpen ? 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/40' : 'bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-900/40' }}">
                    {{ $isAsasOpen ? 'Terbuka' : 'Terkunci' }}
                </span>
            </div>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                    <span>Waktu Buka:</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $accessSettings ? date('d F Y, H:i', strtotime($accessSettings->asas_buka)) : '-' }}</span>
                </div>
                <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                    <span>Waktu Tutup:</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $accessSettings ? date('d F Y, H:i', strtotime($accessSettings->asas_tutup)) : '-' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
