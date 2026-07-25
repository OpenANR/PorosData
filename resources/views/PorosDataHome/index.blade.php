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
                    <span class="text-[11px] font-medium text-slate-600 dark:text-slate-300 flex items-center gap-1 bg-slate-50 dark:bg-slate-800/80 px-2 py-0.5 rounded-md border border-slate-200 dark:border-slate-800"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="10" cy="14" r="5"/><line x1="13.54" y1="10.46" x2="21" y2="3"/><line x1="16" y1="3" x2="21" y2="3"/><line x1="21" y1="8" x2="21" y2="3"/></svg> {{ $totalSiswaLaki }} Laki-laki</span>
                    <span class="text-[11px] font-medium text-slate-600 dark:text-slate-300 flex items-center gap-1 bg-slate-50 dark:bg-slate-800/80 px-2 py-0.5 rounded-md border border-slate-200 dark:border-slate-800"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-pink-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="10" r="5"/><line x1="12" y1="15" x2="12" y2="22"/><line x1="9" y1="19" x2="15" y2="19"/></svg> {{ $totalSiswaPerempuan }} Perempuan</span>
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

        <!-- Card 4: Wali Kelas -->
        <a href="{{ route('walikelas.index') }}" class="group p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-50/20 dark:hover:shadow-none transition-all duration-300 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Jumlah Wali Kelas</span>
                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $totalWaliKelas }}</h3>
                <span class="text-xs font-medium text-slate-400 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-colors flex items-center gap-1">
                    Kelola Wali Kelas 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3 group-hover:translate-x-0.5 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </div>
            <div class="h-14 w-14 rounded-2xl bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </div>
        </a>

        <!-- Card 5: Status Persetujuan -->
        <a href="{{ route('persetujuan.index') }}" class="group p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 hover:border-amber-500/50 hover:shadow-lg hover:shadow-amber-50/20 dark:hover:shadow-none transition-all duration-300 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Status Persetujuan</span>
                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $totalPersetujuan }}</h3>
                <span class="text-xs font-medium text-slate-400 group-hover:text-amber-500 dark:group-hover:text-amber-400 transition-colors flex items-center gap-1">
                    Cek Persetujuan 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3 group-hover:translate-x-0.5 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </div>
            <div class="h-14 w-14 rounded-2xl bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
            </div>
        </a>

        <!-- Card 6: Mapel -->
        <a href="{{ route('mapel.index') }}" class="group p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 hover:border-rose-500/50 hover:shadow-lg hover:shadow-rose-50/20 dark:hover:shadow-none transition-all duration-300 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Jumlah Mapel</span>
                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $totalMapel }}</h3>
                <span class="text-xs font-medium text-slate-400 group-hover:text-rose-500 dark:group-hover:text-rose-400 transition-colors flex items-center gap-1">
                    Kelola Mapel 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3 group-hover:translate-x-0.5 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </div>
            <div class="h-14 w-14 rounded-2xl bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
        </a>
    </div>

    <!-- Details Panels -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
        <!-- Status Siswa (Breakdown & Visual Distribution) -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-base font-bold text-slate-900 dark:text-white">Status Akademis Siswa</h4>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                        {{ $totalSiswa }} Total
                    </span>
                </div>

                @php
                    $aktifPct = $totalSiswa > 0 ? round(($siswaAktif / $totalSiswa) * 100) : 0;
                    $lulusPct = $totalSiswa > 0 ? round(($siswaLulus / $totalSiswa) * 100) : 0;
                    $doPct    = $totalSiswa > 0 ? round(($siswaDO / $totalSiswa) * 100) : 0;
                @endphp

                <!-- Visual Distribution Bar -->
                <div class="mb-5 space-y-1.5">
                    <div class="h-2.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden flex">
                        <div class="bg-emerald-500 h-full transition-all duration-500" style="width: {{ $aktifPct }}%" title="Siswa Aktif: {{ $aktifPct }}%"></div>
                        <div class="bg-indigo-500 h-full transition-all duration-500" style="width: {{ $lulusPct }}%" title="Alumni/Lulus: {{ $lulusPct }}%"></div>
                        <div class="bg-rose-500 h-full transition-all duration-500" style="width: {{ $doPct }}%" title="Keluar/DO: {{ $doPct }}%"></div>
                    </div>
                    <div class="flex justify-between text-[11px] font-medium text-slate-400">
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span> Aktif ({{ $aktifPct }}%)</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-indigo-500 inline-block"></span> Lulus ({{ $lulusPct }}%)</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-rose-500 inline-block"></span> DO ({{ $doPct }}%)</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <!-- Aktif -->
                    <div class="p-3.5 rounded-xl bg-slate-50/70 dark:bg-slate-800/40 flex items-center justify-between border border-slate-100 dark:border-slate-800/60 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-xl bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-slate-800 dark:text-slate-200 leading-tight block">Siswa Aktif</span>
                                <span class="text-[11px] text-slate-400">KBM Aktif Berjalan</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-base font-extrabold text-slate-900 dark:text-white block">{{ $siswaAktif }}</span>
                            <span class="text-[10px] font-semibold text-emerald-600 dark:text-emerald-400">{{ $aktifPct }}%</span>
                        </div>
                    </div>

                    <!-- Lulus -->
                    <div class="p-3.5 rounded-xl bg-slate-50/70 dark:bg-slate-800/40 flex items-center justify-between border border-slate-100 dark:border-slate-800/60 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-xl bg-indigo-100 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-slate-800 dark:text-slate-200 leading-tight block">Alumni / Lulus</span>
                                <span class="text-[11px] text-slate-400">Telah Lulus Pendidikan</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-base font-extrabold text-slate-900 dark:text-white block">{{ $siswaLulus }}</span>
                            <span class="text-[10px] font-semibold text-indigo-600 dark:text-indigo-400">{{ $lulusPct }}%</span>
                        </div>
                    </div>

                    <!-- Drop Out -->
                    <div class="p-3.5 rounded-xl bg-slate-50/70 dark:bg-slate-800/40 flex items-center justify-between border border-slate-100 dark:border-slate-800/60 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-xl bg-rose-100 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-slate-800 dark:text-slate-200 leading-tight block">Keluar / DO</span>
                                <span class="text-[11px] text-slate-400">Mutasi / Drop Out</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-base font-extrabold text-slate-900 dark:text-white block">{{ $siswaDO }}</span>
                            <span class="text-[10px] font-semibold text-rose-600 dark:text-rose-400">{{ $doPct }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Action Links Footer -->
            <div class="mt-5 pt-4 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between gap-2">
                <a href="{{ route('siswa.riwayat_lulus') }}" class="text-[11px] font-semibold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                    Riwayat Kelulusan
                </a>
                <a href="{{ route('siswa.riwayat_dropout') }}" class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:underline flex items-center gap-1">
                    Riwayat DO
                </a>
            </div>
        </div>

        <!-- Siswa per Kelas (Horizontal Bar Chart / Grid layout with scroll) -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 lg:col-span-2 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-bold text-slate-900 dark:text-white">Rasio Kepadatan Kelas</h4>
                        <p class="text-xs text-slate-400">Distribusi jumlah siswa laki-laki dan perempuan per ruang kelas</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/50 shrink-0">
                        {{ count($kelasStats) }} Kelas
                    </span>
                </div>

                <div class="max-h-[330px] overflow-y-auto pr-1.5 custom-scrollbar">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @forelse($kelasStats as $stat)
                            @php
                                $maxLimit = 15;
                                $percent = $stat['siswa_count'] > 0 ? min(($stat['siswa_count'] / $maxLimit) * 100, 100) : 0;
                            @endphp
                            <div class="p-3.5 rounded-xl bg-slate-50/70 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/60 space-y-2 hover:border-indigo-200 dark:hover:border-indigo-900/50 transition-colors">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0 flex-1">
                                        <span class="font-bold text-xs text-slate-800 dark:text-slate-200 truncate block">{{ $stat['nama'] }}</span>
                                        <span class="text-[10px] text-slate-400 truncate block">Wali: {{ $stat['wali_kelas'] }}</span>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="text-xs font-extrabold text-slate-900 dark:text-white leading-none block">{{ $stat['siswa_count'] }} <span class="text-[9px] text-slate-400 font-normal">Siswa</span></span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between text-[10px] text-slate-500 pt-0.5">
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-medium text-slate-600 dark:text-slate-300 flex items-center gap-0.5 bg-white dark:bg-slate-800 px-1.5 py-0.5 rounded border border-slate-200 dark:border-slate-700/80">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="10" cy="14" r="5"/><line x1="13.54" y1="10.46" x2="21" y2="3"/><line x1="16" y1="3" x2="21" y2="3"/><line x1="21" y1="8" x2="21" y2="3"/></svg>
                                            {{ $stat['siswa_laki_count'] }} L
                                        </span>
                                        <span class="font-medium text-slate-600 dark:text-slate-300 flex items-center gap-0.5 bg-white dark:bg-slate-800 px-1.5 py-0.5 rounded border border-slate-200 dark:border-slate-700/80">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-pink-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="10" r="5"/><line x1="12" y1="15" x2="12" y2="22"/><line x1="9" y1="19" x2="15" y2="19"/></svg>
                                            {{ $stat['siswa_perempuan_count'] }} P
                                        </span>
                                    </div>
                                </div>

                                <div class="h-2 w-full bg-slate-200/70 dark:bg-slate-700/60 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-8 flex flex-col items-center justify-center text-slate-400 space-y-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-slate-300 dark:text-slate-700">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                </svg>
                                <p class="text-xs font-medium">Belum ada data kelas.</p>
                                <a href="{{ route('kelas.index') }}" class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition-colors">
                                    Buat Kelas Baru
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between text-xs text-slate-400">
                <span>Total Data Kelas Terdaftar</span>
                <a href="{{ route('kelas.index') }}" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                    Kelola Seluruh Kelas &rarr;
                </a>
            </div>
        </div>
    </div>
@endsection