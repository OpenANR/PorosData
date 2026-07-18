@extends('PorosDataHome.SubMenuApplication.PortalPKL.layouts.app')

@section('title', 'Kelola Mitra DUDI')

@section('content')
    <!-- Page Heading -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Kelola Mitra DUDI</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar Dunia Usaha & Dunia Industri (DUDI) mitra Praktik Kerja Lapangan (PKL)</p>
        </div>
        <div>
            <button id="btn-buka-create" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-orange-600 hover:bg-orange-500 text-white font-semibold text-sm shadow-md shadow-orange-100 dark:shadow-none transition-colors flex items-center justify-center gap-2 cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i>
                Tambah Mitra
            </button>
        </div>
    </div>

    <!-- Actions Bar & Search -->
    <div class="mb-6">
        <form method="GET" action="{{ route('portalpkl.admin.mitra.index') }}" class="w-full sm:w-80 relative">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama mitra atau alamat..."
                class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </div>
            @if($search)
                <a href="{{ route('portalpkl.admin.mitra.index') }}" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/20 border border-rose-200/50 dark:border-rose-900/50 text-rose-800 dark:text-rose-400">
            <p class="font-bold text-sm mb-1">Gagal menyimpan data:</p>
            <ul class="list-disc pl-5 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Table of Mitra DUDI -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-16 text-center">No</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Perusahaan/Mitra</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Alamat Lokasi</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Koordinat Maps</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-36 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($mitras as $index => $mitra)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                            <td class="py-4 px-6 text-sm text-slate-500 text-center font-medium">
                                {{ $mitras->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-6 text-sm font-bold text-slate-900 dark:text-white">
                                {{ $mitra->nama_perusahaan }}
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-300">
                                {{ $mitra->alamat }}
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-300">
                                @if($mitra->koordinat)
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono text-xs text-slate-500 dark:text-slate-400 truncate max-w-[120px]">{{ $mitra->koordinat }}</span>
                                        @php
                                            $isUrl = filter_var($mitra->koordinat, FILTER_VALIDATE_URL);
                                            $mapsUrl = $isUrl ? $mitra->koordinat : 'https://www.google.com/maps/search/?api=1&query=' . urlencode($mitra->koordinat);
                                        @endphp
                                        <a href="{{ $mapsUrl }}" target="_blank" class="px-2 py-1 bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 hover:bg-orange-100 rounded-lg text-xs font-bold transition-all shrink-0">
                                            <i class="fa-solid fa-map-location-dot mr-1"></i> Buka Peta
                                        </a>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 italic">Belum diatur</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <!-- Edit Button -->
                                    <button onclick="bukaEditModal('{{ $mitra->id }}', '{{ addslashes($mitra->nama_perusahaan) }}', '{{ addslashes($mitra->alamat) }}', '{{ addslashes($mitra->koordinat) }}')"
                                        class="p-2 rounded-lg text-slate-500 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-950/30 transition-colors cursor-pointer" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </button>

                                    <!-- Delete Form -->
                                    <form action="{{ route('portalpkl.admin.mitra.destroy', $mitra->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus data mitra perusahaan ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors cursor-pointer" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center text-slate-400">
                                <i class="fa-solid fa-building-circle-exclamation text-3xl mb-3 text-slate-300 dark:text-slate-700"></i>
                                <p class="text-sm font-semibold">Belum ada data Mitra DUDI</p>
                                <p class="text-xs text-slate-400 mt-1">Silakan tambahkan data mitra melalui tombol di atas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($mitras->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">{{ $mitras->links() }}</div>
        @endif
    </div>

    <!-- ===================== MODALS ===================== -->
    @push('modals')
    <!-- ===================== MODAL TAMBAH ===================== -->
    <div id="modal-create" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-create" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
            <form action="{{ route('portalpkl.admin.mitra.store') }}" method="POST">
                @csrf
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Tambah Mitra DUDI Baru</h3>
                        <button type="button" id="btn-tutup-create" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 cursor-pointer">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Nama Perusahaan/Mitra</label>
                            <input type="text" name="nama_perusahaan" required placeholder="Contoh: PT. Sumber Makmur"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Alamat Lokasi</label>
                            <textarea name="alamat" required rows="3" placeholder="Masukkan alamat lengkap perusahaan..."
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Lokasi Koordinat Google Maps</label>
                            <input type="text" name="koordinat" placeholder="Contoh: -8.12345, 113.54321 atau link maps"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 block">Anda bisa memasukkan titik koordinat (Latitude, Longitude) atau menyalin link Google Maps.</span>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-end gap-3">
                    <button type="button" id="btn-batal-create" class="px-4 py-2 text-sm font-semibold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2 text-sm font-semibold rounded-xl bg-orange-600 hover:bg-orange-500 text-white shadow-md shadow-orange-100 dark:shadow-none transition-colors cursor-pointer">Simpan Mitra</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===================== MODAL EDIT ===================== -->
    <div id="modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-edit" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
            <form id="form-edit" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Ubah Data Mitra DUDI</h3>
                        <button type="button" id="btn-tutup-edit" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 cursor-pointer">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Nama Perusahaan/Mitra</label>
                            <input type="text" name="nama_perusahaan" id="edit-nama_perusahaan" required placeholder="Contoh: PT. Sumber Makmur"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Alamat Lokasi</label>
                            <textarea name="alamat" id="edit-alamat" required rows="3" placeholder="Masukkan alamat lengkap perusahaan..."
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Lokasi Koordinat Google Maps</label>
                            <input type="text" name="koordinat" id="edit-koordinat" placeholder="Contoh: -8.12345, 113.54321 atau link maps"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 block">Anda bisa memasukkan titik koordinat (Latitude, Longitude) atau menyalin link Google Maps.</span>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-end gap-3">
                    <button type="button" id="btn-batal-edit" class="px-4 py-2 text-sm font-semibold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2 text-sm font-semibold rounded-xl bg-orange-600 hover:bg-orange-500 text-white shadow-md shadow-orange-100 dark:shadow-none transition-colors cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript to Handle Modals -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modalCreate = document.getElementById('modal-create');
            const backdropCreate = document.getElementById('backdrop-create');
            const btnBukaCreate = document.getElementById('btn-buka-create');
            const btnTutupCreate = document.getElementById('btn-tutup-create');
            const btnBatalCreate = document.getElementById('btn-batal-create');
            const modalContentCreate = modalCreate.querySelector('.relative.z-10');

            const modalEdit = document.getElementById('modal-edit');
            const backdropEdit = document.getElementById('backdrop-edit');
            const btnTutupEdit = document.getElementById('btn-tutup-edit');
            const btnBatalEdit = document.getElementById('btn-batal-edit');
            const modalContentEdit = modalEdit.querySelector('.relative.z-10');

            // Open Create Modal
            const openCreateModal = () => {
                modalCreate.classList.remove('hidden');
                modalCreate.classList.add('flex');
                setTimeout(() => {
                    modalContentCreate.classList.remove('scale-95', 'opacity-0');
                    modalContentCreate.classList.add('scale-100', 'opacity-100');
                }, 10);
            };

            // Close Create Modal
            const closeCreateModal = () => {
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

            // Open Edit Modal via globally accessible function
            window.bukaEditModal = (id, nama, alamat, koordinat) => {
                const formEdit = document.getElementById('form-edit');
                const editNama = document.getElementById('edit-nama_perusahaan');
                const editAlamat = document.getElementById('edit-alamat');
                const editKoordinat = document.getElementById('edit-koordinat');

                formEdit.action = `/porosdata/portal-pkl/admin/mitra/${id}`;
                editNama.value = nama;
                editAlamat.value = alamat;
                editKoordinat.value = koordinat;

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
        });
    </script>
    @endpush
@endsection
