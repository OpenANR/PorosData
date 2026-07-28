@extends('PorosDataHome.SubMenuApplication.PortalPKL.layouts.app')

@section('title', 'Kehadiran Siswa PKL')

@section('content')
    <div class="space-y-6">
        <!-- Header Card -->
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-6 sm:p-8 transition-all duration-300">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-orange-600 to-amber-500 bg-clip-text text-transparent dark:from-orange-400 dark:to-amber-300">
                        Monitoring Kehadiran Siswa
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">
                        Kelola dan tinjau absensi harian serta jurnal kegiatan siswa PKL.
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-orange-100 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200/50 dark:border-orange-900/30">
                        <i class="fa-solid fa-clock-rotate-left mr-1"></i> Data Kehadiran
                    </span>
                </div>
            </div>
        </div>

        <!-- Statistics counters -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Hadir -->
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-md rounded-2xl p-4 hover:border-emerald-500/30 dark:hover:border-emerald-500/20 transition-all">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-slate-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-wider">Hadir</p>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mt-1">{{ $stats['hadir'] }}</h3>
                    </div>
                    <div class="h-8 w-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                        <i class="fa-solid fa-user-check text-sm"></i>
                    </div>
                </div>
            </div>
            <!-- Sakit -->
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-md rounded-2xl p-4 hover:border-amber-500/30 dark:hover:border-amber-500/20 transition-all">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-slate-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-wider">Sakit</p>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mt-1">{{ $stats['sakit'] }}</h3>
                    </div>
                    <div class="h-8 w-8 rounded-lg bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                        <i class="fa-solid fa-user-injured text-sm"></i>
                    </div>
                </div>
            </div>
            <!-- Izin -->
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-md rounded-2xl p-4 hover:border-blue-500/30 dark:hover:border-blue-500/20 transition-all">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-slate-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-wider">Izin</p>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mt-1">{{ $stats['izin'] }}</h3>
                    </div>
                    <div class="h-8 w-8 rounded-lg bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                        <i class="fa-solid fa-envelope-open-text text-sm"></i>
                    </div>
                </div>
            </div>
            <!-- Belum Presensi -->
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-md rounded-2xl p-4 hover:border-rose-500/30 dark:hover:border-rose-500/20 transition-all">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-slate-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-wider">Belum Presensi</p>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mt-1">{{ $stats['belum_presensi'] }}</h3>
                    </div>
                    <div class="h-8 w-8 rounded-lg bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center">
                        <i class="fa-solid fa-user-slash text-sm"></i>
                    </div>
                </div>
            </div>
            <!-- Total Siswa -->
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-md rounded-2xl p-4 col-span-2 lg:col-span-1">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-slate-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-wider">Total Siswa PKL</p>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mt-1">{{ $stats['total_siswa'] }}</h3>
                    </div>
                    <div class="h-8 w-8 rounded-lg bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-500 flex items-center justify-center">
                        <i class="fa-solid fa-users text-sm"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-lg rounded-2xl p-5">
            <form action="{{ route('portalpkl.admin.kehadiran') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <!-- Search -->
                <div class="space-y-1.5">
                    <label for="search" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Cari Siswa</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input type="text" name="search" id="search" value="{{ $search }}" class="block w-full pl-9 pr-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-800 dark:text-slate-200 text-xs focus:ring-1 focus:ring-orange-500 focus:border-orange-500" placeholder="Nama / NISN...">
                    </div>
                </div>

                <!-- Status -->
                <div class="space-y-1.5">
                    <label for="status" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Status Kehadiran</label>
                    <select name="status" id="status" class="block w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-800 dark:text-slate-200 text-xs focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">Semua Status</option>
                        <option value="Hadir" {{ $status === 'Hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="Sakit" {{ $status === 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="Izin" {{ $status === 'Izin' ? 'selected' : '' }}>Izin</option>
                    </select>
                </div>

                <!-- Date -->
                <div class="space-y-1.5">
                    <label for="tanggal" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ $tanggal }}" class="block w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-800 dark:text-slate-200 text-xs focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                </div>

                <!-- Submit Button -->
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 py-2 px-4 bg-orange-600 text-white rounded-xl text-xs font-bold hover:bg-orange-500 shadow-md shadow-orange-600/10 active:scale-95 transition-all cursor-pointer">
                        <i class="fa-solid fa-filter mr-1"></i> Filter
                    </button>
                    @if($search || $status || $tanggal !== today()->toDateString())
                        <a href="{{ route('portalpkl.admin.kehadiran') }}" class="py-2 px-4 bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold hover:bg-slate-200 dark:hover:bg-slate-800 transition-all flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table of Attendances -->
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl overflow-hidden transition-all duration-300">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                    <thead class="text-xs text-slate-700 dark:text-slate-300 uppercase bg-slate-100/50 dark:bg-slate-900/50">
                        <tr>
                            <th class="px-6 py-4">Siswa</th>
                            <th class="px-6 py-4">Kelas</th>
                            <th class="px-6 py-4">Tempat PKL</th>
                            <th class="px-6 py-4">Tanggal & Jam</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                        @forelse($attendances as $att)
                            <tr class="hover:bg-slate-50/40 dark:hover:bg-slate-900/20 transition-all">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-slate-100">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 dark:text-slate-200">{{ $att->siswa->user->name ?? 'User error' }}</span>
                                        <span class="text-xs text-slate-400 font-mono mt-0.5">{{ $att->siswa->nisn }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $att->siswa->kelas->nama_kelas ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $att->siswa->mitra->nama_perusahaan ?? 'Belum PKL' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-slate-700 dark:text-slate-300 font-semibold">{{ \Carbon\Carbon::parse($att->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                                        <span class="text-[10px] text-slate-400 mt-0.5">{{ $att->created_at->format('H:i') }} WIB</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold 
                                        @if($att->status === 'Hadir') bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200/30
                                        @elseif($att->status === 'Sakit') bg-amber-100 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 border border-amber-200/30
                                        @else bg-blue-100 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 border border-blue-200/30 @endif">
                                        {{ $att->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick="showDetailModal({{ json_encode($att) }}, {{ json_encode($att->siswa->user) }}, {{ json_encode($att->siswa->kelas) }}, {{ json_encode($att->siswa->mitra) }})" class="py-1.5 px-3 bg-orange-50 dark:bg-orange-950/30 hover:bg-orange-100 dark:hover:bg-orange-900/40 text-orange-600 dark:text-orange-400 rounded-xl text-xs font-bold transition-all border border-orange-200/30 dark:border-orange-900/20 active:scale-95 cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-eye text-[10px]"></i> Detail
                                        </button>
                                        <form action="{{ route('portalpkl.admin.kehadiran.destroy', $att->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data presensi {{ $att->siswa->user->name ?? 'siswa ini' }}?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="py-1.5 px-3 bg-rose-50 dark:bg-rose-950/30 hover:bg-rose-100 dark:hover:bg-rose-900/40 text-rose-600 dark:text-rose-400 rounded-xl text-xs font-bold transition-all border border-rose-200/30 dark:border-rose-900/20 active:scale-95 cursor-pointer flex items-center gap-1">
                                                <i class="fa-solid fa-trash-can text-[10px]"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-400 dark:text-slate-500 font-medium">
                                    Belum ada data presensi siswa yang ditemukan pada tanggal filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($attendances->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- ===================== MODALS ===================== -->
    @push('modals')
    <!-- Detail Modal Dialog -->
    <div id="detail-modal" class="fixed inset-0 z-50 overflow-y-auto hidden flex items-center justify-center p-4 sm:p-6 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300">
        <div class="relative w-full max-w-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 shadow-2xl rounded-3xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="detail-modal-card">
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-address-card text-orange-500"></i> Detail Keterangan Presensi Siswa
                </h3>
                <button type="button" onclick="closeDetailModal()" class="h-8 w-8 rounded-full bg-slate-50 dark:bg-slate-800/60 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 flex items-center justify-center transition-all cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="px-6 py-6 space-y-5 max-h-[70vh] overflow-y-auto text-slate-600 dark:text-slate-400">
                <!-- Profile Section -->
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4 p-4 bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 rounded-2xl">
                    <div class="space-y-1">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Identitas Siswa</span>
                        <h4 id="modal-name" class="font-extrabold text-slate-800 dark:text-slate-100 text-base">Muhammad Rafli</h4>
                        <p class="text-xs text-slate-400"><span id="modal-nisn" class="font-mono">1000000011</span> | <span id="modal-kelas">XII TKJ 1</span></p>
                    </div>

                    <div class="space-y-1">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Pembimbing</span>
                        <h4 id="modal-pembimbing" class="font-bold text-slate-800 dark:text-slate-100 text-sm">-</h4>
                    </div>
                    
                    <div class="space-y-1 text-left sm:text-right">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Tempat PKL</span>
                        <h4 id="modal-company" class="font-bold text-slate-800 dark:text-slate-100 text-sm">CV. Creative Media</h4>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider block">Tanggal</span>
                        <span id="modal-date" class="text-slate-700 dark:text-slate-300 font-semibold text-sm">Minggu, 05 Juli 2026</span>
                    </div>
                    <div>
                        <span class="text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider block">Jam</span>
                        <span id="modal-time" class="text-slate-700 dark:text-slate-300 font-semibold text-sm">08:23 WIB</span>
                    </div>
                    <div>
                        <span class="text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider block">Status Kehadiran</span>
                        <span id="modal-status" class="inline-block mt-0.5 px-3 py-1 rounded-full font-bold">Hadir</span>
                    </div>
                </div>

                <!-- HADIR details (Coordinates & Photo & Journal) -->
                <div id="modal-hadir-section" class="space-y-4 pt-2 border-t border-slate-100 dark:border-slate-800/80">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Coordinates -->
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Koordinat Siswa</span>
                            <div class="flex items-center gap-1.5">
                                <span id="modal-coords" class="text-slate-700 dark:text-slate-300 font-mono font-semibold text-xs">-8.26789, 113.62345</span>
                                <a id="modal-map-link" href="#" target="_blank" class="text-orange-600 dark:text-orange-400 text-xs hover:underline flex items-center gap-0.5">
                                    <i class="fa-solid fa-map-location-dot"></i> Peta
                                </a>
                            </div>
                        </div>
                        
                        <!-- Target Coordinates -->
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Target Lokasi PKL</span>
                            <span id="modal-target-coords" class="text-slate-700 dark:text-slate-300 font-mono text-xs"> -8.26789, 113.62345</span>
                        </div>
                    </div>

                    <!-- Journal & Snapshot Photo Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Journal -->
                        <div id="modal-journal-container" class="md:col-span-2 space-y-1.5">
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Journal Kegiatan Harian</span>
                            <div id="modal-journal" class="h-full p-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 text-sm rounded-2xl whitespace-pre-line leading-relaxed min-h-[120px]">
                                Mengerjakan perbaikan frontend admin Portal PKL.
                            </div>
                        </div>

                        <!-- Snapshot Photo -->
                        <div id="modal-photo-container" class="md:col-span-1 space-y-1.5 flex flex-col justify-between">
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Bukti Foto Presensi</span>
                            <div class="flex-1 flex flex-col justify-between gap-2">
                                <div class="relative group rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow bg-slate-100 dark:bg-slate-900 w-full aspect-video md:aspect-[4/3] flex items-center justify-center cursor-pointer" onclick="openLightbox(document.getElementById('modal-photo').src)">
                                    <img id="modal-photo" src="" alt="Bukti Foto" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-slate-950/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                                        <span class="text-white text-[10px] font-semibold bg-slate-900/80 px-2 py-0.5 rounded-full flex items-center gap-1 shadow">
                                            <i class="fa-solid fa-maximize text-[8px]"></i> Perbesar
                                        </span>
                                    </div>
                                </div>
                                <button type="button" onclick="openLightbox(document.getElementById('modal-photo').src)" class="w-full py-2 px-3 bg-orange-50 dark:bg-orange-950/30 hover:bg-orange-100 dark:hover:bg-orange-900/40 text-orange-600 dark:text-orange-400 rounded-xl text-xs font-bold transition-all border border-orange-200/30 dark:border-orange-900/20 active:scale-95 cursor-pointer flex items-center justify-center gap-1.5 shadow-sm">
                                    <i class="fa-solid fa-eye"></i> Lihat Foto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SAKIT / IZIN details (Keterangan) -->
                <div id="modal-ket-section" class="space-y-4 pt-2 border-t border-slate-100 dark:border-slate-800/80 hidden">
                    <div class="space-y-1.5">
                        <span id="modal-ket-title" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Keterangan / Alasan</span>
                        <div id="modal-keterangan" class="p-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 text-sm rounded-2xl whitespace-pre-line leading-relaxed">
                            Sakit demam, surat keterangan dokter terlampir.
                        </div>
                    </div>

                    <!-- Document Attachment -->
                    <div id="modal-attachment-container" class="space-y-1.5 hidden">
                        <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Lampiran Bukti</span>
                        
                        <!-- Image Attachment Wrapper -->
                        <div id="modal-attachment-image-wrapper" class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 max-w-[200px] shadow bg-slate-100 dark:bg-slate-900 relative group cursor-pointer" onclick="openLightbox(document.getElementById('modal-attachment').src)">
                            <img id="modal-attachment" src="" alt="Lampiran" class="w-full h-auto object-cover max-h-44 transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-slate-950/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                                <span class="text-white text-[10px] font-semibold bg-slate-900/80 px-2 py-0.5 rounded-full flex items-center gap-1 shadow">
                                    <i class="fa-solid fa-maximize text-[8px]"></i> Perbesar
                                </span>
                            </div>
                            <a id="modal-attachment-download" href="#" download class="absolute bottom-2 right-2 h-7 w-7 bg-orange-600 hover:bg-orange-500 text-white rounded-full flex items-center justify-center shadow active:scale-90 transition-all cursor-pointer" onclick="event.stopPropagation()">
                                <i class="fa-solid fa-download text-[10px]"></i>
                            </a>
                        </div>

                        <!-- PDF Attachment Wrapper -->
                        <div id="modal-attachment-pdf-wrapper" class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl max-w-xs shadow-sm hidden">
                            <i class="fa-solid fa-file-pdf text-3xl text-rose-600"></i>
                            <div class="flex-1 min-w-0">
                                <span class="block text-xs font-semibold truncate text-slate-700 dark:text-slate-300">Dokumen Lampiran.pdf</span>
                                <a id="modal-attachment-pdf-download" href="#" download class="text-[10px] text-orange-600 dark:text-orange-400 font-bold hover:underline">Unduh Lampiran</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox Modal Dialog -->
    <div id="lightbox-modal" class="fixed inset-0 z-[60] overflow-y-auto hidden flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm transition-all duration-300" onclick="closeLightboxModal()">
        <div class="relative max-w-4xl w-full flex flex-col items-center justify-center transition-all duration-300 transform scale-95 opacity-0" id="lightbox-card" onclick="event.stopPropagation()">
            <!-- Close Button -->
            <button type="button" onclick="closeLightboxModal()" class="absolute -top-12 right-0 md:-top-16 md:-right-16 h-10 w-10 rounded-full bg-slate-900/60 hover:bg-slate-800 text-white flex items-center justify-center transition-all cursor-pointer border border-slate-700/50">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
            <!-- Image Frame -->
            <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-2xl bg-white dark:bg-slate-950 p-2 max-h-[80vh] flex items-center justify-center">
                <img id="lightbox-image" src="" alt="Bukti Foto Penuh" class="max-w-full max-h-[75vh] object-contain rounded-lg">
            </div>
        </div>
    </div>

    <!-- Modal Scripts -->
    <script>
        const modal = document.getElementById('detail-modal');
        const modalCard = document.getElementById('detail-modal-card');

        function showDetailModal(attendance, user, kelas, mitra) {
            // Populate Identity
            document.getElementById('modal-name').innerText = user.name;
            document.getElementById('modal-nisn').innerText = attendance.siswa_id; // NISN or siswa ID
            document.getElementById('modal-kelas').innerText = kelas ? kelas.nama_kelas : '-';
            document.getElementById('modal-company').innerText = mitra ? mitra.nama_perusahaan : 'Belum PKL';

            // Populate Pembimbing
            const pembimbingName = (mitra && mitra.pembimbings && mitra.pembimbings.length > 0)
                ? mitra.pembimbings[0].name
                : 'Belum ditugaskan';
            document.getElementById('modal-pembimbing').innerText = pembimbingName;

            // Populate Date, Time & Status
            const dateObj = new Date(attendance.created_at);
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const timeOptions = { hour: '2-digit', minute: '2-digit' };
            document.getElementById('modal-date').innerText = dateObj.toLocaleDateString('id-ID', dateOptions);
            document.getElementById('modal-time').innerText = dateObj.toLocaleTimeString('id-ID', timeOptions).replace(/\./g, ':') + ' WIB';

            const statusEl = document.getElementById('modal-status');
            statusEl.innerText = attendance.status;
            statusEl.className = "inline-block mt-0.5 px-3 py-1 rounded-full font-bold text-xs ";
            if (attendance.status === 'Hadir') {
                statusEl.classList.add("bg-emerald-100", "dark:bg-emerald-950/40", "text-emerald-600", "dark:text-emerald-400", "border", "border-emerald-200/30");
            } else if (attendance.status === 'Sakit') {
                statusEl.classList.add("bg-amber-100", "dark:bg-amber-950/40", "text-amber-600", "dark:text-amber-400", "border", "border-amber-200/30");
            } else {
                statusEl.classList.add("bg-blue-100", "dark:bg-blue-950/40", "text-blue-600", "dark:text-blue-400", "border", "border-blue-200/30");
            }

            // Hide/Show Sections
            const hadirSec = document.getElementById('modal-hadir-section');
            const ketSec = document.getElementById('modal-ket-section');

            if (attendance.status === 'Hadir') {
                hadirSec.classList.remove('hidden');
                ketSec.classList.add('hidden');

                // Hadir Specific Fields
                document.getElementById('modal-coords').innerText = attendance.koordinat || 'Tidak ada koordinat';
                document.getElementById('modal-target-coords').innerText = mitra ? (mitra.koordinat || 'Tidak diatur') : '-';
                document.getElementById('modal-map-link').href = `https://maps.google.com/?q=${attendance.koordinat}`;
                document.getElementById('modal-journal').innerText = attendance.journal_kegiatan || 'Tidak ada isi jurnal.';
                
                const photoEl = document.getElementById('modal-photo');
                const photoContainer = document.getElementById('modal-photo-container');
                const journalContainer = document.getElementById('modal-journal-container');

                if (attendance.foto) {
                    photoEl.src = `/storage/${attendance.foto}`;
                    photoContainer.classList.remove('hidden');
                    journalContainer.classList.remove('md:col-span-3');
                    journalContainer.classList.add('md:col-span-2');
                } else {
                    photoEl.src = "";
                    photoContainer.classList.add('hidden');
                    journalContainer.classList.remove('md:col-span-2');
                    journalContainer.classList.add('md:col-span-3');
                }
            } else {
                hadirSec.classList.add('hidden');
                ketSec.classList.remove('hidden');

                // Sick / Leave Specific Fields
                document.getElementById('modal-ket-title').innerText = attendance.status === 'Sakit' ? 'Keterangan Sakit' : 'Keterangan Izin';
                document.getElementById('modal-keterangan').innerText = attendance.keterangan || 'Tidak ada keterangan.';

                const attachContainer = document.getElementById('modal-attachment-container');
                const imgWrapper = document.getElementById('modal-attachment-image-wrapper');
                const pdfWrapper = document.getElementById('modal-attachment-pdf-wrapper');

                if (attendance.foto) {
                    const filePath = `/storage/${attendance.foto}`;
                    
                    if (attendance.foto.toLowerCase().endsWith('.pdf')) {
                        // PDF File
                        pdfWrapper.classList.remove('hidden');
                        imgWrapper.classList.add('hidden');
                        document.getElementById('modal-attachment-pdf-download').href = filePath;
                    } else {
                        // Image File
                        imgWrapper.classList.remove('hidden');
                        pdfWrapper.classList.add('hidden');
                        
                        document.getElementById('modal-attachment').src = filePath;
                        document.getElementById('modal-attachment-download').href = filePath;
                    }
                    attachContainer.classList.remove('hidden');
                } else {
                    imgWrapper.classList.add('hidden');
                    pdfWrapper.classList.add('hidden');
                    attachContainer.classList.add('hidden');
                }
            }

            // Open Modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalCard.classList.remove('scale-95', 'opacity-0');
                modalCard.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeDetailModal() {
            modalCard.classList.remove('scale-100', 'opacity-100');
            modalCard.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function openLightbox(src) {
            const lightbox = document.getElementById('lightbox-modal');
            const lightboxCard = document.getElementById('lightbox-card');
            const lightboxImg = document.getElementById('lightbox-image');
            
            lightboxImg.src = src;
            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');
            setTimeout(() => {
                lightboxCard.classList.remove('scale-95', 'opacity-0');
                lightboxCard.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeLightboxModal() {
            const lightbox = document.getElementById('lightbox-modal');
            const lightboxCard = document.getElementById('lightbox-card');
            
            lightboxCard.classList.remove('scale-100', 'opacity-100');
            lightboxCard.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
            }, 300);
        }
    </script>
    @endpush
@endsection
