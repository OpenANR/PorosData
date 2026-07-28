@extends('PorosDataHome.SubMenuApplication.PortalSiswa.layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="space-y-8">
    <!-- Student Header Summary Card -->
    <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-6 sm:p-8 flex flex-col md:flex-row items-center gap-6 transition-all duration-300">
        <!-- Avatar / Initials -->
        <div class="h-24 w-24 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white text-3xl font-extrabold shadow-lg shadow-indigo-500/20 dark:shadow-none shrink-0">
            {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
        
        <!-- Quick Stats -->
        <div class="flex-1 text-center md:text-left space-y-2">
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-2.5">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-850 dark:text-slate-100">
                    {{ $user->name }}
                </h1>
                <!-- Status Badge -->
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider
                    @if(($siswa->status ?? 'aktif') === 'aktif')
                        bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30
                    @elseif(($siswa->status ?? '') === 'lulus')
                        bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900/30
                    @else
                        bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-455 border border-rose-100 dark:border-rose-900/30
                    @endif">
                    {{ $siswa->status ?? 'aktif' }}
                </span>
            </div>
            
            <p class="text-sm font-semibold text-slate-450 dark:text-slate-400">
                Jurusan {{ $siswa->jurusan ?? '-' }} &bull; Angkatan {{ $siswa->angkatan ?? '-' }}
            </p>

            <div class="flex flex-wrap justify-center md:justify-start gap-x-4 gap-y-2 pt-2 text-xs font-medium text-slate-500 dark:text-slate-400">
                <span class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-indigo-500 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm-1.221 4.702c-.903-.112-1.807-.112-2.71 0a48.11 48.11 0 0 0-1.075.191c-.48.096-.827.514-.827 1.002v.294c0 .548.407.98 1.034 1.018a18.785 18.785 0 0 0 4.41 0c.627-.038 1.034-.47 1.034-1.018v-.294c0-.488-.347-.906-.827-1.002a48.48 48.48 0 0 0-1.075-.191Z" />
                    </svg>
                    NISN: {{ $siswa->nisn ?? '-' }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-indigo-500 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
                    </svg>
                    Kelas: {{ $siswa->kelas->nama_kelas ?? '-' }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-indigo-500 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    Wali Kelas: {{ $siswa->kelas->wali_kelas->name ?? '-' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Details and Tabs Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Navigation Tabs Card -->
        <div class="lg:col-span-1">
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-md rounded-2xl p-4 flex flex-col gap-1">
                <button onclick="switchTab('pribadi')" id="tab-pribadi" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left transition-all bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    Data Pribadi
                </button>
                <button onclick="switchTab('akademik')" id="tab-akademik" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left transition-all text-slate-650 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
                    </svg>
                    Status Akademik
                </button>
                <button onclick="switchTab('fisik')" id="tab-fisik" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left transition-all text-slate-650 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Fisik & Keluarga
                </button>
                <button onclick="switchTab('ortu')" id="tab-ortu" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left transition-all text-slate-650 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Orang Tua / Wali
                </button>
                <button onclick="switchTab('kelulusan')" id="tab-kelulusan" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left transition-all text-slate-650 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                    Kelulusan
                </button>
            </div>
        </div>

        <!-- Contents Card -->
        <div class="lg:col-span-3">
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-6 sm:p-8 min-h-[400px]">
                
                <!-- Tab: Data Pribadi -->
                <div id="content-pribadi" class="tab-content space-y-6">
                    <div class="border-b border-slate-100 dark:border-slate-800/60 pb-4">
                        <h2 class="text-xl font-bold text-slate-850 dark:text-slate-100">Data Pribadi Siswa</h2>
                        <p class="text-xs text-slate-400 mt-1">Identitas dasar dan kontak pribadi siswa.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Nama Lengkap</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $user->name }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Nama Panggilan</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->nama_panggilan ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">NISN</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->nisn ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Username Akun</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $user->username }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Jenis Kelamin</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->jenis_kelamin ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Agama</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->agama ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Tempat, Tanggal Lahir</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">
                                {{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Kewarganegaraan</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->kewarganegaraan ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Nomor Telepon</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->nomor_telepon ?? '-' }}</span>
                        </div>
                        <div class="md:col-span-2">
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Alamat Lengkap</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1 leading-relaxed">{{ $siswa->alamat_lengkap ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tab: Status Akademik -->
                <div id="content-akademik" class="tab-content space-y-6 hidden">
                    <div class="border-b border-slate-100 dark:border-slate-800/60 pb-4">
                        <h2 class="text-xl font-bold text-slate-850 dark:text-slate-100">Status Akademik</h2>
                        <p class="text-xs text-slate-400 mt-1">Informasi status kelas, angkatan dan administrasi siswa.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Kelas Aktif</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->kelas->nama_kelas ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Wali Kelas</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->kelas->wali_kelas->name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Jurusan</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->jurusan ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Tahun Angkatan</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->angkatan ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Status Keaktifan</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1 capitalize">{{ $siswa->status ?? 'aktif' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tab: Fisik & Keluarga -->
                <div id="content-fisik" class="tab-content space-y-6 hidden">
                    <div class="border-b border-slate-100 dark:border-slate-800/60 pb-4">
                        <h2 class="text-xl font-bold text-slate-850 dark:text-slate-100">Fisik & Kondisi Keluarga</h2>
                        <p class="text-xs text-slate-400 mt-1">Detail ukuran fisik, status yatim piatu, dan susunan saudara.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Tinggi Badan</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->tinggi_badan ? $siswa->tinggi_badan . ' cm' : '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Berat Badan</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->berat_badan ? $siswa->berat_badan . ' kg' : '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Anak Ke</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->anak_ke ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Jumlah Saudara Kandung</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->jumlah_saudara_kandung ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Status Yatim / Piatu</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->status_yatim_piatu ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Tinggal Dengan</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $siswa->tinggal_dengan ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tab: Orang Tua / Wali -->
                <div id="content-ortu" class="tab-content space-y-6 hidden">
                    <div class="border-b border-slate-100 dark:border-slate-800/60 pb-4">
                        <h2 class="text-xl font-bold text-slate-850 dark:text-slate-100">Informasi Orang Tua / Wali</h2>
                        <p class="text-xs text-slate-400 mt-1">Data identitas, pekerjaan, dan kontak orang tua kandung atau wali.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Data Ayah -->
                        <div class="space-y-4">
                            <h3 class="text-sm font-bold text-indigo-650 dark:text-indigo-400 uppercase tracking-wider border-l-2 border-indigo-500 pl-2">Data Ayah</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-450">Nama Ayah</span>
                                    <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $siswa->nama_ayah ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-455">Pekerjaan Ayah</span>
                                    <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $siswa->pekerjaan_ayah ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-455">Nomor HP Ayah</span>
                                    <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $siswa->nomor_hp_ayah ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Data Ibu -->
                        <div class="space-y-4">
                            <h3 class="text-sm font-bold text-indigo-650 dark:text-indigo-400 uppercase tracking-wider border-l-2 border-indigo-500 pl-2">Data Ibu</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-455">Nama Ibu</span>
                                    <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $siswa->nama_ibu ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-455">Pekerjaan Ibu</span>
                                    <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $siswa->pekerjaan_ibu ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-455">Nomor HP Ibu</span>
                                    <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $siswa->nomor_hp_ibu ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Kelulusan -->
                <div id="content-kelulusan" class="tab-content space-y-6 hidden">
                    <div class="border-b border-slate-100 dark:border-slate-800/60 pb-4">
                        <h2 class="text-xl font-bold text-slate-850 dark:text-slate-100">Informasi Kelulusan</h2>
                        <p class="text-xs text-slate-400 mt-1">Status dan detail kelulusan siswa.</p>
                    </div>
                    
                    @if(strtolower($siswa->status ?? '') === 'lulus')
                        <div class="border border-emerald-500/20 bg-emerald-500/5 shadow-lg rounded-3xl p-8 sm:p-10 flex flex-col items-center text-center transition-all">
                            <div class="w-20 h-20 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center mb-6 shadow-[0_0_15px_rgba(16,185,129,0.15)]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10 text-emerald-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-800 dark:text-emerald-400 mb-3 tracking-tight">Selamat! Anda Telah Lulus</h3>
                            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-2xl leading-relaxed">
                                Selamat atas keberhasilan Anda menyelesaikan pendidikan di SMK Teknologi Balung. Semoga ilmu yang Anda peroleh dapat bermanfaat untuk masa depan yang gemilang.
                            </p>
                            
                            <div class="mt-8 px-8 py-5 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 shadow-sm inline-flex flex-col items-center justify-center min-w-[280px]">
                                <span class="block text-sm sm:text-base font-bold text-slate-700 dark:text-slate-200 mb-1.5">{{ $user->name }}</span>
                                <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs sm:text-sm font-extrabold uppercase tracking-widest border border-emerald-500/20">
                                    Dinyatakan Lulus
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-16 text-center px-4">
                            <div class="w-20 h-20 rounded-full bg-slate-50 dark:bg-slate-800/50 flex items-center justify-center mb-5 shadow-sm border border-slate-100 dark:border-slate-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="w-10 h-10 text-slate-400 dark:text-slate-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-slate-800 dark:text-slate-200">Data Belum Tersedia</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-2.5 max-w-md mx-auto leading-relaxed">
                                Saat ini data kelulusan Anda belum tersedia atau Anda masih berstatus siswa aktif. Menu ini akan otomatis menampilkan informasi kelulusan ketika admin telah mengubah status Anda.
                            </p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchTab(tabId) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(el => {
            el.classList.add('hidden');
        });

        // Show targets
        const targetContent = document.getElementById('content-' + tabId);
        if (targetContent) {
            targetContent.classList.remove('hidden');
        }

        // Reset all tabs styles
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-indigo-50', 'dark:bg-indigo-950/40', 'text-indigo-600', 'dark:text-indigo-400');
            btn.classList.add('text-slate-650', 'dark:text-slate-400', 'hover:bg-slate-50', 'dark:hover:bg-slate-800/50', 'hover:text-slate-900', 'dark:hover:text-slate-200');
        });

        // Highlight selected tab
        const activeTab = document.getElementById('tab-' + tabId);
        if (activeTab) {
            activeTab.classList.remove('text-slate-655', 'dark:text-slate-400', 'hover:bg-slate-50', 'dark:hover:bg-slate-800/50', 'hover:text-slate-900', 'dark:hover:text-slate-200');
            activeTab.classList.add('bg-indigo-50', 'dark:bg-indigo-950/40', 'text-indigo-600', 'dark:text-indigo-400');
        }
    }
</script>
@endsection
