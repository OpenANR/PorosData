@extends('PorosDataHome.SubMenuApplication.PortalPKL.layouts.app')

@section('title', 'Dashboard Siswa')

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
                        Anda masuk sebagai <span class="font-semibold text-orange-600 dark:text-orange-400">Siswa Praktik Kerja Lapangan</span> pada Portal PKL.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400">
                        <i class="fa-solid fa-calendar-day mr-1 text-orange-600 dark:text-orange-400"></i>
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                    </span>
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-orange-100 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200/50 dark:border-orange-900/30">
                        <i class="fa-solid fa-user-graduate mr-1"></i> Siswa Access
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Stats / Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-lg rounded-2xl p-5 hover:border-orange-500/50 dark:hover:border-orange-500/30 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider">Lokasi PKL</p>
                            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mt-1">
                                {{ $user->siswa->mitra->nama_perusahaan ?? 'Belum Ditempatkan' }}
                            </h3>
                        </div>
                        <div class="h-10 w-10 rounded-xl bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-building text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-slate-400">
                        <span class="text-slate-500 dark:text-slate-400 font-medium">
                            {{ $user->siswa->mitra->alamat ?? 'Silakan hubungi pembimbing atau admin.' }}
                        </span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex items-center gap-2 text-xs">
                    <i class="fa-solid fa-user-tie text-orange-600 dark:text-orange-400"></i>
                    <span class="text-slate-400 dark:text-slate-500 font-medium">Pembimbing:</span>
                    <span class="font-bold text-slate-700 dark:text-slate-200">
                        @if($user->siswa?->mitra?->pembimbings && $user->siswa->mitra->pembimbings->count() > 0)
                            {{ $user->siswa->mitra->pembimbings->pluck('name')->join(', ') }}
                        @else
                            <span class="text-slate-400 font-normal italic">Belum Ada</span>
                        @endif
                    </span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-lg rounded-2xl p-5 hover:border-orange-500/50 dark:hover:border-orange-500/30 transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider">Total Kehadiran</p>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mt-1">{{ $totalPresensi }} Hari</h3>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                        <i class="fa-solid fa-calendar-check text-lg"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-slate-400">
                    <span class="text-emerald-500 font-semibold mr-1">
                        <i class="fa-solid fa-check mr-0.5"></i> {{ $totalHadir }} Hadir, {{ $totalSakit }} Sakit, {{ $totalIzin }} Izin
                    </span>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-lg rounded-2xl p-5 hover:border-orange-500/50 dark:hover:border-orange-500/30 transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider">Jurnal Terkirim</p>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mt-1">{{ $totalHadir }} Laporan</h3>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                        <i class="fa-solid fa-book text-lg"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-slate-400">
                    <span class="text-emerald-500 font-semibold mr-1">Terkirim</span>
                    Semua jurnal harian tersimpan
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-6 transition-all duration-300">
            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-4"><i class="fa-solid fa-address-card mr-2 text-orange-600 dark:text-orange-400"></i> Informasi Sesi Siswa PKL</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-200">Nama Siswa</td>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-200">Username</td>
                            <td class="px-6 py-4">{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-200">NISN</td>
                            <td class="px-6 py-4">{{ $user->siswa->nisn ?? '1234567890' }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-200">Kelas</td>
                            <td class="px-6 py-4">{{ $user->siswa->kelas->nama_kelas ?? 'XII TKJ 1' }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-200">Asal Instansi / Sekolah</td>
                            <td class="px-6 py-4">{{ $user->instansi->nama_sekolah ?? 'SMK Teknologi Balung' }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-200">Pembimbing PKL</td>
                            <td class="px-6 py-4 font-semibold text-orange-600 dark:text-orange-400">
                                @if($user->siswa?->mitra?->pembimbings && $user->siswa->mitra->pembimbings->count() > 0)
                                    {{ $user->siswa->mitra->pembimbings->pluck('name')->join(', ') }}
                                @else
                                    <span class="text-slate-400 font-normal italic">Belum Ada Pembimbing</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
