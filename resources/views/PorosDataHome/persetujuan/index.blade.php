@extends('PorosDataHome.layouts.app')

@section('title', 'Status Persetujuan')

@section('content')
    <!-- Information Panel -->
    <div class="mb-8 p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 shadow-sm">
        <div class="flex items-start gap-4">
            <div class="h-10 w-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 111.063.852l-.708 2.836a.75.75 0 001.063.852l.041-.028M12 8.25h.007v.008H12V8.25z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Modul Otorisasi & Status Persetujuan Admin</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-1 leading-relaxed">
                    Sebagai Admin Utama atau Kepala Sekolah, Anda memegang kendali otorisasi atas setiap perubahan kritis data kesiswaan yang diajukan oleh Wali Kelas. Anda dapat menyetujui (Terima) pengajuan untuk langsung memperbarui database, atau menolak (Tolak) pengajuan untuk membatalkan perubahan tersebut.
                </p>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-950 dark:text-white">Status Persetujuan Pengajuan</h1>
        <p class="text-slate-400 dark:text-slate-500 text-xs font-semibold mt-0.5">Kelola dan validasi usulan perubahan data siswa</p>
    </div>

    <!-- Search and Filter Bar -->
    <form method="GET" action="{{ route('persetujuan.index') }}" class="p-4 mb-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 shadow-sm flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="relative w-full md:max-w-xs">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4.5 h-4.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.637 10.637Z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari NISN, siswa, wali kelas..." class="block w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800/60 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500/20 text-slate-800 dark:text-slate-100">
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <select name="status" onchange="this.form.submit()" class="w-full md:w-48 px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800/60 rounded-xl text-xs text-slate-600 dark:text-slate-400 bg-white">
                <option value="">Semua Status</option>
                <option value="proses" {{ $statusFilter === 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="disetujui" {{ $statusFilter === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ $statusFilter === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
            @if($search || $statusFilter)
                <a href="{{ route('persetujuan.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 whitespace-nowrap">Hapus Filter</a>
            @endif
        </div>
    </form>

    <!-- Table of Requests -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Tanggal dan jam</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Alasan sedang dilakukan</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 text-center">Kelas</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Wali Kelas</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 text-center">Status</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($persetujuans as $p)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                            <!-- Tanggal dan jam -->
                            <td class="py-4 px-6 text-sm font-mono text-slate-600 dark:text-slate-300 font-medium whitespace-nowrap">
                                {{ $p->created_at->format('d-m-Y H:i') }}
                            </td>
                            <!-- Alasan sedang dilakukan -->
                            <td class="py-4 px-6">
                                <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ $p->alasan }}</div>
                                @if(isset($p->data_baru['alasan_dropout']))
                                    <div class="text-xs text-slate-400 dark:text-slate-500 font-medium mt-0.5">
                                        Ket: {{ $p->data_baru['alasan_dropout'] }}
                                    </div>
                                @endif
                            </td>
                            <!-- Kelas -->
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                    {{ $p->nama_kelas }}
                                </span>
                            </td>
                            <!-- Wali Kelas -->
                            <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-300 font-medium">
                                {{ $p->user->name ?? 'Staf Sekolah' }}
                            </td>
                            <!-- Status -->
                            <td class="py-4 px-6 text-center">
                                @if($p->status === 'proses')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-900/30">
                                        Proses
                                    </span>
                                @elseif($p->status === 'disetujui')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-900/30">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <!-- Aksi -->
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" 
                                        onclick="bukaDetailModal('{{ $p->id }}', '{{ $p->alasan }}', '{{ addslashes($p->siswa->user->name ?? 'Siswa Terhapus') }}', '{{ $p->siswa->nisn ?? '-' }}', '{{ json_encode($p->data_lama) }}', '{{ json_encode($p->data_baru) }}', '{{ $p->status }}')"
                                        class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-semibold shadow-sm transition-all hover:scale-[1.02] active:scale-[0.98]">
                                        Lihat
                                    </button>
                                    @if($p->status === 'proses')
                                        <form action="{{ route('persetujuan.terima', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pengajuan perubahan ini?')" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-xs font-semibold shadow-sm transition-all hover:scale-[1.02] active:scale-[0.98]">
                                                Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('persetujuan.tolak', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak pengajuan perubahan ini?')" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-500 text-white rounded-lg text-xs font-semibold shadow-sm transition-all hover:scale-[1.02] active:scale-[0.98]">
                                                Tolak
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto mb-3 text-slate-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                </svg>
                                <p class="text-sm font-semibold">Belum ada pengajuan persetujuan</p>
                                <p class="text-xs mt-1">Pengajuan perubahan atau dropout dari Wali Kelas akan muncul di sini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Area -->
        @if($persetujuans->hasPages())
            <div class="px-6 py-4.5 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/60">
                {{ $persetujuans->links() }}
            </div>
        @else
            <div class="px-6 py-4.5 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between">
                <span class="text-[11px] font-semibold text-slate-400">Menampilkan {{ $persetujuans->count() }} dari {{ $persetujuans->count() }} pengajuan</span>
            </div>
        @endif
    </div>

@push('modals')
    <!-- ===================== DETAIL MODAL ===================== -->
    <div id="modal-detail" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-detail" class="absolute inset-0 custom-backdrop"></div>
        <div class="relative z-10 w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800/80 max-h-[85vh] flex flex-col">
            <!-- Modal Header -->
            <div class="p-6 border-b border-slate-100 dark:border-slate-800/60 flex items-center justify-between shrink-0">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white" id="modal-detail-title">Detail Perubahan Data</h3>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1" id="modal-detail-subtitle">Siswa: -</p>
                </div>
                <button type="button" id="btn-tutup-detail" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Content (Scrollable) -->
            <div class="p-6 overflow-y-auto flex-1">
                <!-- Dropout Notice -->
                <div id="dropout-notice" class="hidden mb-4 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/20 border border-rose-200/50 dark:border-rose-900/50 text-rose-800 dark:text-rose-400 text-xs flex gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 shrink-0 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                    </svg>
                    <div>
                        <span class="font-bold block mb-1">Pengajuan Penonaktifan Siswa (Drop Out):</span>
                        Siswa yang bersangkutan diajukan untuk dikeluarkan dari sekolah (status diubah menjadi <strong class="uppercase text-rose-600 dark:text-rose-400">drop_out</strong>).
                    </div>
                </div>

                <!-- Comparisons Table -->
                <table class="w-full text-left border-collapse text-xs shadow-sm rounded-lg overflow-hidden" id="comparisons-table">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800/60 text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">
                            <th class="px-4 py-2.5 w-1/3">Kolom / Informasi</th>
                            <th class="px-4 py-2.5 w-1/3 text-rose-600 dark:text-rose-400">Data Sebelumnya (Lama)</th>
                            <th class="px-4 py-2.5 w-1/3 text-emerald-600 dark:text-emerald-400">Data Pengajuan Baru</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 font-semibold text-slate-700 dark:text-slate-300" id="comparison-rows">
                        <!-- Dynamic Rows -->
                    </tbody>
                </table>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 border-t border-slate-100 dark:border-slate-800/60 flex justify-end gap-3 shrink-0">
                <button type="button" id="btn-tutup-detail-bawah" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700/80 text-slate-600 dark:text-slate-300 rounded-xl text-xs font-semibold shadow-sm transition-all active:scale-[0.98]">
                    Tutup
                </button>

                <!-- Actions inside modal footer -->
                <div id="modal-action-forms" class="hidden gap-2">
                    <form id="form-terima-modal" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pengajuan perubahan ini?')" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold shadow-sm transition-all hover:scale-[1.02] active:scale-[0.98]">
                            Terima Pengajuan
                        </button>
                    </form>
                    <form id="form-tolak-modal" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak pengajuan perubahan ini?')" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2.5 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-semibold shadow-sm transition-all hover:scale-[1.02] active:scale-[0.98]">
                            Tolak Pengajuan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush
@endsection

@section('scripts')
    <script>
        const allClassesMap = @json($allClasses->map(fn($c) => $c->nama_kelas));

        const modalDetail = document.getElementById('modal-detail');
        const backdropDetail = document.getElementById('backdrop-detail');
        const btnTutupDetail = document.getElementById('btn-tutup-detail');
        const btnTutupDetailBawah = document.getElementById('btn-tutup-detail-bawah');

        const titleText = document.getElementById('modal-detail-title');
        const subtitleText = document.getElementById('modal-detail-subtitle');
        const dropoutNotice = document.getElementById('dropout-notice');
        const comparisonsTable = document.getElementById('comparisons-table');
        const comparisonRows = document.getElementById('comparison-rows');

        const modalActionForms = document.getElementById('modal-action-forms');
        const formTerimaModal = document.getElementById('form-terima-modal');
        const formTolakModal = document.getElementById('form-tolak-modal');

        function bukaDetailModal(id, alasan, siswaNama, siswaNisn, dataLamaStr, dataBaruStr, status) {
            const dataLama = JSON.parse(dataLamaStr);
            const dataBaru = JSON.parse(dataBaruStr);

            titleText.textContent = alasan;
            subtitleText.textContent = `Siswa: ${siswaNama} (NISN: ${siswaNisn})`;

            // Configure Forms Action
            formTerimaModal.action = `/porosdata/persetujuan/${id}/terima`;
            formTolakModal.action = `/porosdata/persetujuan/${id}/tolak`;

            // Display action buttons if status is 'proses'
            if (status === 'proses') {
                modalActionForms.classList.remove('hidden');
                modalActionForms.classList.add('flex');
            } else {
                modalActionForms.classList.remove('flex');
                modalActionForms.classList.add('hidden');
            }

            // Clear table rows
            comparisonRows.innerHTML = '';

            if (alasan.toLowerCase().includes('dropout')) {
                dropoutNotice.classList.remove('hidden');
                comparisonsTable.classList.add('hidden');
                
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors';
                tr.innerHTML = `
                    <td class="px-4 py-3 font-medium text-slate-500">Status Akademik</td>
                    <td class="px-4 py-3 font-mono text-rose-600 dark:text-rose-400 capitalize">${dataLama.status || 'aktif'}</td>
                    <td class="px-4 py-3 font-mono text-emerald-600 dark:text-emerald-400 capitalize font-bold">Drop Out</td>
                `;
                comparisonRows.appendChild(tr);

                if (dataBaru.alasan_dropout) {
                    const trAlasan = document.createElement('tr');
                    trAlasan.className = 'hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors';
                    trAlasan.innerHTML = `
                        <td class="px-4 py-3 font-medium text-slate-500">Alasan Dropout</td>
                        <td class="px-4 py-3 text-slate-400 dark:text-slate-600">-</td>
                        <td class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">${dataBaru.alasan_dropout}</td>
                    `;
                    comparisonRows.appendChild(trAlasan);
                }

                comparisonsTable.classList.remove('hidden');
            } else {
                dropoutNotice.classList.add('hidden');
                comparisonsTable.classList.remove('hidden');

                // Build comparison rows
                const fields = [
                    { key: 'name', label: 'Nama Lengkap' },
                    { key: 'nisn', label: 'NISN' },
                    { key: 'username', label: 'Username' },
                    { key: 'kelas_id', label: 'Kelas', format: (val) => allClassesMap[val] || `Kelas ID ${val}` },
                    { key: 'status', label: 'Status Akademik', format: (val) => val === 'aktif' ? 'Aktif' : (val === 'lulus' ? 'Lulus' : 'Drop Out') },
                    { key: 'angkatan', label: 'Angkatan' },
                    { key: 'jurusan', label: 'Jurusan' },
                    { key: 'nama_panggilan', label: 'Nama Panggilan' },
                    { key: 'jenis_kelamin', label: 'Jenis Kelamin' },
                    { key: 'tempat_lahir', label: 'Tempat Lahir' },
                    { key: 'tanggal_lahir', label: 'Tanggal Lahir' },
                    { key: 'agama', label: 'Agama' },
                    { key: 'kewarganegaraan', label: 'Kewarganegaraan' },
                    { key: 'alamat_lengkap', label: 'Alamat Lengkap' },
                    { key: 'nomor_telepon', label: 'Nomor Telepon' },
                    { key: 'tinggi_badan', label: 'Tinggi Badan (cm)' },
                    { key: 'berat_badan', label: 'Berat Badan (kg)' },
                    { key: 'anak_ke', label: 'Anak Ke-' },
                    { key: 'jumlah_saudara_kandung', label: 'Jumlah Saudara Kandung' },
                    { key: 'status_yatim_piatu', label: 'Status Yatim/Piatu' },
                    { key: 'tinggal_dengan', label: 'Tinggal Dengan' },
                    { key: 'nama_ayah', label: 'Nama Lengkap Ayah' },
                    { key: 'pekerjaan_ayah', label: 'Pekerjaan Ayah' },
                    { key: 'nomor_hp_ayah', label: 'Nomor HP Ayah' },
                    { key: 'nama_ibu', label: 'Nama Lengkap Ibu' },
                    { key: 'pekerjaan_ibu', label: 'Pekerjaan Ibu' },
                    { key: 'nomor_hp_ibu', label: 'Nomor HP Ibu' }
                ];

                fields.forEach(field => {
                    const oldVal = dataLama[field.key];
                    const newVal = dataBaru[field.key];

                    const oldFormatted = field.format ? field.format(oldVal) : oldVal;
                    const newFormatted = field.format ? field.format(newVal) : newVal;

                    const hasDiff = oldVal !== newVal;
                    
                    const tr = document.createElement('tr');
                    tr.className = `hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors ${hasDiff ? 'bg-indigo-50/20 dark:bg-indigo-950/10' : ''}`;
                    tr.innerHTML = `
                        <td class="px-4 py-3 font-medium text-slate-500 flex items-center gap-1.5">
                            ${field.label}
                            ${hasDiff ? '<span class="h-1.5 w-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>' : ''}
                        </td>
                        <td class="px-4 py-3 font-mono ${hasDiff ? 'text-rose-600 dark:text-rose-400 line-through' : 'text-slate-400 dark:text-slate-600'}">${oldFormatted || '-'}</td>
                        <td class="px-4 py-3 font-mono ${hasDiff ? 'text-emerald-600 dark:text-emerald-400 font-bold' : 'text-slate-700 dark:text-slate-300'}">${newFormatted || '-'}</td>
                    `;
                    comparisonRows.appendChild(tr);
                });

                // If status was changed to drop_out, show the reason
                if (dataBaru.status === 'drop_out' && dataBaru.alasan_dropout) {
                    const trAlasan = document.createElement('tr');
                    trAlasan.className = 'hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors bg-indigo-50/20 dark:bg-indigo-950/10';
                    trAlasan.innerHTML = `
                        <td class="px-4 py-3 font-medium text-slate-500 flex items-center gap-1.5">
                            Alasan Dropout
                            <span class="h-1.5 w-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                        </td>
                        <td class="px-4 py-3 text-slate-400 dark:text-slate-600">-</td>
                        <td class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">${dataBaru.alasan_dropout}</td>
                    `;
                    comparisonRows.appendChild(trAlasan);
                }

                // Password handling
                if (dataBaru.password) {
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors bg-indigo-50/20 dark:bg-indigo-950/10';
                    tr.innerHTML = `
                        <td class="px-4 py-3 font-medium text-slate-500 flex items-center gap-1.5">
                            Kata Sandi Baru
                            <span class="h-1.5 w-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                        </td>
                        <td class="px-4 py-3 font-mono text-slate-400 dark:text-slate-600">[Didekripsi] ********</td>
                        <td class="px-4 py-3 font-mono text-emerald-600 dark:text-emerald-400 font-bold">${dataBaru.password}</td>
                    `;
                    comparisonRows.appendChild(tr);
                }
            }

            // Open Modal
            modalDetail.classList.remove('hidden');
            modalDetail.classList.add('flex');
        }

        function tutupDetailModal() {
            if (modalDetail.classList.contains('hidden')) return;
            modalDetail.classList.add('modal-closing');
            setTimeout(() => {
                modalDetail.classList.remove('modal-closing');
                modalDetail.classList.add('hidden');
                modalDetail.classList.remove('flex');
            }, 180);
        }

        if (btnTutupDetail) btnTutupDetail.addEventListener('click', tutupDetailModal);
        if (btnTutupDetailBawah) btnTutupDetailBawah.addEventListener('click', tutupDetailModal);
        if (backdropDetail) backdropDetail.addEventListener('click', tutupDetailModal);
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                tutupDetailModal();
            }
        });
    </script>
@endsection
