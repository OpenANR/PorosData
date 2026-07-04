@extends('PorosDataHome.SubMenuApplication.PortalPKL.layouts.app')

@section('title', 'Dashboard Pembimbing')

@section('content')
    <div class="space-y-6">
        <!-- Welcoming Card -->
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-6 sm:p-8 transition-all duration-300">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-orange-600 to-amber-500 bg-clip-text text-transparent dark:from-orange-400 dark:to-amber-300">
                        Selamat Datang, {{ $user->name }}!
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">
                        Anda masuk sebagai <span class="font-semibold text-orange-600 dark:text-orange-400">Guru Pembimbing PKL</span> pada Portal PKL.
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-orange-100 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200/50 dark:border-orange-900/30">
                        <i class="fa-solid fa-graduation-cap mr-1"></i> Pembimbing Access
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Stats / Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-lg rounded-2xl p-5 hover:border-orange-500/50 dark:hover:border-orange-500/30 transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider">Siswa Bimbingan</p>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mt-1">10 Siswa</h3>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 flex items-center justify-center">
                        <i class="fa-solid fa-users text-lg"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-slate-400">
                    <span class="text-emerald-500 font-semibold mr-1"><i class="fa-solid fa-location-dot mr-0.5"></i> Tersebar</span>
                    di 3 Mitra Perusahaan
                </div>
            </div>

            <!-- Card 2 -->
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-lg rounded-2xl p-5 hover:border-orange-500/50 dark:hover:border-orange-500/30 transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider">Jurnal Belum Diperiksa</p>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mt-1">5 Jurnal</h3>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                        <i class="fa-solid fa-clock-rotate-left text-lg"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-slate-400">
                    <span class="text-amber-600 dark:text-amber-400 font-semibold mr-1">Perlu review</span>
                    kegiatan harian siswa
                </div>
            </div>

            <!-- Card 3 -->
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-lg rounded-2xl p-5 hover:border-orange-500/50 dark:hover:border-orange-500/30 transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider">Kunjungan Industri</p>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mt-1">2 Kunjungan</h3>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                        <i class="fa-solid fa-map-location-dot text-lg"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-slate-400">
                    <span class="text-emerald-500 font-semibold mr-1">Selesai</span>
                    Monitoring bulan ini
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-6 transition-all duration-300">
            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-4"><i class="fa-solid fa-user-gear mr-2 text-orange-600 dark:text-orange-400"></i> Informasi Sesi Pembimbing</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                    <thead class="text-xs text-slate-700 dark:text-slate-300 uppercase bg-slate-100/50 dark:bg-slate-900/50">
                        <tr>
                            <th class="px-6 py-3 rounded-l-lg">Parameter</th>
                            <th class="px-6 py-3 rounded-r-lg">Nilai Sesi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-200">Nama Pembimbing</td>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-200">Username</td>
                            <td class="px-6 py-4">{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-200">Role Portal</td>
                            <td class="px-6 py-4"><span class="px-2 py-0.5 rounded bg-orange-100 dark:bg-orange-950 text-orange-700 dark:text-orange-300 text-xs font-semibold">Pembimbing PKL</span></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-200">Asal Instansi</td>
                            <td class="px-6 py-4">{{ $user->instansi->nama_sekolah ?? 'SMK Teknologi Balung' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
