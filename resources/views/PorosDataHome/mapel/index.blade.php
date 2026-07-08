@extends('PorosDataHome.layouts.app')

@section('title', 'Kelola Mapel')

@section('content')
    <!-- Page Heading -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Kelola Mata Pelajaran & Kategori</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $sd ? $sd->nama_sekolah : 'Sekolah SD' }} — Manajemen mata pelajaran dan kategorinya</p>
    </div>

    <!-- Success & Error Alerts -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200/50 dark:border-emerald-900/50 text-emerald-800 dark:text-emerald-400 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/20 border border-rose-200/50 dark:border-rose-900/50 text-rose-800 dark:text-rose-400 text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- ======================= LEFT: MATA PELAJARAN ======================= -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl p-6 shadow-sm">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Mata Pelajaran</h2>
                    
                    <button id="btn-buka-create-mapel" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs shadow-md shadow-indigo-100 dark:shadow-none transition-colors flex items-center justify-center gap-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Mapel
                    </button>
                </div>

                <!-- Search -->
                <div class="mb-6">
                    <form method="GET" action="{{ route('mapel.index') }}" class="relative w-full sm:w-80">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari kode atau nama mapel..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                        <div class="absolute left-3.5 top-3.5 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.608 10.608Z" />
                            </svg>
                        </div>
                        @if($search)
                            <a href="{{ route('mapel.index') }}" class="absolute right-3 top-3 text-slate-400 hover:text-slate-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Mapel Table -->
                <div class="border border-slate-100 dark:border-slate-800/80 rounded-xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                                    <th class="py-3.5 px-4 text-xs font-semibold uppercase tracking-wider text-slate-400 w-16 text-center">No</th>
                                    <th class="py-3.5 px-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Kode Mapel</th>
                                    <th class="py-3.5 px-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Mapel</th>
                                    <th class="py-3.5 px-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Kategori</th>
                                    <th class="py-3.5 px-4 text-xs font-semibold uppercase tracking-wider text-slate-400 w-28 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                                @forelse($mapels as $index => $mapel)
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                                        <td class="py-3.5 px-4 text-sm text-slate-500 text-center font-medium">{{ $mapels->firstItem() + $index }}</td>
                                        <td class="py-3.5 px-4 text-sm font-semibold text-indigo-600 dark:text-indigo-400 font-mono">{{ $mapel->kode_mapel }}</td>
                                        <td class="py-3.5 px-4 text-sm font-semibold text-slate-900 dark:text-white">{{ $mapel->nama_mapel }}</td>
                                        <td class="py-3.5 px-4 text-sm">
                                            @if($mapel->kategori)
                                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold 
                                                    @if($mapel->kategori->nama_kategori === 'Umum') bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900/30
                                                    @elseif($mapel->kategori->nama_kategori === 'Matematika') bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-900/30
                                                    @elseif($mapel->kategori->nama_kategori === 'Praktik') bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30
                                                    @else bg-slate-50 dark:bg-slate-800/60 text-slate-600 dark:text-slate-400 border border-slate-100 dark:border-slate-800 @endif">
                                                    {{ $mapel->kategori->nama_kategori }}
                                                </span>
                                            @else
                                                <span class="text-xs text-slate-400 italic">Tanpa Kategori</span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            <div class="inline-flex items-center gap-1.5">
                                                <button onclick="bukaEditMapelModal('{{ $mapel->id }}', '{{ addslashes($mapel->kode_mapel) }}', '{{ addslashes($mapel->nama_mapel) }}', '{{ $mapel->kategori_mapel_id }}')"
                                                    class="p-1.5 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-colors cursor-pointer" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                    </svg>
                                                </button>
                                                <form action="{{ route('mapel.destroy', $mapel->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus mata pelajaran ini?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors cursor-pointer" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-16 text-center text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto mb-3 text-slate-300">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                            </svg>
                                            <p class="text-sm font-semibold">Belum ada data mata pelajaran</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($mapels->hasPages())
                    <div class="mt-4">{{ $mapels->links() }}</div>
                @endif
            </div>
        </div>

        <!-- ======================= RIGHT: KATEGORI MAPEL ======================= -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Kelola Kategori</h2>

                <!-- Add Category Inline Form -->
                <form action="{{ route('mapel.kategori.store') }}" method="POST" class="mb-5 space-y-2">
                    @csrf
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tambah Kategori Baru</label>
                    <div class="flex gap-2">
                        <input type="text" name="nama_kategori" required placeholder="Nama Kategori..." 
                            class="flex-1 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs focus:outline-none focus:border-indigo-500 transition-colors">
                        <button type="submit" class="px-3 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition-colors flex items-center justify-center cursor-pointer" title="Simpan Kategori">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </form>

                <hr class="border-t border-slate-100 dark:border-slate-800 mb-4">

                <!-- Categories List -->
                <div class="border border-slate-100 dark:border-slate-800/80 rounded-xl overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                                <th class="py-2.5 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400 w-12 text-center">No</th>
                                <th class="py-2.5 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Kategori</th>
                                <th class="py-2.5 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400 w-24 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                            @foreach($categories as $index => $cat)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                                    <td class="py-2.5 px-3 text-xs text-slate-500 text-center font-medium">{{ $index + 1 }}</td>
                                    <td class="py-2.5 px-3 text-xs font-bold text-slate-800 dark:text-slate-200">
                                        {{ $cat->nama_kategori }}
                                        @if($cat->instansi_id === null)
                                            <span class="block text-[8px] text-slate-400 uppercase tracking-widest font-normal mt-0.5">Sistem</span>
                                        @endif
                                    </td>
                                    <td class="py-2.5 px-3 text-center">
                                        <div class="inline-flex items-center gap-1">
                                            <!-- Edit button -->
                                            <button onclick="bukaEditKategoriModal('{{ $cat->id }}', '{{ addslashes($cat->nama_kategori) }}')"
                                                class="p-1 rounded text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-colors cursor-pointer" title="Edit Kategori">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-3.5 h-3.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                </svg>
                                            </button>

                                            <!-- Delete button (only if not global system category) -->
                                            @if($cat->instansi_id !== null)
                                                <form action="{{ route('mapel.kategori.destroy', $cat->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus kategori ini? Semua mata pelajaran berkategori ini akan kehilangan kategorinya.')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1 rounded text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors cursor-pointer" title="Hapus Kategori">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-3.5 h-3.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="p-1 text-slate-300 dark:text-slate-700 cursor-not-allowed" title="Kategori Sistem tidak dapat dihapus">
                                                    <i class="fa-solid fa-lock text-xs"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== MODAL TAMBAH MAPEL ===================== -->
    <div id="modal-create-mapel" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <!-- Backdrop -->
        <div id="backdrop-create-mapel" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <!-- Panel -->
        <div class="relative z-10 w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800">
            <form action="{{ route('mapel.store') }}" method="POST">
                @csrf
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Tambah Mapel Baru</h3>
                        <button type="button" id="btn-tutup-create-mapel" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Kode Mapel</label>
                            <input type="text" name="kode_mapel" required placeholder="Contoh: IND-01"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors uppercase">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Nama Mata Pelajaran</label>
                            <input type="text" name="nama_mapel" required placeholder="Contoh: Bahasa Indonesia"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Kategori Mapel</label>
                            <select name="kategori_mapel_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" id="btn-batal-create-mapel" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition-colors">Simpan Mapel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===================== MODAL EDIT MAPEL ===================== -->
    <div id="modal-edit-mapel" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-edit-mapel" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800">
            <form id="form-edit-mapel" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Ubah Mata Pelajaran</h3>
                        <button type="button" id="btn-tutup-edit-mapel" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Kode Mapel</label>
                            <input type="text" name="kode_mapel" id="edit-kode-mapel" required placeholder="Contoh: IND-01"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors uppercase">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Nama Mata Pelajaran</label>
                            <input type="text" name="nama_mapel" id="edit-nama-mapel" required placeholder="Contoh: Bahasa Indonesia"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Kategori Mapel</label>
                            <select name="kategori_mapel_id" id="edit-kategori-mapel-id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" id="btn-batal-edit-mapel" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===================== MODAL EDIT KATEGORI ===================== -->
    <div id="modal-edit-kategori" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-edit-kategori" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800">
            <form id="form-edit-kategori" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Ubah Kategori</h3>
                        <button type="button" id="btn-tutup-edit-kategori" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Nama Kategori</label>
                            <input type="text" name="nama_kategori" id="edit-nama-kategori" required placeholder="Contoh: Umum"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors">
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" id="btn-batal-edit-kategori" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Helper: buka/tutup modal
    function bukaModal(id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.remove('hidden');
            el.classList.add('flex');
        }
    }
    function tutupModal(id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('hidden');
            el.classList.remove('flex');
        }
    }

    // Modal Create Mapel
    const btnBukaCreateMapel = document.getElementById('btn-buka-create-mapel');
    if (btnBukaCreateMapel) {
        btnBukaCreateMapel.addEventListener('click', () => bukaModal('modal-create-mapel'));
    }
    document.getElementById('btn-tutup-create-mapel').addEventListener('click', () => tutupModal('modal-create-mapel'));
    document.getElementById('btn-batal-create-mapel').addEventListener('click', () => tutupModal('modal-create-mapel'));
    document.getElementById('backdrop-create-mapel').addEventListener('click', () => tutupModal('modal-create-mapel'));

    // Modal Edit Mapel
    document.getElementById('btn-tutup-edit-mapel').addEventListener('click', () => tutupModal('modal-edit-mapel'));
    document.getElementById('btn-batal-edit-mapel').addEventListener('click', () => tutupModal('modal-edit-mapel'));
    document.getElementById('backdrop-edit-mapel').addEventListener('click', () => tutupModal('modal-edit-mapel'));

    function bukaEditMapelModal(id, kodeMapel, namaMapel, kategoriMapelId) {
        document.getElementById('form-edit-mapel').action = '/porosdata/mapel/' + id;
        document.getElementById('edit-kode-mapel').value = kodeMapel;
        document.getElementById('edit-nama-mapel').value = namaMapel;
        document.getElementById('edit-kategori-mapel-id').value = kategoriMapelId;
        bukaModal('modal-edit-mapel');
    }

    // Modal Edit Kategori
    document.getElementById('btn-tutup-edit-kategori').addEventListener('click', () => tutupModal('modal-edit-kategori'));
    document.getElementById('btn-batal-edit-kategori').addEventListener('click', () => tutupModal('modal-edit-kategori'));
    document.getElementById('backdrop-edit-kategori').addEventListener('click', () => tutupModal('modal-edit-kategori'));

    function bukaEditKategoriModal(id, namaKategori) {
        document.getElementById('form-edit-kategori').action = '/porosdata/mapel/kategori/' + id;
        document.getElementById('edit-nama-kategori').value = namaKategori;
        bukaModal('modal-edit-kategori');
    }

    // Tutup dengan Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            tutupModal('modal-create-mapel');
            tutupModal('modal-edit-mapel');
            tutupModal('modal-edit-kategori');
        }
    });
</script>
@endsection
