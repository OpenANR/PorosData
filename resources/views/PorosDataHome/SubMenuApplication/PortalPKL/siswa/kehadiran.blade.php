@extends('PorosDataHome.SubMenuApplication.PortalPKL.layouts.app')

@section('title', 'Kehadiran PKL')

@section('content')
    <div class="space-y-6">
        <!-- Welcoming / Info Card -->
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-6 sm:p-8 transition-all duration-300">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-orange-600 to-amber-500 bg-clip-text text-transparent dark:from-orange-400 dark:to-amber-300">
                        Presensi Kehadiran PKL
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">
                        Silakan lengkapi presensi harian Anda sesuai dengan lokasi dan jurnal kegiatan hari ini.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-4 py-2 rounded-2xl text-xs font-bold bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400">
                        <i class="fa-solid fa-calendar-day mr-1 text-orange-600 dark:text-orange-400"></i> 
                        {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
                    </span>
                </div>
            </div>
        </div>

        @if(isset($error_message))
            <!-- Error State if not assigned to a company -->
            <div class="glass-panel border border-rose-200/80 dark:border-rose-950/30 bg-rose-50/20 dark:bg-rose-950/10 shadow-lg rounded-3xl p-6 text-center">
                <div class="h-14 w-14 rounded-full bg-rose-100 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Penempatan PKL Belum Ditentukan</h3>
                <p class="text-slate-500 dark:text-slate-400 mt-2 max-w-md mx-auto text-sm">
                    {{ $error_message }}
                </p>
            </div>
        @else
            <!-- Main Attendance Interface -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Presence Form -->
                <div class="lg:col-span-2 space-y-6">
                    @if($todayAttendance)
                        <!-- Already Checked In -->
                        <div class="glass-panel border border-emerald-200/80 dark:border-emerald-950/30 bg-emerald-50/20 dark:bg-emerald-950/10 shadow-xl rounded-3xl p-6 sm:p-8 text-center space-y-4">
                            <div class="h-16 w-16 rounded-full bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mx-auto shadow-md">
                                <i class="fa-solid fa-circle-check text-3xl"></i>
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-xl font-extrabold text-slate-800 dark:text-slate-100">Presensi Hari Ini Selesai</h3>
                                <p class="text-slate-500 dark:text-slate-400 text-sm">
                                    Anda telah berhasil mengirimkan presensi kehadiran hari ini pada jam <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $todayAttendance->created_at->format('H:i') }} WIB</span>.
                                </p>
                            </div>

                            <div class="border-t border-slate-100 dark:border-slate-800/80 pt-4 mt-2 text-left space-y-3">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-slate-400 dark:text-slate-500 text-xs block font-medium uppercase">Status</span>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold 
                                            @if($todayAttendance->status === 'Hadir') bg-emerald-100 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400
                                            @elseif($todayAttendance->status === 'Sakit') bg-amber-100 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400
                                            @else bg-blue-100 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 @endif">
                                            {{ $todayAttendance->status }}
                                        </span>
                                    </div>
                                    @if($todayAttendance->koordinat)
                                        <div>
                                            <span class="text-slate-400 dark:text-slate-500 text-xs block font-medium uppercase">Koordinat GPS</span>
                                            <span class="text-slate-700 dark:text-slate-300 font-mono text-xs">{{ $todayAttendance->koordinat }}</span>
                                        </div>
                                    @endif
                                </div>

                                @if($todayAttendance->journal_kegiatan)
                                    <div>
                                        <span class="text-slate-400 dark:text-slate-500 text-xs block font-medium uppercase">Journal Kegiatan</span>
                                        <p class="text-slate-700 dark:text-slate-300 text-sm bg-slate-50 dark:bg-slate-900/60 p-3 rounded-xl border border-slate-100 dark:border-slate-800/50 mt-1">
                                            {{ $todayAttendance->journal_kegiatan }}
                                        </p>
                                    </div>
                                @endif

                                @if($todayAttendance->keterangan)
                                    <div>
                                        <span class="text-slate-400 dark:text-slate-500 text-xs block font-medium uppercase">Keterangan / Alasan</span>
                                        <p class="text-slate-700 dark:text-slate-300 text-sm bg-slate-50 dark:bg-slate-900/60 p-3 rounded-xl border border-slate-100 dark:border-slate-800/50 mt-1">
                                            {{ $todayAttendance->keterangan }}
                                        </p>
                                    </div>
                                @endif

                                @if($todayAttendance->foto)
                                    <div>
                                        <span class="text-slate-400 dark:text-slate-500 text-xs block font-medium uppercase mb-1">Bukti</span>
                                        @if(pathinfo($todayAttendance->foto, PATHINFO_EXTENSION) === 'pdf')
                                            <div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl max-w-xs shadow-sm">
                                                <i class="fa-solid fa-file-pdf text-3xl text-rose-600"></i>
                                                <div class="flex-1 min-w-0">
                                                    <span class="block text-xs font-semibold truncate text-slate-700 dark:text-slate-300">Dokumen Lampiran.pdf</span>
                                                    <a href="/storage/{{ $todayAttendance->foto }}" download class="text-[10px] text-orange-600 dark:text-orange-400 font-bold hover:underline">Unduh File</a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="relative rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 max-w-[180px] shadow-sm bg-slate-100 dark:bg-slate-900">
                                                <img src="/storage/{{ $todayAttendance->foto }}" alt="Bukti Presensi" class="w-full h-auto object-cover max-h-36">
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Form Entry -->
                        <form action="{{ route('portalpkl.siswa.kehadiran.store') }}" method="POST" enctype="multipart/form-data" id="attendanceForm" class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-6 sm:p-8 space-y-6 transition-all duration-300">
                            @csrf
                            
                            <!-- Presence Status (Radio/Tabs selector) -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Status Kehadiran</label>
                                <div class="grid grid-cols-3 gap-3" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                                    <!-- Hadir -->
                                    <label id="label-status-hadir" class="relative flex flex-row items-center justify-center gap-2 py-3 px-4 rounded-2xl border-2 cursor-pointer transition-all border-emerald-500 bg-emerald-50/20 dark:border-emerald-500 dark:bg-emerald-950/20" style="display: flex; flex-direction: row; align-items: center; justify-content: center; gap: 8px;">
                                        <input type="radio" name="status" value="Hadir" checked class="sr-only" onchange="toggleStatusView('Hadir')">
                                        <i class="fa-solid fa-circle-check text-base text-emerald-600 dark:text-emerald-400"></i>
                                        <span class="text-xs font-extrabold text-slate-800 dark:text-slate-200">Hadir</span>
                                    </label>
                                    
                                    <!-- Sakit -->
                                    <label id="label-status-sakit" class="relative flex flex-row items-center justify-center gap-2 py-3 px-4 rounded-2xl border-2 cursor-pointer transition-all border-slate-200 dark:border-slate-800 hover:border-amber-500/50 dark:hover:border-amber-500/30" style="display: flex; flex-direction: row; align-items: center; justify-content: center; gap: 8px;">
                                        <input type="radio" name="status" value="Sakit" class="sr-only" onchange="toggleStatusView('Sakit')">
                                        <i class="fa-solid fa-thermometer text-base text-slate-400 dark:text-slate-500"></i>
                                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Sakit</span>
                                    </label>
                                    
                                    <!-- Izin -->
                                    <label id="label-status-izin" class="relative flex flex-row items-center justify-center gap-2 py-3 px-4 rounded-2xl border-2 cursor-pointer transition-all border-slate-200 dark:border-slate-800 hover:border-blue-500/50 dark:hover:border-blue-500/30" style="display: flex; flex-direction: row; align-items: center; justify-content: center; gap: 8px;">
                                        <input type="radio" name="status" value="Izin" class="sr-only" onchange="toggleStatusView('Izin')">
                                        <i class="fa-solid fa-envelope text-base text-slate-400 dark:text-slate-500"></i>
                                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Izin</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Section: HADIR -->
                            <div id="section-hadir" class="space-y-6">
                                <!-- Photo Bukti Kehadiran (Webcam / File Upload) -->
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Bukti Kehadiran (Foto)</label>
                                    
                                    <!-- Source Selector -->
                                    <div class="flex items-center gap-3 mb-4">
                                        <button type="button" id="btn-source-camera" onclick="setPhotoSource('camera')" class="flex-1 flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-orange-500 bg-orange-500/10 text-orange-600 dark:text-orange-400 text-xs font-semibold hover:bg-orange-500/20 transition-all cursor-pointer">
                                            <i class="fa-solid fa-camera"></i> Kamera
                                        </button>
                                        <button type="button" id="btn-source-gallery" onclick="setPhotoSource('gallery')" class="flex-1 flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-transparent text-slate-600 dark:text-slate-400 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-slate-900 transition-all cursor-pointer">
                                            <i class="fa-solid fa-images"></i> Galeri
                                        </button>
                                    </div>

                                    <input type="hidden" name="foto_source" id="foto_source" value="camera">
                                    <input type="hidden" name="foto_uri" id="foto_uri">

                                    <!-- Camera View Container -->
                                    <div id="container-camera" class="space-y-3">
                                        <div class="relative w-full max-w-sm mx-auto aspect-video min-h-[220px] rounded-2xl overflow-hidden bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-inner flex items-center justify-center">
                                            <!-- Video stream -->
                                            <video id="webcam" autoplay playsinline class="w-full h-full object-cover"></video>
                                            <!-- Snapshot Preview -->
                                            <img id="camera-preview" class="absolute inset-0 w-full h-full object-cover hidden">
                                            
                                            <!-- Fallback Message -->
                                            <div id="webcam-fallback" class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center text-slate-400 hidden">
                                                <i class="fa-solid fa-video-slash text-2xl mb-2 text-rose-500"></i>
                                                <p id="webcam-fallback-text" class="text-xs font-semibold mb-3">Gagal memuat kamera. Pastikan Anda memberikan izin akses kamera.</p>
                                                <button type="button" onclick="simulateCamera()" class="px-4 py-2 bg-amber-600 hover:bg-amber-500 text-white rounded-xl text-xs font-bold transition-all shadow-md flex items-center gap-1.5 cursor-pointer">
                                                    <i class="fa-solid fa-laptop-code"></i> Gunakan Kamera Simulasi (Dev Mode)
                                                </button>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-center gap-3">
                                            <!-- Capture Button -->
                                            <button type="button" id="btn-capture" onclick="capturePhoto()" class="flex items-center gap-2 py-2 px-4 rounded-xl bg-orange-600 text-white hover:bg-orange-500 active:scale-95 text-xs font-semibold shadow-sm transition-all cursor-pointer">
                                                <i class="fa-solid fa-circle-dot"></i> Ambil Foto
                                            </button>
                                            <!-- Retake Button -->
                                            <button type="button" id="btn-retake" onclick="resetCamera()" class="flex items-center gap-2 py-2 px-4 rounded-xl bg-slate-600 text-white hover:bg-slate-500 text-xs font-semibold shadow-sm transition-all cursor-pointer hidden">
                                                <i class="fa-solid fa-rotate-left"></i> Ulangi Foto
                                            </button>
                                            <!-- Switch Camera Button -->
                                            <button type="button" id="btn-switch-camera" onclick="switchCamera()" class="flex items-center gap-2 py-2 px-4 rounded-xl bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 text-xs font-semibold shadow-sm transition-all cursor-pointer">
                                                <i class="fa-solid fa-camera-rotate"></i> Ubah Kamera
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Gallery Upload Container -->
                                    <div id="container-gallery" class="hidden">
                                        <div class="flex justify-center items-center w-full">
                                            <label class="flex flex-col justify-center items-center w-full h-44 bg-slate-50 dark:bg-slate-900/40 rounded-2xl border-2 border-slate-300 border-dashed cursor-pointer dark:hover:bg-slate-800/40 hover:bg-slate-100/50 transition-colors">
                                                <div class="flex flex-col justify-center items-center pt-5 pb-6 text-center px-4">
                                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-orange-500 mb-2"></i>
                                                    <p class="mb-1 text-sm text-slate-700 dark:text-slate-300 font-semibold">Pilih file foto</p>
                                                    <p class="text-xs text-slate-400">PNG, JPG atau JPEG (Max 5MB)</p>
                                                </div>
                                                <input type="file" id="foto_file" name="foto_file" class="hidden" accept="image/*" onchange="previewFile(this)">
                                            </label>
                                        </div>
                                        <!-- File Preview -->
                                        <div id="file-preview-container" class="mt-3 relative w-full max-w-sm mx-auto aspect-video rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hidden">
                                            <img id="file-preview-img" class="w-full h-full object-cover">
                                            <button type="button" onclick="removeFilePreview()" class="absolute top-2 right-2 h-7 w-7 bg-rose-600 text-white rounded-full flex items-center justify-center hover:bg-rose-500 shadow active:scale-90 cursor-pointer">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- GPS Coordinates -->
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Koordinat GPS</label>
                                    <div class="flex gap-2">
                                        <div class="relative flex-1">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </span>
                                            <input type="text" name="koordinat" id="koordinat" readonly required class="block w-full pl-9 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-800 dark:text-slate-200 font-mono text-sm focus:ring-1 focus:ring-orange-500 focus:border-orange-500" placeholder="Mendapatkan koordinat GPS...">
                                        </div>
                                        <button type="button" onclick="getLocation()" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all cursor-pointer">
                                            <i class="fa-solid fa-arrows-rotate"></i> Refresh GPS
                                        </button>
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-1 font-semibold">
                                        Koordinat GPS digunakan untuk memverifikasi jarak Anda dengan target lokasi PKL.
                                    </p>
                                </div>

                                <!-- Journal Kegiatan -->
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Journal Kegiatan Harian</label>
                                    <textarea name="journal_kegiatan" id="journal_kegiatan" rows="4" class="block w-full p-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-800 dark:text-slate-200 text-sm focus:ring-1 focus:ring-orange-500 focus:border-orange-500" placeholder="Tuliskan aktivitas atau deskripsi pekerjaan yang Anda lakukan hari ini..."></textarea>
                                </div>
                            </div>

                            <!-- Section: SAKIT / IZIN -->
                            <div id="section-keterangan" class="space-y-6 hidden">
                                <div>
                                    <label id="lbl-keterangan" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Keterangan / Alasan</label>
                                    <textarea name="keterangan" id="keterangan" rows="4" class="block w-full p-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-800 dark:text-slate-200 text-sm focus:ring-1 focus:ring-orange-500 focus:border-orange-500" placeholder="Jelaskan keterangan / alasan ketidakhadiran Anda..."></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Lampiran Bukti (Opsional)</label>
                                    <div class="flex justify-center items-center w-full">
                                        <label class="flex flex-col justify-center items-center w-full h-36 bg-slate-50 dark:bg-slate-900/40 rounded-2xl border-2 border-slate-300 border-dashed cursor-pointer dark:hover:bg-slate-800/40 hover:bg-slate-100/50 transition-colors">
                                            <div class="flex flex-col justify-center items-center pt-4 pb-5 text-center px-4">
                                                <i class="fa-solid fa-paperclip text-2xl text-slate-400 mb-1.5"></i>
                                                <p class="mb-0.5 text-xs text-slate-700 dark:text-slate-300 font-semibold">Unggah Surat Keterangan / Lampiran</p>
                                                <p class="text-[10px] text-slate-400">PNG, JPG atau PDF (Max 5MB)</p>
                                            </div>
                                            <input type="file" id="lampiran_file" name="lampiran_file" class="hidden" accept="image/*,application/pdf" onchange="previewLampiran(this)">
                                        </label>
                                    </div>
                                    <!-- File Preview -->
                                    <div id="lampiran-preview-container" class="mt-3 relative w-full max-w-sm mx-auto aspect-video rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hidden">
                                        <img id="lampiran-preview-img" class="w-full h-full object-cover">
                                        <button type="button" onclick="removeLampiranPreview()" class="absolute top-2 right-2 h-7 w-7 bg-rose-600 text-white rounded-full flex items-center justify-center hover:bg-rose-500 shadow active:scale-90 cursor-pointer">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Action -->
                            <div class="pt-4 border-t border-slate-100 dark:border-slate-800/80">
                                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-2xl bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 text-white font-extrabold text-sm shadow-lg shadow-orange-500/20 active:scale-[0.99] transition-all cursor-pointer">
                                    <i class="fa-solid fa-paper-plane"></i> Kirim Presensi Kehadiran
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

                <!-- Info Sidebar & Targets -->
                <div class="space-y-6">
                    <!-- Session / Location details -->
                    <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-6 transition-all duration-300">
                        <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100 mb-4 uppercase tracking-wider">
                            <i class="fa-solid fa-info-circle text-orange-600 dark:text-orange-400 mr-1.5"></i> Detail Sesi & Target
                        </h3>
                        <div class="space-y-4">
                            <!-- Nama Siswa -->
                            <div>
                                <span class="text-slate-400 dark:text-slate-500 text-[10px] block font-bold uppercase tracking-wider">Nama Siswa</span>
                                <span class="text-slate-800 dark:text-slate-200 text-sm font-semibold">{{ $user->name }}</span>
                            </div>
                            <!-- Tempat PKL -->
                            <div>
                                <span class="text-slate-400 dark:text-slate-500 text-[10px] block font-bold uppercase tracking-wider">Tempat PKL</span>
                                <span class="text-slate-800 dark:text-slate-200 text-sm font-semibold">{{ $siswa->mitra->nama_perusahaan }}</span>
                                <p class="text-slate-400 dark:text-slate-500 text-[11px] font-medium leading-tight mt-0.5">{{ $siswa->mitra->alamat }}</p>
                            </div>
                            <!-- Target Koordinat PKL -->
                            <div>
                                <span class="text-slate-400 dark:text-slate-500 text-[10px] block font-bold uppercase tracking-wider">Target Koordinat PKL</span>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-slate-700 dark:text-slate-300 font-mono text-xs">{{ $siswa->mitra->koordinat ?? 'Belum terkonfigurasi' }}</span>
                                    @if($siswa->mitra->koordinat)
                                        <a href="https://maps.google.com/?q={{ $siswa->mitra->koordinat }}" target="_blank" class="text-orange-600 dark:text-orange-400 text-xs hover:underline flex items-center gap-0.5">
                                            <i class="fa-solid fa-map-location-dot"></i> Peta
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <!-- Distance verification badge -->
                            <div id="distance-badge-container" class="hidden">
                                <span class="text-slate-400 dark:text-slate-500 text-[10px] block font-bold uppercase tracking-wider">Jarak dari Target</span>
                                <div class="flex items-center gap-2 mt-1">
                                    <span id="txt-distance" class="text-slate-700 dark:text-slate-300 font-bold text-xs">Menghitung...</span>
                                    <span id="badge-status-radius" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Presensi History -->
                    <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-6 transition-all duration-300">
                        <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100 mb-4 uppercase tracking-wider">
                            <i class="fa-solid fa-history text-orange-600 dark:text-orange-400 mr-1.5"></i> Riwayat Presensi (15 Hari Terakhir)
                        </h3>
                        @if($historyAttendances->isEmpty())
                            <div class="text-center py-6 text-slate-400 dark:text-slate-500 text-xs">
                                Belum ada riwayat presensi PKL.
                            </div>
                        @else
                            <div class="flow-root">
                                <ul class="divide-y divide-slate-100 dark:divide-slate-800/80 -my-2.5">
                                    @foreach($historyAttendances as $hist)
                                        <li class="py-2.5 flex items-center justify-between gap-4">
                                            <div>
                                                <span class="block text-sm font-bold text-slate-800 dark:text-slate-200">
                                                    {{ \Carbon\Carbon::parse($hist->tanggal)->isoFormat('dddd, D MMM YYYY') }}
                                                </span>
                                                <span class="block text-[10px] text-slate-400 mt-0.5">
                                                    Dikirim jam {{ $hist->created_at->format('H:i') }} WIB
                                                </span>
                                            </div>
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold 
                                                @if($hist->status === 'Hadir') bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-950/30
                                                @elseif($hist->status === 'Sakit') bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-950/30
                                                @else bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-950/30 @endif">
                                                {{ $hist->status }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Hidden canvas for camera captures -->
    <canvas id="camera-canvas" class="hidden"></canvas>

    <!-- Camera / Geo Scripts -->
    @if(!$todayAttendance && isset($siswa) && $siswa->mitra_dudi_id)
        <script>
            // Webcam & Photo Handling
            let stream = null;
            let currentFacingMode = 'user'; // 'user' (front) or 'environment' (back)
            const video = document.getElementById('webcam');
            const preview = document.getElementById('camera-preview');
            const webcamFallback = document.getElementById('webcam-fallback');
            const canvas = document.getElementById('camera-canvas');
            const inputFotoUri = document.getElementById('foto_uri');

            const btnCapture = document.getElementById('btn-capture');
            const btnRetake = document.getElementById('btn-retake');
            const btnSwitchCam = document.getElementById('btn-switch-camera');

            // Set Photo Source (Kamera vs Galeri)
            function setPhotoSource(source) {
                document.getElementById('foto_source').value = source;
                
                const btnCam = document.getElementById('btn-source-camera');
                const btnGal = document.getElementById('btn-source-gallery');
                const containerCam = document.getElementById('container-camera');
                const containerGal = document.getElementById('container-gallery');

                if (source === 'camera') {
                    btnCam.classList.add('border-orange-500', 'bg-orange-500/10', 'text-orange-600', 'dark:text-orange-400');
                    btnCam.classList.remove('border-slate-200', 'dark:border-slate-800', 'bg-transparent', 'text-slate-600', 'dark:text-slate-400');
                    
                    btnGal.classList.remove('border-orange-500', 'bg-orange-500/10', 'text-orange-600', 'dark:text-orange-400');
                    btnGal.classList.add('border-slate-200', 'dark:border-slate-800', 'bg-transparent', 'text-slate-600', 'dark:text-slate-400');

                    containerCam.classList.remove('hidden');
                    containerGal.classList.add('hidden');
                    
                    initCamera();
                } else {
                    btnGal.classList.add('border-orange-500', 'bg-orange-500/10', 'text-orange-600', 'dark:text-orange-400');
                    btnGal.classList.remove('border-slate-200', 'dark:border-slate-800', 'bg-transparent', 'text-slate-600', 'dark:text-slate-400');
                    
                    btnCam.classList.remove('border-orange-500', 'bg-orange-500/10', 'text-orange-600', 'dark:text-orange-400');
                    btnCam.classList.add('border-slate-200', 'dark:border-slate-800', 'bg-transparent', 'text-slate-600', 'dark:text-slate-400');

                    containerGal.classList.remove('hidden');
                    containerCam.classList.add('hidden');
                    
                    stopCamera();
                }
            }

            // Initialize Camera
            async function initCamera() {
                stopCamera();
                try {
                    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                        throw new Error("Kamera tidak didukung di lingkungan ini (Pastikan menggunakan HTTPS atau gunakan tab Galeri).");
                    }
                    const constraints = {
                        video: {
                            facingMode: currentFacingMode,
                            width: { ideal: 640 },
                            height: { ideal: 480 }
                        },
                        audio: false
                    };

                    stream = await navigator.mediaDevices.getUserMedia(constraints);
                    video.srcObject = stream;
                    video.classList.remove('hidden');
                    preview.classList.add('hidden');
                    webcamFallback.classList.add('hidden');
                    btnCapture.classList.remove('hidden');
                    btnRetake.classList.add('hidden');
                    btnSwitchCam.classList.remove('hidden');
                } catch (err) {
                    console.error("Camera access error:", err);
                    video.classList.add('hidden');
                    
                    const fallbackMsg = document.getElementById('webcam-fallback-text');
                    if (fallbackMsg) {
                        if (!window.isSecureContext) {
                            fallbackMsg.innerText = "Kamera tidak dapat diakses di koneksi HTTP biasa. Silakan beralih ke tab Galeri atau gunakan tombol kamera simulasi di bawah.";
                        } else {
                            fallbackMsg.innerText = err.message || "Gagal memuat kamera. Pastikan Anda memberikan izin akses kamera.";
                        }
                    }
                    
                    webcamFallback.classList.remove('hidden');
                    btnCapture.classList.add('hidden');
                    btnSwitchCam.classList.add('hidden');
                }
            }

            // Simulate Camera capture (for development over HTTP)
            function simulateCamera() {
                const ctx = canvas.getContext('2d');
                canvas.width = 640;
                canvas.height = 480;
                
                // Draw a nice gradient background
                const gradient = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
                gradient.addColorStop(0, '#f97316'); // orange-500
                gradient.addColorStop(1, '#f59e0b'); // amber-500
                ctx.fillStyle = gradient;
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                // Draw text
                ctx.fillStyle = '#ffffff';
                ctx.font = 'bold 30px sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText('SIMULASI PRESENSI PKL (DEV MODE)', canvas.width / 2, canvas.height / 2 - 40);
                
                ctx.font = '20px sans-serif';
                ctx.fillText('Nama Siswa: {{ $user->name }}', canvas.width / 2, canvas.height / 2 + 10);
                ctx.fillText('Waktu: ' + new Date().toLocaleString('id-ID'), canvas.width / 2, canvas.height / 2 + 45);
                ctx.fillText('Koneksi: HTTP (Insecure Context)', canvas.width / 2, canvas.height / 2 + 80);
                
                // Convert to base64
                const dataUri = canvas.toDataURL('image/jpeg', 0.85);
                inputFotoUri.value = dataUri;

                // Display Preview
                preview.src = dataUri;
                preview.classList.remove('hidden');
                video.classList.add('hidden');

                btnCapture.classList.add('hidden');
                btnRetake.classList.remove('hidden');
                btnSwitchCam.classList.add('hidden');
                webcamFallback.classList.add('hidden');
                
                // If GPS is empty, simulate GPS too
                const coordInput = document.getElementById('koordinat');
                if (!coordInput.value || coordInput.value.includes('ditolak') || coordInput.value.includes('tidak')) {
                    simulateGPS();
                }
            }

            function simulateGPS() {
                const coordInput = document.getElementById('koordinat');
                if (targetCoordsStr) {
                    coordInput.value = targetCoordsStr;
                    coordInput.removeAttribute('readonly');
                    
                    // Trigger distance check
                    const targetParts = targetCoordsStr.split(',');
                    if (targetParts.length === 2) {
                        const targetLat = parseFloat(targetParts[0].trim());
                        const targetLon = parseFloat(targetParts[1].trim());
                        const distanceMeters = 0; // Exactly at location
                        displayDistance(distanceMeters);
                    }
                } else {
                    coordInput.value = "-8.18448, 113.62166";
                    coordInput.removeAttribute('readonly');
                }
            }

            // Stop Camera Stream
            function stopCamera() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }
            }

            // Switch Front/Back Camera
            function switchCamera() {
                currentFacingMode = currentFacingMode === 'user' ? 'environment' : 'user';
                initCamera();
            }

            // Capture Photo
            function capturePhoto() {
                if (stream) {
                    const ctx = canvas.getContext('2d');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    
                    // Draw flipped image if front camera is used (optional, let's keep it simple)
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                    
                    // Convert to base64
                    const dataUri = canvas.toDataURL('image/jpeg', 0.85);
                    inputFotoUri.value = dataUri;

                    // Display Preview
                    preview.src = dataUri;
                    preview.classList.remove('hidden');
                    video.classList.add('hidden');

                    btnCapture.classList.add('hidden');
                    btnRetake.classList.remove('hidden');
                    
                    stopCamera();
                }
            }

            // Reset / Retake Photo
            function resetCamera() {
                inputFotoUri.value = "";
                preview.classList.add('hidden');
                initCamera();
            }

            // Preview Uploaded File
            function previewFile(input) {
                const previewContainer = document.getElementById('file-preview-container');
                const previewImg = document.getElementById('file-preview-img');
                
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function removeFilePreview() {
                document.getElementById('foto_file').value = "";
                document.getElementById('file-preview-container').classList.add('hidden');
                document.getElementById('file-preview-img').src = "";
            }

            // Preview Lampiran for Sakit/Izin
            function previewLampiran(input) {
                const previewContainer = document.getElementById('lampiran-preview-container');
                const previewImg = document.getElementById('lampiran-preview-img');
                
                if (input.files && input.files[0]) {
                    if (input.files[0].type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            previewContainer.classList.remove('hidden');
                        }
                        reader.readAsDataURL(input.files[0]);
                    } else {
                        // PDF or other file
                        previewImg.src = "https://cdn-icons-png.flaticon.com/512/337/337946.png"; // PDF Icon placeholder
                        previewContainer.classList.remove('hidden');
                    }
                }
            }

            function removeLampiranPreview() {
                document.getElementById('lampiran_file').value = "";
                document.getElementById('lampiran-preview-container').classList.add('hidden');
                document.getElementById('lampiran-preview-img').src = "";
            }

            // Toggle views based on Status (Hadir, Sakit, Izin)
            function toggleStatusView(status) {
                const secHadir = document.getElementById('section-hadir');
                const secKet = document.getElementById('section-keterangan');
                const lblKet = document.getElementById('lbl-keterangan');
                const inputJournal = document.getElementById('journal_kegiatan');
                const inputKoordinat = document.getElementById('koordinat');
                const inputKet = document.getElementById('keterangan');

                // Toggle active state classes for labels
                const lblHadir = document.getElementById('label-status-hadir');
                const lblSakit = document.getElementById('label-status-sakit');
                const lblIzin = document.getElementById('label-status-izin');

                // Reset all to unselected states
                [
                    { el: lblHadir, border: 'border-slate-200 dark:border-slate-800', hover: 'hover:border-emerald-500/50 dark:hover:border-emerald-500/30', bg: 'bg-transparent', iconColor: 'text-slate-400 dark:text-slate-500', textColor: 'text-slate-500 dark:text-slate-400 font-bold' },
                    { el: lblSakit, border: 'border-slate-200 dark:border-slate-800', hover: 'hover:border-amber-500/50 dark:hover:border-amber-500/30', bg: 'bg-transparent', iconColor: 'text-slate-400 dark:text-slate-500', textColor: 'text-slate-500 dark:text-slate-400 font-bold' },
                    { el: lblIzin, border: 'border-slate-200 dark:border-slate-800', hover: 'hover:border-blue-500/50 dark:hover:border-blue-500/30', bg: 'bg-transparent', iconColor: 'text-slate-400 dark:text-slate-500', textColor: 'text-slate-500 dark:text-slate-400 font-bold' }
                ].forEach(item => {
                    item.el.className = `relative flex flex-row items-center justify-center gap-2 py-3 px-4 rounded-2xl border-2 cursor-pointer transition-all ${item.border} ${item.hover} ${item.bg}`;
                    item.el.style.display = 'flex';
                    item.el.style.flexDirection = 'row';
                    item.el.style.alignItems = 'center';
                    item.el.style.justifyContent = 'center';
                    item.el.style.gap = '8px';
                    
                    const icon = item.el.querySelector('i');
                    icon.className = icon.className.split(' ').filter(c => !c.startsWith('text-')).join(' ') + ' ' + item.iconColor;
                    
                    const text = item.el.querySelector('span');
                    text.className = `text-xs ${item.textColor}`;
                });

                if (status === 'Hadir') {
                    lblHadir.className = "relative flex flex-row items-center justify-center gap-2 py-3 px-4 rounded-2xl border-2 cursor-pointer transition-all border-emerald-500 bg-emerald-50/20 dark:border-emerald-500 dark:bg-emerald-950/20";
                    lblHadir.style.display = 'flex';
                    lblHadir.style.flexDirection = 'row';
                    lblHadir.querySelector('i').className = "fa-solid fa-circle-check text-base text-emerald-600 dark:text-emerald-400";
                    lblHadir.querySelector('span').className = "text-xs font-extrabold text-slate-800 dark:text-slate-200";

                    secHadir.classList.remove('hidden');
                    secKet.classList.add('hidden');
                    inputJournal.setAttribute('required', 'required');
                    inputKoordinat.setAttribute('required', 'required');
                    inputKet.removeAttribute('required');
                    initCamera();
                } else {
                    secHadir.classList.add('hidden');
                    secKet.classList.remove('hidden');
                    inputJournal.removeAttribute('required');
                    inputKoordinat.removeAttribute('required');
                    inputKet.setAttribute('required', 'required');
                    
                    if (status === 'Sakit') {
                        lblSakit.className = "relative flex flex-row items-center justify-center gap-2 py-3 px-4 rounded-2xl border-2 cursor-pointer transition-all border-amber-500 bg-amber-50/20 dark:border-amber-500 dark:bg-amber-950/20";
                        lblSakit.style.display = 'flex';
                        lblSakit.style.flexDirection = 'row';
                        lblSakit.querySelector('i').className = "fa-solid fa-thermometer text-base text-amber-600 dark:text-amber-400";
                        lblSakit.querySelector('span').className = "text-xs font-extrabold text-slate-800 dark:text-slate-200";

                        lblKet.innerText = "Keterangan / Alasan Sakit";
                        inputKet.placeholder = "Jelaskan penyakit atau alasan sakit Anda...";
                    } else {
                        lblIzin.className = "relative flex flex-row items-center justify-center gap-2 py-3 px-4 rounded-2xl border-2 cursor-pointer transition-all border-blue-500 bg-blue-50/20 dark:border-blue-500 dark:bg-blue-950/20";
                        lblIzin.style.display = 'flex';
                        lblIzin.style.flexDirection = 'row';
                        lblIzin.querySelector('i').className = "fa-solid fa-envelope text-base text-blue-600 dark:text-blue-400";
                        lblIzin.querySelector('span').className = "text-xs font-extrabold text-slate-800 dark:text-slate-200";

                        lblKet.innerText = "Keterangan Izin";
                        inputKet.placeholder = "Jelaskan keperluan atau keterangan izin Anda secara rinci...";
                    }
                    
                    stopCamera();
                }
            }

            // Geolocation and Radius Check
            const targetCoordsStr = "{{ $siswa->mitra->koordinat }}";

            function getLocation() {
                const coordInput = document.getElementById('koordinat');
                if (navigator.geolocation) {
                    coordInput.placeholder = "Mendapatkan lokasi...";
                    navigator.geolocation.getCurrentPosition(showPosition, showError, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    });
                } else {
                    coordInput.value = "";
                    coordInput.placeholder = "Geolocation tidak didukung. Ketik koordinat secara manual...";
                    coordInput.removeAttribute('readonly');
                }
            }

            function showPosition(position) {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;
                const currentCoordsStr = `${lat}, ${lon}`;
                document.getElementById('koordinat').value = currentCoordsStr;

                // Distance calculation
                if (targetCoordsStr) {
                    const targetParts = targetCoordsStr.split(',');
                    if (targetParts.length === 2) {
                        const targetLat = parseFloat(targetParts[0].trim());
                        const targetLon = parseFloat(targetParts[1].trim());
                        
                        const distanceMeters = calculateDistance(lat, lon, targetLat, targetLon);
                        displayDistance(distanceMeters);
                    }
                }
            }

            function showError(error) {
                const coordInput = document.getElementById('koordinat');
                coordInput.removeAttribute('readonly');
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        if (!window.isSecureContext) {
                            coordInput.value = "";
                            coordInput.placeholder = "Akses lokasi ditolak karena koneksi HTTP tidak aman. Masukkan koordinat manual...";
                        } else {
                            coordInput.value = "";
                            coordInput.placeholder = "Izin lokasi ditolak. Silakan masukkan koordinat secara manual...";
                        }
                        break;
                    case error.POSITION_UNAVAILABLE:
                        coordInput.value = "";
                        coordInput.placeholder = "Informasi lokasi tidak tersedia. Masukkan koordinat manual...";
                        break;
                    case error.TIMEOUT:
                        coordInput.value = "";
                        coordInput.placeholder = "Waktu permintaan habis. Masukkan koordinat manual...";
                        break;
                    case error.UNKNOWN_ERROR:
                        coordInput.value = "";
                        coordInput.placeholder = "Terjadi kesalahan. Masukkan koordinat manual...";
                        break;
                }
            }

            // Listen for manual coordinate changes
            document.getElementById('koordinat').addEventListener('input', function() {
                const val = this.value;
                if (val && targetCoordsStr) {
                    const parts = val.split(',');
                    if (parts.length === 2) {
                        const lat = parseFloat(parts[0].trim());
                        const lon = parseFloat(parts[1].trim());
                        if (!isNaN(lat) && !isNaN(lon)) {
                            const targetParts = targetCoordsStr.split(',');
                            if (targetParts.length === 2) {
                                const targetLat = parseFloat(targetParts[0].trim());
                                const targetLon = parseFloat(targetParts[1].trim());
                                
                                const distanceMeters = calculateDistance(lat, lon, targetLat, targetLon);
                                displayDistance(distanceMeters);
                            }
                        }
                    }
                }
            });

            // Haversine formula to calculate distance in meters
            function calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371000; // Radius of earth in meters
                const dLat = deg2rad(lat2 - lat1);
                const dLon = deg2rad(lon2 - lon1);
                const a = 
                    Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
                    Math.sin(dLon/2) * Math.sin(dLon/2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                const d = R * c; // Distance in meters
                return d;
            }

            function deg2rad(deg) {
                return deg * (Math.PI/180);
            }

            function displayDistance(meters) {
                const container = document.getElementById('distance-badge-container');
                const txt = document.getElementById('txt-distance');
                const badge = document.getElementById('badge-status-radius');

                container.classList.remove('hidden');

                if (meters < 1000) {
                    txt.innerText = `${Math.round(meters)} meter`;
                } else {
                    txt.innerText = `${(meters/1000).toFixed(2)} km`;
                }

                // Check radius (max 100 meters is standard for geofencing presence)
                if (meters <= 150) {
                    badge.innerText = "Dalam Radius PKL";
                    badge.className = "px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-900/30";
                } else {
                    badge.innerText = "Di Luar Radius PKL";
                    badge.className = "px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border border-rose-200/50 dark:border-rose-900/30";
                }
            }

            // Initialize Page Elements
            document.addEventListener('DOMContentLoaded', () => {
                // Initialize default camera mode
                initCamera();
                // Get geolocation on load
                getLocation();
            });
        </script>
    @endif
@endsection
