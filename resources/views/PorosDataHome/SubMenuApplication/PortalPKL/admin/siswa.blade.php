@extends('PorosDataHome.SubMenuApplication.PortalPKL.layouts.app')

@section('title', 'Kelola Siswa PKL')

@section('content')
    <!-- Page Heading -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Kelola Siswa PKL</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar siswa peserta PKL, penempatan industri, dan pembimbing pendamping</p>
    </div>

    <!-- Actions Bar & Filters -->
    <div class="mb-6 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-4">
        <form method="GET" action="{{ route('portalpkl.admin.siswa.index') }}" class="w-full flex flex-col sm:flex-row items-center gap-3">
            <!-- Search -->
            <div class="w-full sm:w-72 relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, username, atau NISN..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <!-- Hidden button for Enter key submit -->
                <button type="submit" class="hidden"></button>
            </div>

            <!-- Filter Kelas -->
            <div class="w-full sm:w-44 relative">
                <select name="kelas" onchange="this.form.submit()"
                    class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all appearance-none cursor-pointer font-medium">
                    <option value="">Semua Kelas</option>
                    @foreach($allKelas as $kelas)
                        <option value="{{ $kelas->id }}" {{ $kelasFilter == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </div>
            </div>

            <!-- Filter Tempat PKL -->
            <div class="w-full sm:w-44 relative">
                <select name="mitra" onchange="this.form.submit()"
                    class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all appearance-none cursor-pointer font-medium">
                    <option value="">Semua Tempat PKL</option>
                    <option value="belum_ditentukan" {{ $mitraFilter === 'belum_ditentukan' ? 'selected' : '' }}>Belum ditentukan</option>
                    @foreach($allMitras as $mitra)
                        <option value="{{ $mitra->id }}" {{ $mitraFilter == $mitra->id ? 'selected' : '' }}>
                            {{ Str::limit($mitra->nama_perusahaan, 25) }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </div>
            </div>

            @if($search || $kelasFilter || $mitraFilter)
                <a href="{{ route('portalpkl.admin.siswa.index') }}" class="text-xs font-semibold text-orange-600 hover:text-orange-700 dark:text-orange-400 whitespace-nowrap ml-1">Hapus Filter</a>
            @endif
        </form>

        <button id="btn-buka-create" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-orange-600 hover:bg-orange-500 text-white font-semibold text-sm shadow-md shadow-orange-100 dark:shadow-none transition-colors flex items-center justify-center gap-2 cursor-pointer whitespace-nowrap shrink-0">
            <i class="fa-solid fa-plus text-xs"></i>
            Tambah Siswa PKL
        </button>
    </div>

    <!-- Table of Siswa PKL -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-16 text-center">No</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Siswa</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Username</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Kelas</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Tempat PKL</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Pembimbing</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-24 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($siswas as $index => $siswa)
                        @php
                            $pembimbing = $siswa->mitra?->pembimbings?->first();
                        @endphp
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                            <td class="py-4 px-6 text-sm text-slate-500 text-center font-medium">
                                {{ $siswas->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-6 text-sm">
                                <div class="font-bold text-slate-900 dark:text-white">{{ $siswa->user->name }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">NISN: {{ $siswa->nisn }}</div>
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-300">
                                {{ $siswa->user->username }}
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-300 font-semibold">
                                {{ $siswa->kelas->nama_kelas ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-sm">
                                @if($siswa->mitra)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200/30 dark:border-orange-900/30">
                                        <i class="fa-solid fa-building text-[10px]"></i>
                                        {{ $siswa->mitra->nama_perusahaan }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-medium bg-slate-50 dark:bg-slate-800/40 text-slate-400 dark:text-slate-500 border border-slate-200/30 dark:border-slate-800/30">
                                        <i class="fa-solid fa-circle-question text-[10px]"></i>
                                        Belum ditentukan
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-sm">
                                @if($pembimbing)
                                    <div>
                                        <span class="font-bold text-slate-800 dark:text-slate-200 block">{{ $pembimbing->name }}</span>
                                        <span class="text-xs text-slate-400 font-mono mt-0.5 block">ID: {{ $pembimbing->id_pembimbing }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 italic">Belum ditentukan</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <!-- Edit Button (Ubah Penempatan) -->
                                    <button onclick="bukaEditModal('{{ $siswa->id }}', '{{ addslashes($siswa->user->name) }}', '{{ $siswa->mitra_dudi_id }}')"
                                        class="p-2 rounded-lg text-slate-500 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-950/30 transition-colors cursor-pointer" title="Ubah Penempatan Mitra">
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </button>

                                    <!-- Delete Button (Keluarkan dari Peserta PKL) -->
                                    <form action="{{ route('portalpkl.admin.siswa.destroy', $siswa->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus/Keluarkan siswa ini dari daftar peserta PKL?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors cursor-pointer" title="Keluarkan dari PKL">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center text-slate-400">
                                <i class="fa-solid fa-user-graduate text-3xl mb-3 text-slate-300 dark:text-slate-700"></i>
                                <p class="text-sm font-semibold">Belum ada data Siswa PKL</p>
                                <p class="text-xs text-slate-400 mt-1">Gunakan import/seeder untuk memasukkan data siswa kelas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($siswas->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">{{ $siswas->links() }}</div>
        @endif
    </div>

    <!-- ===================== MODALS ===================== -->
    @push('modals')
    <!-- ===================== MODAL TAMBAH SISWA PKL ===================== -->
    <div id="modal-create" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-create" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-lg bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
            <form action="{{ route('portalpkl.admin.siswa.store') }}" method="POST">
                @csrf
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Tambah Siswa PKL</h3>
                        <button type="button" id="btn-tutup-create" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 cursor-pointer">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Pilih Siswa Kelas XII</label>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 mb-2">Ceklis siswa kelas XII yang akan ditambahkan ke daftar peserta PKL.</p>
                            
                            <!-- Search & Filter for Siswa -->
                            <div class="flex gap-2 mb-3">
                                <!-- Search -->
                                <div class="relative flex-1 min-w-0">
                                    <input type="text" id="search-siswa-create" placeholder="Cari nama atau kelas..."
                                        class="w-full pl-9 pr-4 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                    </div>
                                </div>
                                <!-- Filter Kelas -->
                                <div class="relative w-32 sm:w-40 shrink-0">
                                    <select id="filter-kelas-create"
                                        class="w-full pl-3 pr-8 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all appearance-none cursor-pointer">
                                        <option value="">Semua Kelas</option>
                                        @foreach($allKelas as $kelas)
                                            <option value="{{ strtolower($kelas->nama_kelas) }}">{{ $kelas->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                    </div>
                                </div>
                                <!-- Reset Filter -->
                                <button type="button" id="btn-reset-filter-create" class="flex items-center justify-center px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-500 dark:text-slate-400 transition-colors cursor-pointer shrink-0" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-right text-xs"></i>
                                </button>
                            </div>
                            
                            <!-- Select All / Deselect All -->
                            <div class="flex items-center gap-4 mb-2 px-1">
                                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-orange-600 dark:hover:text-orange-400 transition-colors">
                                    <input type="checkbox" id="check-all-siswa" class="rounded text-orange-600 focus:ring-orange-500 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 cursor-pointer">
                                    <span>Pilih Semua yang Ditampilkan</span>
                                </label>
                            </div>

                            <div class="border border-slate-200 dark:border-slate-700/80 rounded-xl p-3 overflow-y-auto bg-slate-50 dark:bg-slate-800/50 space-y-2" style="max-height: 250px;" id="siswa-list-container">
                                @forelse($eligibleSiswas as $eligible)
                                    <label class="siswa-checkbox-item flex items-start gap-2.5 py-1.5 px-2 rounded hover:bg-slate-100 dark:hover:bg-slate-800/80 cursor-pointer transition-colors">
                                        <input type="checkbox" name="siswa_ids[]" value="{{ $eligible->id }}"
                                            class="siswa-checkbox mt-1 rounded text-orange-600 focus:ring-orange-500 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 cursor-pointer">
                                        <div class="text-sm w-full">
                                            <span class="font-bold text-slate-800 dark:text-slate-200 block siswa-name">{{ $eligible->user->name }}</span>
                                            <div class="flex justify-between items-center w-full mt-0.5">
                                                <span class="text-slate-400 dark:text-slate-500 text-xs">NISN: {{ $eligible->nisn }}</span>
                                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 siswa-kelas">{{ $eligible->kelas->nama_kelas ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-xs text-slate-400 italic text-center py-4">Tidak ada siswa kelas XII yang tersedia atau semua sudah ditambahkan ke PKL.</p>
                                @endforelse
                                <p id="siswa-empty-search" class="text-xs text-slate-400 italic text-center py-4 hidden">Siswa tidak ditemukan.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-end gap-3">
                    <button type="button" id="btn-batal-create" class="px-4 py-2 text-sm font-semibold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2 text-sm font-semibold rounded-xl bg-orange-600 hover:bg-orange-500 text-white shadow-md shadow-orange-100 dark:shadow-none transition-colors cursor-pointer">Simpan Siswa</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===================== MODAL EDIT PENEMPATAN ===================== -->
    <div id="modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-edit" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
            <form id="form-edit" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Atur Penempatan PKL</h3>
                        <button type="button" id="btn-tutup-edit" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 cursor-pointer">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nama Siswa</label>
                            <input type="text" id="edit-nama-siswa" disabled 
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-500 dark:text-slate-400 text-sm font-semibold cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Pilih Mitra DU/DI (Industri)</label>
                            <select name="mitra_dudi_id" id="edit-mitra_dudi_id"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all cursor-pointer">
                                <option value="">-- Belum ditentukan / Batalkan Penempatan --</option>
                                @foreach($allMitras as $mitra)
                                    @php
                                        $mitraPembimbing = $mitra->pembimbings->first();
                                    @endphp
                                    <option value="{{ $mitra->id }}">
                                        {{ $mitra->nama_perusahaan }} 
                                        @if($mitraPembimbing)
                                            (Pembimbing: {{ $mitraPembimbing->name }} [{{ $mitraPembimbing->id_pembimbing }}])
                                        @else
                                            (Belum memiliki pembimbing)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-1.5 block">
                                Pembimbing akan disesuaikan secara otomatis berdasarkan pendamping Mitra DU/DI yang terpilih.
                            </span>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-end gap-3">
                    <button type="button" id="btn-batal-edit" class="px-4 py-2 text-sm font-semibold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2 text-sm font-semibold rounded-xl bg-orange-600 hover:bg-orange-500 text-white shadow-md shadow-orange-100 dark:shadow-none transition-colors cursor-pointer">Simpan Penempatan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript to Handle Modals -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modalEdit = document.getElementById('modal-edit');
            const backdropEdit = document.getElementById('backdrop-edit');
            const btnTutupEdit = document.getElementById('btn-tutup-edit');
            const btnBatalEdit = document.getElementById('btn-batal-edit');
            const modalContentEdit = modalEdit.querySelector('.relative.z-10');

            // Open Edit Modal via globally accessible function
            window.bukaEditModal = (id, namaSiswa, mitraDudiId) => {
                const formEdit = document.getElementById('form-edit');
                const editNama = document.getElementById('edit-nama-siswa');
                const editMitraSelect = document.getElementById('edit-mitra_dudi_id');

                formEdit.action = `/porosdata/portal-pkl/admin/siswa-pkl/${id}`;
                editNama.value = namaSiswa;
                editMitraSelect.value = mitraDudiId || '';

                modalEdit.classList.remove('hidden');
                modalEdit.classList.add('flex');
                setTimeout(() => {
                    modalContentEdit.classList.remove('scale-95', 'opacity-0');
                    modalContentEdit.classList.add('scale-100', 'opacity-100');
                }, 10);
            };

            // Close Edit Modal
            const closeEditModal = () => {
                modalEdit.classList.add('modal-closing');
                modalContentEdit.classList.remove('scale-100', 'opacity-100');
                modalContentEdit.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modalEdit.classList.remove('modal-closing');
                    modalEdit.classList.remove('flex');
                    modalEdit.classList.add('hidden');
                }, 300);
            };

            if (btnTutupEdit) btnTutupEdit.addEventListener('click', closeEditModal);
            if (btnBatalEdit) btnBatalEdit.addEventListener('click', closeEditModal);
            if (backdropEdit) backdropEdit.addEventListener('click', closeEditModal);
            
            // ===================== CREATE MODAL LOGIC =====================
            const modalCreate = document.getElementById('modal-create');
            const btnBukaCreate = document.getElementById('btn-buka-create');
            const backdropCreate = document.getElementById('backdrop-create');
            const btnTutupCreate = document.getElementById('btn-tutup-create');
            const btnBatalCreate = document.getElementById('btn-batal-create');
            const modalContentCreate = modalCreate ? modalCreate.querySelector('.relative.z-10') : null;

            const openCreateModal = () => {
                if (!modalCreate) return;
                modalCreate.classList.remove('hidden');
                modalCreate.classList.add('flex');
                setTimeout(() => {
                    modalContentCreate.classList.remove('scale-95', 'opacity-0');
                    modalContentCreate.classList.add('scale-100', 'opacity-100');
                }, 10);
            };

            const closeCreateModal = () => {
                if (!modalCreate) return;
                modalCreate.classList.add('modal-closing');
                modalContentCreate.classList.remove('scale-100', 'opacity-100');
                modalContentCreate.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modalCreate.classList.remove('modal-closing');
                    modalCreate.classList.remove('flex');
                    modalCreate.classList.add('hidden');
                }, 300);
            };

            if (btnBukaCreate) btnBukaCreate.addEventListener('click', openCreateModal);
            if (btnTutupCreate) btnTutupCreate.addEventListener('click', closeCreateModal);
            if (btnBatalCreate) btnBatalCreate.addEventListener('click', closeCreateModal);
            if (backdropCreate) backdropCreate.addEventListener('click', closeCreateModal);

            // ===================== SEARCH & SELECT ALL LOGIC FOR SISWA =====================
            const searchInput = document.getElementById('search-siswa-create');
            const classFilter = document.getElementById('filter-kelas-create');
            const resetFilterBtn = document.getElementById('btn-reset-filter-create');
            const siswaItems = document.querySelectorAll('.siswa-checkbox-item');
            const emptySearchMsg = document.getElementById('siswa-empty-search');
            const checkAllBtn = document.getElementById('check-all-siswa');

            const filterSiswa = () => {
                const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
                const selectedClass = classFilter ? classFilter.value.toLowerCase() : '';
                let hasVisibleItems = false;

                siswaItems.forEach(item => {
                    const name = item.querySelector('.siswa-name').textContent.toLowerCase();
                    const kelas = item.querySelector('.siswa-kelas').textContent.toLowerCase();
                    
                    const matchSearch = name.includes(searchTerm) || kelas.includes(searchTerm);
                    const matchClass = selectedClass === '' || kelas === selectedClass;
                    
                    if (matchSearch && matchClass) {
                        item.style.display = 'flex';
                        hasVisibleItems = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if (emptySearchMsg) {
                    if (hasVisibleItems) {
                        emptySearchMsg.classList.add('hidden');
                    } else {
                        emptySearchMsg.classList.remove('hidden');
                    }
                }
                
                updateCheckAllState();
            };

            if (searchInput) {
                searchInput.addEventListener('input', filterSiswa);
            }
            if (classFilter) {
                classFilter.addEventListener('change', filterSiswa);
            }
            if (resetFilterBtn) {
                resetFilterBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (classFilter) classFilter.value = '';
                    if (searchInput) searchInput.value = '';
                    filterSiswa();
                });
            }

            if (checkAllBtn) {
                checkAllBtn.addEventListener('change', function(e) {
                    const isChecked = e.target.checked;
                    siswaItems.forEach(item => {
                        // Only check/uncheck visible items
                        if (item.style.display !== 'none') {
                            const checkbox = item.querySelector('.siswa-checkbox');
                            if (checkbox) checkbox.checked = isChecked;
                        }
                    });
                });
            }

            // Update Check All button state when individual checkboxes change
            const updateCheckAllState = () => {
                if (!checkAllBtn) return;
                
                let allVisibleChecked = true;
                let anyVisible = false;
                
                siswaItems.forEach(item => {
                    if (item.style.display !== 'none') {
                        anyVisible = true;
                        const checkbox = item.querySelector('.siswa-checkbox');
                        if (checkbox && !checkbox.checked) {
                            allVisibleChecked = false;
                        }
                    }
                });
                
                if (anyVisible) {
                    checkAllBtn.checked = allVisibleChecked;
                } else {
                    checkAllBtn.checked = false;
                }
            };

            const checkboxes = document.querySelectorAll('.siswa-checkbox');
            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateCheckAllState);
            });
        });
    </script>
    @endpush
@endsection
