@extends('PorosDataHome.SubMenuApplication.DataSiswa.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Banner -->
    <div class="mb-8 p-6 md:p-8 rounded-3xl bg-gradient-to-r from-indigo-600 via-indigo-500 to-violet-500 text-white shadow-xl shadow-indigo-100 dark:shadow-none relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-3xl font-extrabold tracking-tight mb-2">Selamat Datang di Portal Data Siswa</h1>
            <p class="text-indigo-100 text-sm md:text-base max-w-xl">
                Halo, {{ $datasiswaUser->name ?? 'Pengguna' }}. Halaman ini merupakan pusat administrasi kesiswaan terpadu {{ isset($instansi_app) && $instansi_app->nama_sekolah ? $instansi_app->nama_sekolah : 'SMK Teknologi Balung' }}. Gunakan menu sidebar untuk navigasi.
            </p>
            @if(isset($datasiswaUser) && $datasiswaUser->role === 'wali_kelas' && $datasiswaUser->kelas)
            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-white/20 text-white border border-white/30 backdrop-blur-md shadow-sm">
                    {{ $datasiswaUser->kelas->nama_kelas }}
                </span>
                @if($datasiswaUser->kelas->jurusan)
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-white/20 text-white border border-white/30 backdrop-blur-md shadow-sm">
                    {{ $datasiswaUser->kelas->jurusan->nama_jurusan }}
                </span>
                @endif
            </div>
            @endif
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-72 h-72">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
            </svg>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Stat Card 1: Siswa Aktif -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Siswa Aktif</span>
                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $totalSiswaAktif }}</h3>
                <span class="text-xs font-medium text-emerald-500 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                        <path fill-rule="evenodd" d="M10 17a.75.75 0 0 1-.75-.75V5.612L5.29 9.77a.75.75 0 0 1-1.08-1.04l5.5-5.5a.75.75 0 0 1 1.08 0l5.5 5.5a.75.75 0 1 1-1.08 1.04l-3.96-3.908V16.25A.75.75 0 0 1 10 17Z" clip-rule="evenodd" />
                    </svg>
                    +{{ $siswaBaruCount }} Siswa semester ini
                </span>
            </div>
            <div class="h-14 w-14 rounded-2xl bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
                </svg>
            </div>
        </div>

        <!-- Stat Card 2: Siswa Dropout -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Dropout</span>
                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $totalDropout }}</h3>
                <span class="text-xs font-medium text-slate-400">Tahun Ajaran {{ $schoolYear }}</span>
            </div>
            <div class="h-14 w-14 rounded-2xl bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                </svg>
            </div>
        </div>

        <!-- Stat Card 3: Menunggu Persetujuan -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Persetujuan Pending</span>
                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $persetujuanPending }}</h3>
                <span class="text-xs font-medium {{ $persetujuanPending > 0 ? 'text-amber-500' : 'text-slate-400' }} flex items-center gap-1">
                    @if($persetujuanPending > 0)
                        Perlu tindakan segera
                    @else
                        Tidak ada pengajuan
                    @endif
                </span>
            </div>
            <div class="h-14 w-14 rounded-2xl bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Quick Navigation Links -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kelola Siswa Card -->
        <a href="{{ route('datasiswa.kelola_siswa') }}" class="group p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 hover:border-indigo-500/50 hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="h-10 w-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                    Kelola Siswa
                </h4>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-2 leading-relaxed">
                    Lihat data terperinci siswa, ubah informasi profil, dan lakukan operasi CRUD kesiswaan secara langsung.
                </p>
            </div>
            <span class="text-xs font-semibold text-indigo-500 mt-4 flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                Buka Halaman
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </span>
        </a>

        <!-- Riwayat DO Card -->
        <a href="{{ route('datasiswa.riwayat_dropout') }}" class="group p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 hover:border-rose-500/50 hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="h-10 w-10 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-slate-800 dark:text-slate-200 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors">
                    Riwayat DO Siswa
                </h4>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-2 leading-relaxed">
                    Arsip log mutasi, siswa keluar, dan dropout beserta detail alasan pengeluaran untuk kebutuhan audit data.
                </p>
            </div>
            <span class="text-xs font-semibold text-rose-500 mt-4 flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                Buka Halaman
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </span>
        </a>

        <!-- Status Persetujuan Card -->
        <a href="{{ route('datasiswa.status_persetujuan') }}" class="group p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 hover:border-amber-500/50 hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="h-10 w-10 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                    Status Persetujuan
                </h4>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-2 leading-relaxed">
                    Pantau pengajuan data siswa baru, kelulusan, dan pengajuan dropout yang membutuhkan otorisasi Admin Utama.
                </p>
            </div>
            <span class="text-xs font-semibold text-amber-500 mt-4 flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                Buka Halaman
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </span>
        </a>
    </div>
@endsection