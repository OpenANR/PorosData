@extends('PorosDataHome.SubMenuApplication.PortalPKL.layouts.app')

@section('title', 'Riwayat Absensi PKL')

@section('content')
    <div class="space-y-6">
        <!-- Header Card -->
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-6 sm:p-8 transition-all duration-300">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-orange-600 to-amber-500 bg-clip-text text-transparent dark:from-orange-400 dark:to-amber-300">
                        Riwayat Absensi Anda
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">
                        Tinjau seluruh riwayat kehadiran dan jurnal harian Anda selama periode PKL.
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-orange-100 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200/50 dark:border-orange-900/30">
                        <i class="fa-solid fa-clock-rotate-left mr-1"></i> Riwayat Absensi
                    </span>
                </div>
            </div>
        </div>

        <!-- Session & Location details -->
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-md rounded-2xl p-5">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                <div>
                    <span class="text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider block">Nama Siswa</span>
                    <span class="text-slate-800 dark:text-slate-200 font-semibold text-sm">{{ $user->name }}</span>
                </div>
                <div>
                    <span class="text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider block">Tempat PKL</span>
                    <span class="text-slate-800 dark:text-slate-200 font-semibold text-sm">{{ $siswa->mitra->nama_perusahaan ?? 'Belum PKL' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider block">Target Koordinat PKL</span>
                    <span class="text-slate-800 dark:text-slate-200 font-mono text-sm">{{ $siswa->mitra->koordinat ?? 'Belum diatur' }}</span>
                </div>
            </div>
        </div>

        <!-- History List -->
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl overflow-hidden transition-all duration-300">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                    <thead class="text-xs text-slate-700 dark:text-slate-300 uppercase bg-slate-100/50 dark:bg-slate-900/50">
                        <tr>
                            <th class="px-6 py-4">Tanggal & Jam</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Jurnal / Keterangan</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                        @forelse($attendances as $att)
                            <tr class="hover:bg-slate-50/40 dark:hover:bg-slate-900/20 transition-all">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 dark:text-slate-200">{{ \Carbon\Carbon::parse($att->tanggal)->isoFormat('dddd, D MMMM YYYY') }}</span>
                                        <span class="text-xs text-slate-400 mt-0.5">{{ $att->created_at->format('H:i') }} WIB</span>
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
                                <td class="px-6 py-4 max-w-xs truncate">
                                    @if($att->status === 'Hadir')
                                        {{ $att->journal_kegiatan }}
                                    @else
                                        {{ $att->keterangan }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button type="button" onclick="showDetailModal({{ json_encode($att) }})" class="py-1 px-3 bg-orange-50 dark:bg-orange-950/30 hover:bg-orange-100 dark:hover:bg-orange-900/40 text-orange-600 dark:text-orange-400 rounded-xl text-xs font-bold transition-all border border-orange-200/30 dark:border-orange-900/20 active:scale-95 cursor-pointer">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400 dark:text-slate-500 font-medium">
                                    Belum ada data presensi siswa yang ditemukan.
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

    <!-- Detail Modal Dialog -->
    <div id="detail-modal" class="fixed inset-0 z-50 overflow-y-auto hidden flex items-center justify-center p-4 sm:p-6 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300">
        <div class="relative w-full max-w-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 shadow-2xl rounded-3xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="detail-modal-card">
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-orange-500"></i> Detail Keterangan Presensi
                </h3>
                <button type="button" onclick="closeDetailModal()" class="h-8 w-8 rounded-full bg-slate-50 dark:bg-slate-800/60 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 flex items-center justify-center transition-all cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="px-6 py-6 space-y-5 max-h-[70vh] overflow-y-auto text-slate-600 dark:text-slate-400">
                <!-- Info Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider block">Tanggal & Jam</span>
                        <span id="modal-time" class="text-slate-700 dark:text-slate-300 font-semibold text-sm">-</span>
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
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Koordinat Saya</span>
                            <div class="flex items-center gap-1.5">
                                <span id="modal-coords" class="text-slate-700 dark:text-slate-300 font-mono font-semibold text-xs">-</span>
                                <a id="modal-map-link" href="#" target="_blank" class="text-orange-600 dark:text-orange-400 text-xs hover:underline flex items-center gap-0.5">
                                    <i class="fa-solid fa-map-location-dot"></i> Peta
                                </a>
                            </div>
                        </div>
                        
                        <!-- Target Coordinates -->
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Target Lokasi PKL</span>
                            <span id="modal-target-coords" class="text-slate-700 dark:text-slate-300 font-mono text-xs">{{ $siswa->mitra->koordinat ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Journal -->
                    <div class="space-y-1.5">
                        <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Journal Kegiatan Harian</span>
                        <div id="modal-journal" class="p-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 text-sm rounded-2xl whitespace-pre-line leading-relaxed">
                            -
                        </div>
                    </div>

                    <!-- Snapshot Photo -->
                    <div class="space-y-1.5">
                        <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Bukti Foto Presensi</span>
                        <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 max-w-[200px] shadow bg-slate-100 dark:bg-slate-900">
                            <img id="modal-photo" src="" alt="Bukti Foto" class="w-full h-auto object-cover max-h-44">
                        </div>
                    </div>
                </div>

                <!-- SAKIT / IZIN details (Keterangan) -->
                <div id="modal-ket-section" class="space-y-4 pt-2 border-t border-slate-100 dark:border-slate-800/80 hidden">
                    <div class="space-y-1.5">
                        <span id="modal-ket-title" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Keterangan / Alasan</span>
                        <div id="modal-keterangan" class="p-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 text-sm rounded-2xl whitespace-pre-line leading-relaxed">
                            -
                        </div>
                    </div>

                    <!-- Document Attachment -->
                    <div id="modal-attachment-container" class="space-y-1.5 hidden">
                        <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Lampiran Bukti</span>
                        
                        <!-- Image Attachment Wrapper -->
                        <div id="modal-attachment-image-wrapper" class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 max-w-[200px] shadow bg-slate-100 dark:bg-slate-900 relative">
                            <img id="modal-attachment" src="" alt="Lampiran" class="w-full h-auto object-cover max-h-44">
                            <a id="modal-attachment-download" href="#" download class="absolute bottom-2 right-2 h-7 w-7 bg-orange-600 hover:bg-orange-500 text-white rounded-full flex items-center justify-center shadow active:scale-90 transition-all cursor-pointer">
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

    <!-- Modal Scripts -->
    <script>
        const modal = document.getElementById('detail-modal');
        const modalCard = document.getElementById('detail-modal-card');

        function showDetailModal(attendance) {
            // Populate DateTime & Status
            const dateObj = new Date(attendance.created_at);
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            document.getElementById('modal-time').innerText = dateObj.toLocaleDateString('id-ID', options) + ' WIB';

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
                document.getElementById('modal-map-link').href = `https://maps.google.com/?q=${attendance.koordinat}`;
                document.getElementById('modal-journal').innerText = attendance.journal_kegiatan || 'Tidak ada isi jurnal.';
                
                const photoEl = document.getElementById('modal-photo');
                if (attendance.foto) {
                    photoEl.src = `/storage/${attendance.foto}`;
                    photoEl.parentElement.classList.remove('hidden');
                } else {
                    photoEl.src = "";
                    photoEl.parentElement.classList.add('hidden');
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
    </script>
@endsection
