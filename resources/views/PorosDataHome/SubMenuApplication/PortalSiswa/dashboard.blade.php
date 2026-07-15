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
                    <i class="fa-solid fa-id-card text-indigo-500"></i> NISN: {{ $siswa->nisn ?? '-' }}
                </span>
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-graduation-cap text-indigo-500"></i> Kelas: {{ $siswa->kelas->nama_kelas ?? '-' }}
                </span>
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-user-tie text-indigo-500"></i> Wali Kelas: {{ $siswa->kelas->wali_kelas->name ?? '-' }}
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
                    <i class="fa-regular fa-user text-base w-5 text-center"></i>
                    Data Pribadi
                </button>
                <button onclick="switchTab('akademik')" id="tab-akademik" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left transition-all text-slate-650 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                    <i class="fa-solid fa-graduation-cap text-base w-5 text-center"></i>
                    Status Akademik
                </button>
                <button onclick="switchTab('fisik')" id="tab-fisik" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left transition-all text-slate-650 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                    <i class="fa-solid fa-child text-base w-5 text-center"></i>
                    Fisik & Keluarga
                </button>
                <button onclick="switchTab('ortu')" id="tab-ortu" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left transition-all text-slate-650 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                    <i class="fa-solid fa-people-roof text-base w-5 text-center"></i>
                    Orang Tua / Wali
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
