@extends('PorosDataHome.layouts.app')

@section('title', 'Dashboard')

@section('page_title')
    Dashboard - {{ $instansi ? $instansi->nama_sekolah : 'Portal Sekolah SD' }}
@endsection

@section('content')
    <!-- Welcome banner -->
    <div class="mb-8 p-6 md:p-8 rounded-3xl bg-gradient-to-r from-indigo-600 via-indigo-500 to-violet-500 text-white shadow-xl shadow-indigo-100 dark:shadow-none relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-3xl font-extrabold tracking-tight mb-2">Selamat Datang di Portal Admin</h1>
            <p class="text-indigo-100 text-sm md:text-base max-w-xl">Kelola data guru, siswa, dan ruang kelas dengan cepat, aman, dan mudah. Gunakan panel navigasi di sebelah kiri untuk berpindah halaman.</p>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-72 h-72">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
            </svg>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Guru -->
        <a href="{{ route('guru.index') }}" class="group p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 hover:border-indigo-500/50 hover:shadow-lg hover:shadow-indigo-50/20 dark:hover:shadow-none transition-all duration-300 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Tenaga Pendidik</span>
                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $totalGuru }}</h3>
                <span class="text-xs font-medium text-slate-400 group-hover:text-indigo-500 dark:group-hover:text-indigo-400 transition-colors flex items-center gap-1">
                    Kelola Guru 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3 group-hover:translate-x-0.5 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </div>
            <div class="h-14 w-14 rounded-2xl bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
        </a>

        <!-- Card 2: Siswa -->
        <a href="{{ route('siswa.index') }}" class="group p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 hover:border-violet-500/50 hover:shadow-lg hover:shadow-violet-50/20 dark:hover:shadow-none transition-all duration-300 flex items-start justify-between">
            <div class="space-y-1 flex-1">
                <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Siswa Terdaftar</span>
                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $totalSiswa }}</h3>
                <div class="flex items-center gap-2 py-1">
                    <span class="text-[11px] font-medium text-slate-500 flex items-center gap-1 bg-slate-50 dark:bg-slate-800 px-2 py-0.5 rounded-md border border-slate-100 dark:border-slate-700/50"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> {{ $totalSiswaLaki }} Laki-laki</span>
                    <span class="text-[11px] font-medium text-slate-500 flex items-center gap-1 bg-slate-50 dark:bg-slate-800 px-2 py-0.5 rounded-md border border-slate-100 dark:border-slate-700/50"><span class="w-1.5 h-1.5 rounded-full bg-pink-500"></span> {{ $totalSiswaPerempuan }} Perempuan</span>
                </div>
                <span class="text-xs font-medium text-slate-400 group-hover:text-violet-500 dark:group-hover:text-violet-400 transition-colors flex items-center gap-1 pt-1">
                    Kelola Siswa 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3 group-hover:translate-x-0.5 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </div>
            <div class="h-14 w-14 rounded-2xl bg-violet-50 dark:bg-violet-950/30 text-violet-600 dark:text-violet-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform mt-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
                </svg>
            </div>
        </a>

        <!-- Card 3: Kelas -->
        <a href="{{ route('kelas.index') }}" class="group p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-50/20 dark:hover:shadow-none transition-all duration-300 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Ruang Kelas</span>
                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $totalKelas }}</h3>
                <span class="text-xs font-medium text-slate-400 group-hover:text-emerald-500 dark:group-hover:text-emerald-400 transition-colors flex items-center gap-1">
                    Kelola Kelas 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3 group-hover:translate-x-0.5 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </div>
            <div class="h-14 w-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
            </div>
        </a>
    </div>

    <!-- Details Panels -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Status Siswa (Pie Chart Equivalent / Breakdown) -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80">
            <h4 class="text-base font-bold text-slate-900 dark:text-white mb-5">Status Akademis Siswa</h4>
            <div class="space-y-4">
                <!-- Aktif -->
                <div class="p-4 rounded-xl bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between border border-slate-100 dark:border-slate-800/50">
                    <div class="flex items-center gap-3">
                        <div class="h-8.5 w-8.5 rounded-lg bg-emerald-100 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold block text-slate-800 dark:text-slate-200">Siswa Aktif</span>
                            <span class="text-xs text-slate-400 block">KBM Aktif</span>
                        </div>
                    </div>
                    <span class="text-lg font-extrabold text-slate-900 dark:text-white">{{ $siswaAktif }}</span>
                </div>

                <!-- Lulus -->
                <div class="p-4 rounded-xl bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between border border-slate-100 dark:border-slate-800/50">
                    <div class="flex items-center gap-3">
                        <div class="h-8.5 w-8.5 rounded-lg bg-indigo-100 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                            <span class="h-2.5 w-2.5 rounded-full bg-indigo-500"></span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold block text-slate-800 dark:text-slate-200">Alumni / Lulus</span>
                            <span class="text-xs text-slate-400 block">Lulus Pendidikan</span>
                        </div>
                    </div>
                    <span class="text-lg font-extrabold text-slate-900 dark:text-white">{{ $siswaLulus }}</span>
                </div>

                <!-- Drop Out -->
                <div class="p-4 rounded-xl bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between border border-slate-100 dark:border-slate-800/50">
                    <div class="flex items-center gap-3">
                        <div class="h-8.5 w-8.5 rounded-lg bg-rose-100 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 flex items-center justify-center">
                            <span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold block text-slate-800 dark:text-slate-200">Keluar / DO</span>
                            <span class="text-xs text-slate-400 block">Mutasi / Drop Out</span>
                        </div>
                    </div>
                    <span class="text-lg font-extrabold text-slate-900 dark:text-white">{{ $siswaDO }}</span>
                </div>
            </div>
        </div>

        <!-- Siswa per Kelas (Horizontal Bar Chart) -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 lg:col-span-2">
            <h4 class="text-base font-bold text-slate-900 dark:text-white mb-5">Rasio Kepadatan Kelas</h4>
            <div class="space-y-4">
                @forelse($kelasStats as $stat)
                    @php
                        // calculate percentage for bar width. Max students is 30.
                        $maxLimit = 15; // standard sample limit
                        $percent = $stat['siswa_count'] > 0 ? min(($stat['siswa_count'] / $maxLimit) * 100, 100) : 0;
                    @endphp
                    <div class="space-y-1.5">
                        <div class="flex items-end justify-between text-sm">
                            <div class="flex flex-col gap-0.5">
                                <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $stat['nama'] }} <span class="text-xs font-normal text-slate-400 dark:text-slate-500">({{ $stat['wali_kelas'] }})</span></span>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="font-extrabold text-slate-900 dark:text-white leading-none">{{ $stat['siswa_count'] }} <span class="text-[10px] text-slate-400 font-medium">Siswa</span></span>
                                <div class="flex items-center gap-1.5 mt-1.5">
                                    <span class="text-[10px] font-medium text-slate-500 flex items-center gap-1 bg-slate-50 dark:bg-slate-800 px-1.5 py-0.5 rounded border border-slate-100 dark:border-slate-700/50"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> {{ $stat['siswa_laki_count'] }} L</span>
                                    <span class="text-[10px] font-medium text-slate-500 flex items-center gap-1 bg-slate-50 dark:bg-slate-800 px-1.5 py-0.5 rounded border border-slate-100 dark:border-slate-700/50"><span class="w-1.5 h-1.5 rounded-full bg-pink-500"></span> {{ $stat['siswa_perempuan_count'] }} P</span>
                                </div>
                            </div>
                        </div>
                        <div class="h-3.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 flex flex-col items-center justify-center text-slate-400 space-y-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-300 dark:text-slate-700">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        <p class="text-sm font-medium">Belum ada data kelas untuk tingkat SD ini.</p>
                        <a href="{{ route('kelas.index') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition-colors">
                            Buat Kelas Baru
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection