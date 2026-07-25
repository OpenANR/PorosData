@extends('PorosDataHome.layouts.app')

@section('title', 'Kelola Siswa')

@section('content')
    <style>
        /* CSS overrides to ensure solid colors load properly in light/dark themes */
        
        /* ==================== DARK THEME ==================== */
        .dark div[class*="bg-[#0f172a]"] {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
        }
        .dark div[class*="bg-[#1e293b]/20"] {
            background-color: rgba(30, 41, 59, 0.2) !important;
            border-color: #1e293b !important;
        }
        .dark div[class*="bg-[#1e293b]/60"] {
            background-color: rgba(30, 41, 59, 0.6) !important;
            border-bottom: 1px solid #1e293b !important;
        }
        .dark input[class*="bg-[#070b13]"], .dark select[class*="bg-[#070b13]"], .dark textarea[class*="bg-[#070b13]"] {
            background-color: #070b13 !important;
            border: 1px solid #1e293b !important;
            color: #f1f5f9 !important;
        }
        .dark input[class*="bg-[#070b13]"]:focus, .dark select[class*="bg-[#070b13]"]:focus, .dark textarea[class*="bg-[#070b13]"]:focus {
            border-color: #3b82f6 !important;
            outline: none !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
        }
        .dark div[class*="bg-[#0a0f1d]"] {
            background-color: #0a0f1d !important;
            border-top: 1px solid rgba(30, 41, 59, 0.8) !important;
        }
        .dark div[class*="bg-[#0f172a]"] h3, .dark div[class*="bg-[#0f172a]"] h4 {
            color: #ffffff !important;
        }
        .dark #btn-tutup-create, .dark #btn-tutup-edit, .dark #btn-batal-create, .dark #btn-batal-edit {
            color: #94a3b8 !important;
        }
        .dark #btn-tutup-create:hover, .dark #btn-tutup-edit:hover, .dark #btn-batal-create:hover, .dark #btn-batal-edit:hover {
            color: #ffffff !important;
        }
        .dark div[class*="max-h-[65vh]"]::-webkit-scrollbar-track {
            background: #0f172a !important;
        }
        .dark div[class*="max-h-[65vh]"]::-webkit-scrollbar-thumb {
            background: #1e293b !important;
        }

        /* ==================== LIGHT THEME ==================== */
        div[class*="bg-[#0f172a]"] {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
        }
        div[class*="bg-[#1e293b]/20"] {
            background-color: #f8fafc !important;
            border-color: #e2e8f0 !important;
        }
        div[class*="bg-[#1e293b]/60"] {
            background-color: #f1f5f9 !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }
        input[class*="bg-[#070b13]"], select[class*="bg-[#070b13]"], textarea[class*="bg-[#070b13]"] {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
        }
        input[class*="bg-[#070b13]"]:focus, select[class*="bg-[#070b13]"]:focus, textarea[class*="bg-[#070b13]"]:focus {
            border-color: #3b82f6 !important;
            outline: none !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
        }
        div[class*="bg-[#0a0f1d]"] {
            background-color: #f8fafc !important;
            border-top: 1px solid #e2e8f0 !important;
        }
        div[class*="bg-[#0f172a]"] h3, div[class*="bg-[#0f172a]"] h4 {
            color: #0f172a !important;
        }
        #btn-tutup-create, #btn-tutup-edit, #btn-batal-create, #btn-batal-edit {
            color: #64748b !important;
        }
        #btn-tutup-create:hover, #btn-tutup-edit:hover, #btn-batal-create:hover, #btn-batal-edit:hover {
            color: #1e293b !important;
        }
        div[class*="max-h-[65vh]"]::-webkit-scrollbar-track {
            background: #ffffff !important;
        }
        div[class*="max-h-[65vh]"]::-webkit-scrollbar-thumb {
            background: #cbd5e1 !important;
        }

        /* Common settings */
        div[class*="max-h-[65vh]"] {
            max-height: 60vh !important;
            overflow-y: auto !important;
        }
        div[class*="max-h-[65vh]"]::-webkit-scrollbar {
            width: 6px !important;
        }
        div[class*="max-h-[65vh]"]::-webkit-scrollbar-thumb {
            border-radius: 9999px !important;
        }
    </style>
    <!-- Page Heading -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Kelola Siswa</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manajemen data siswa aktif, lulus, dan alumni</p>
    </div>

    <!-- Actions and Filters Bar -->
    <div class="mb-6 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-4">
        <form method="GET" action="{{ route('siswa.index') }}" class="w-full flex flex-col sm:flex-row items-center gap-3">
            <div class="w-full sm:w-72 relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari NISN, nama, username..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                <div class="absolute left-3.5 top-3 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.608 10.608Z" />
                    </svg>
                </div>
            </div>
            <select name="kelas_id" onchange="this.form.submit()" class="w-full sm:w-44 px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                <option value="">Semua Kelas</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $kelasId == $class->id ? 'selected' : '' }}>{{ $class->nama_kelas }}</option>
                @endforeach
            </select>
            <select name="status" onchange="this.form.submit()" class="w-full sm:w-44 px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                <option value="">Semua Status</option>
                <option value="aktif" {{ $status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="drop_out" {{ $status === 'drop_out' ? 'selected' : '' }}>Drop Out</option>
            </select>
            <select name="angkatan" onchange="this.form.submit()" class="w-full sm:w-44 px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                <option value="">Semua Angkatan</option>
                @foreach($angkatans as $ang)
                    <option value="{{ $ang }}" {{ $angkatan === $ang ? 'selected' : '' }}>{{ $ang }}</option>
                @endforeach
            </select>
            @if($search || $kelasId || $status || $angkatan)
                <a href="{{ route('siswa.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 whitespace-nowrap">Hapus Filter</a>
            @endif
        </form>

        <button id="btn-buka-create" class="w-full xl:w-auto px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-100 dark:shadow-none transition-colors flex items-center justify-center gap-2 shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Siswa
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-16 text-center">No</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Siswa</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">NISN</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Password</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 text-center">Kelas</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 text-center">Angkatan</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 text-center">Status</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($siswas as $index => $siswa)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                            <td class="py-4 px-6 text-sm text-slate-500 text-center font-medium">{{ $siswas->firstItem() + $index }}</td>
                            <td class="py-4 px-6">
                                <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ $siswa->user->name }}</div>
                                <div class="text-xs text-slate-400">@ {{ $siswa->user->username }}</div>
                            </td>
                            <td class="py-4 px-6 text-sm font-mono text-slate-600 dark:text-slate-300">{{ $siswa->nisn }}</td>
                            <td class="py-4 px-6 text-sm font-mono text-slate-600 dark:text-slate-300">{{ $siswa->user->password_plain ?? '-' }}</td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                    {{ $siswa->kelas ? $siswa->kelas->nama_kelas : 'Tanpa Kelas' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center text-sm font-semibold text-slate-700 dark:text-slate-300">
                                {{ $siswa->angkatan ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($siswa->status === 'aktif')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400">Aktif</span>
                                @elseif($siswa->status === 'lulus')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-400">Lulus</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-400">Drop Out</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <button data-siswa="{{ json_encode($siswa) }}" data-password="{{ $siswa->user->password_plain }}" onclick="bukaEditModal(this)"
                                        class="p-2 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-colors" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus data siswa ini beserta akun loginnya?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors" title="Hapus">
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
                            <td colspan="8" class="py-16 text-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto mb-3 text-slate-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                </svg>
                                <p class="text-sm font-semibold">Belum ada data siswa</p>
                                <p class="text-xs mt-1">Coba sesuaikan filter atau tambah siswa baru</p>
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

@push('modals')
    <!-- ===================== MODAL TAMBAH ===================== -->
    <div id="modal-create" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-create" class="absolute inset-0 custom-backdrop"></div>
        <div class="relative z-10 w-full max-w-2xl bg-[#0f172a] rounded-2xl shadow-2xl border border-slate-800">
            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-white">Tambah Siswa Baru</h3>
                        </div>
                        <button type="button" id="btn-tutup-create" class="text-slate-400 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-6 max-h-[65vh] overflow-y-auto pr-2">
                        <!-- Card: Data Pribadi Akademik -->
                        <div class="border border-slate-800 bg-[#1e293b]/20 rounded-xl overflow-hidden">
                            <div class="bg-[#1e293b]/60 px-4 py-3 border-b border-slate-800 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                </svg>
                                <h4 class="text-xs font-bold text-white uppercase tracking-wider">Data Pribadi Akademik</h4>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Column Left -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                                            <input type="text" name="name" required placeholder="Contoh: Adit Pratama"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Username <span class="text-rose-500">*</span></label>
                                            <input type="text" name="username" required placeholder="Contoh: aditpratama"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Angkatan <span class="text-rose-500">*</span></label>
                                            <input type="text" name="angkatan" id="create-angkatan" required placeholder="Contoh: 2024/2025"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Kelas Saat Ini <span class="text-rose-500">*</span></label>
                                            <select name="kelas_id" id="create-kelas-id" required class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none" onchange="document.getElementById('create-jurusan').value = this.options[this.selectedIndex].getAttribute('data-jurusan')">
                                                <option value="" data-jurusan="">Pilih...</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" data-jurusan="{{ $class->jurusan ? $class->jurusan->nama_jurusan : '-' }}">{{ $class->nama_kelas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                                <option value="">Pilih...</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Tanggal Lahir</label>
                                            <input type="date" name="tanggal_lahir"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Kewarganegaraan</label>
                                            <input type="text" name="kewarganegaraan" value="WNI" placeholder="Contoh: WNI"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nomor Telepon/HP</label>
                                            <input type="text" name="nomor_telepon" placeholder="Contoh: 0812..."
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Berat Badan (KG)</label>
                                            <input type="number" name="berat_badan" placeholder="Contoh: 50"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                    </div>
                                    <!-- Column Right -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">NISN <span class="text-rose-500">*</span></label>
                                            <input type="text" name="nisn" required placeholder="10-digit angka unik"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Kata Sandi <span class="text-rose-500">*</span></label>
                                            <input type="password" name="password" required placeholder="Minimal 6 karakter"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Jurusan <span class="text-rose-500">*</span></label>
                                            <input type="text" name="jurusan" id="create-jurusan" required readonly placeholder="Pilih kelas terlebih dahulu"
                                                class="w-full bg-[#1e293b]/50 border border-slate-800 text-slate-400 text-sm rounded-lg px-4 py-2.5 cursor-not-allowed focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Status Akademik <span class="text-rose-500">*</span></label>
                                            <select name="status" required class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                                <option value="aktif">Aktif</option>
                                                <option value="drop_out">Drop Out</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Panggilan</label>
                                            <input type="text" name="nama_panggilan" placeholder="Contoh: Adit"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Tempat Lahir</label>
                                            <input type="text" name="tempat_lahir" placeholder="Contoh: Jakarta"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Agama</label>
                                            <input type="text" name="agama" placeholder="Contoh: Islam"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Alamat Lengkap</label>
                                            <textarea name="alamat_lengkap" placeholder="Contoh: Jl. Merdeka No. 10" rows="3"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none"></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Tinggi Badan (CM)</label>
                                            <input type="number" name="tinggi_badan" placeholder="Contoh: 160"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card: Data Keluarga -->
                        <div class="border border-slate-800 bg-[#1e293b]/20 rounded-xl overflow-hidden">
                            <div class="bg-[#1e293b]/60 px-4 py-3 border-b border-slate-800 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <h4 class="text-xs font-bold text-white uppercase tracking-wider">Data Keluarga</h4>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Column Left -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Anak ke-</label>
                                            <input type="text" name="anak_ke" placeholder="Contoh: 1"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Status Yatim/Piatu</label>
                                            <select name="status_yatim_piatu" class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                                <option value="">Pilih...</option>
                                                <option value="Lengkap">Lengkap</option>
                                                <option value="Yatim">Yatim</option>
                                                <option value="Piatu">Piatu</option>
                                                <option value="Yatim Piatu">Yatim Piatu</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Lengkap Ayah</label>
                                            <input type="text" name="nama_ayah" placeholder="Contoh: Budi Santoso"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nomor HP Ayah</label>
                                            <input type="text" name="nomor_hp_ayah" placeholder="Contoh: 0812..."
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Pekerjaan Ibu</label>
                                            <input type="text" name="pekerjaan_ibu" placeholder="Contoh: Wiraswasta"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                    </div>
                                    <!-- Column Right -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Jumlah Saudara Kandung</label>
                                            <input type="number" name="jumlah_saudara_kandung" placeholder="Contoh: 2"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Tinggal Dengan</label>
                                            <input type="text" name="tinggal_dengan" placeholder="Contoh: Orang Tua"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Pekerjaan Ayah</label>
                                            <input type="text" name="pekerjaan_ayah" placeholder="Contoh: Karyawan Swasta"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Lengkap Ibu</label>
                                            <input type="text" name="nama_ibu" placeholder="Contoh: Siti Aminah"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nomor HP Ibu</label>
                                            <input type="text" name="nomor_hp_ibu" placeholder="Contoh: 0812..."
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-[#0a0f1d] border-t border-slate-800/80 flex justify-end items-center gap-4 rounded-b-2xl">
                    <button type="button" id="btn-batal-create" class="px-4 py-2.5 text-sm font-semibold text-slate-400 hover:text-white transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm transition-colors shadow-lg shadow-blue-500/20">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===================== MODAL EDIT ===================== -->
    <div id="modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-edit" class="absolute inset-0 custom-backdrop"></div>
        <div class="relative z-10 w-full max-w-2xl bg-[#0f172a] rounded-2xl shadow-2xl border border-slate-800">
            <form id="form-edit" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-white">Ubah Data Siswa</h3>
                        </div>
                        <button type="button" id="btn-tutup-edit" class="text-slate-400 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-6 max-h-[65vh] overflow-y-auto pr-2">
                        <!-- Card: Data Pribadi Akademik -->
                        <div class="border border-slate-800 bg-[#1e293b]/20 rounded-xl overflow-hidden">
                            <div class="bg-[#1e293b]/60 px-4 py-3 border-b border-slate-800 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                </svg>
                                <h4 class="text-xs font-bold text-white uppercase tracking-wider">Data Pribadi Akademik</h4>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Column Left -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                                            <input type="text" name="name" id="edit-name" required placeholder="Contoh: Adit Pratama"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Username <span class="text-rose-500">*</span></label>
                                            <input type="text" name="username" id="edit-username" required placeholder="Contoh: aditpratama"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Angkatan <span class="text-rose-500">*</span></label>
                                            <input type="text" name="angkatan" id="edit-angkatan" required placeholder="Contoh: 2024/2025"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Kelas Saat Ini <span class="text-rose-500">*</span></label>
                                            <select name="kelas_id" id="edit-kelas-id" required class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none" onchange="document.getElementById('edit-jurusan').value = this.options[this.selectedIndex].getAttribute('data-jurusan')">
                                                <option value="" data-jurusan="">Pilih...</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" data-jurusan="{{ $class->jurusan ? $class->jurusan->nama_jurusan : '-' }}">{{ $class->nama_kelas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" id="edit-jenis-kelamin" class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                                <option value="">Pilih...</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Tanggal Lahir</label>
                                            <input type="date" name="tanggal_lahir" id="edit-tanggal-lahir"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Kewarganegaraan</label>
                                            <input type="text" name="kewarganegaraan" id="edit-kewarganegaraan" placeholder="Contoh: WNI"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nomor Telepon/HP</label>
                                            <input type="text" name="nomor_telepon" id="edit-nomor-telepon" placeholder="Contoh: 0812..."
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Berat Badan (KG)</label>
                                            <input type="number" name="berat_badan" id="edit-berat-badan" placeholder="Contoh: 50"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                    </div>
                                    <!-- Column Right -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">NISN <span class="text-rose-500">*</span></label>
                                            <input type="text" name="nisn" id="edit-nisn" required placeholder="10-digit angka unik"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Kata Sandi</label>
                                            <input type="text" name="password" id="edit-password" placeholder="Kosongkan jika tidak diubah"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Jurusan <span class="text-rose-500">*</span></label>
                                            <input type="text" name="jurusan" id="edit-jurusan" required readonly placeholder="Pilih kelas terlebih dahulu"
                                                class="w-full bg-[#1e293b]/50 border border-slate-800 text-slate-400 text-sm rounded-lg px-4 py-2.5 cursor-not-allowed focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Status Akademik <span class="text-rose-500">*</span></label>
                                            <select name="status" id="edit-status" required class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                                <option value="aktif">Aktif</option>
                                                <option value="drop_out">Drop Out</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Panggilan</label>
                                            <input type="text" name="nama_panggilan" id="edit-nama-panggilan" placeholder="Contoh: Adit"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Tempat Lahir</label>
                                            <input type="text" name="tempat_lahir" id="edit-tempat-lahir" placeholder="Contoh: Jakarta"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Agama</label>
                                            <input type="text" name="agama" id="edit-agama" placeholder="Contoh: Islam"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Alamat Lengkap</label>
                                            <textarea name="alamat_lengkap" id="edit-alamat-lengkap" placeholder="Contoh: Jl. Merdeka No. 10" rows="3"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none"></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Tinggi Badan (CM)</label>
                                            <input type="number" name="tinggi_badan" id="edit-tinggi-badan" placeholder="Contoh: 160"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card: Data Keluarga -->
                        <div class="border border-slate-800 bg-[#1e293b]/20 rounded-xl overflow-hidden">
                            <div class="bg-[#1e293b]/60 px-4 py-3 border-b border-slate-800 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <h4 class="text-xs font-bold text-white uppercase tracking-wider">Data Keluarga</h4>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Column Left -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Anak ke-</label>
                                            <input type="text" name="anak_ke" id="edit-anak-ke" placeholder="Contoh: 1"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Status Yatim/Piatu</label>
                                            <select name="status_yatim_piatu" id="edit-status-yatim-piatu" class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                                <option value="">Pilih...</option>
                                                <option value="Lengkap">Lengkap</option>
                                                <option value="Yatim">Yatim</option>
                                                <option value="Piatu">Piatu</option>
                                                <option value="Yatim Piatu">Yatim Piatu</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Lengkap Ayah</label>
                                            <input type="text" name="nama_ayah" id="edit-nama-ayah" placeholder="Contoh: Budi Santoso"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nomor HP Ayah</label>
                                            <input type="text" name="nomor_hp_ayah" id="edit-nomor-hp-ayah" placeholder="Contoh: 0812..."
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Pekerjaan Ibu</label>
                                            <input type="text" name="pekerjaan_ibu" id="edit-pekerjaan-ibu" placeholder="Contoh: Wiraswasta"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                    </div>
                                    <!-- Column Right -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Jumlah Saudara Kandung</label>
                                            <input type="number" name="jumlah_saudara_kandung" id="edit-jumlah-saudara-kandung" placeholder="Contoh: 2"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Tinggal Dengan</label>
                                            <input type="text" name="tinggal_dengan" id="edit-tinggal-dengan" placeholder="Contoh: Orang Tua"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Pekerjaan Ayah</label>
                                            <input type="text" name="pekerjaan_ayah" id="edit-pekerjaan-ayah" placeholder="Contoh: Karyawan Swasta"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Lengkap Ibu</label>
                                            <input type="text" name="nama_ibu" id="edit-nama-ibu" placeholder="Contoh: Siti Aminah"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nomor HP Ibu</label>
                                            <input type="text" name="nomor_hp_ibu" id="edit-nomor-hp-ibu" placeholder="Contoh: 0812..."
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-[#0a0f1d] border-t border-slate-800/80 flex justify-end items-center gap-4 rounded-b-2xl">
                    <button type="button" id="btn-batal-edit" class="px-4 py-2.5 text-sm font-semibold text-slate-400 hover:text-white transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm transition-colors shadow-lg shadow-blue-500/20">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endpush
@endsection

@section('scripts')
<script>
    function bukaModal(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.remove('hidden');
        el.classList.add('flex');
    }
    function tutupModal(id) {
        const el = document.getElementById(id);
        if (!el || el.classList.contains('hidden')) return;
        el.classList.add('modal-closing');
        setTimeout(() => {
            el.classList.remove('modal-closing');
            el.classList.add('hidden');
            el.classList.remove('flex');
        }, 180);
    }

    document.getElementById('btn-buka-create').addEventListener('click', () => bukaModal('modal-create'));
    document.getElementById('btn-tutup-create').addEventListener('click', () => tutupModal('modal-create'));
    document.getElementById('btn-batal-create').addEventListener('click', () => tutupModal('modal-create'));
    document.getElementById('backdrop-create').addEventListener('click', () => tutupModal('modal-create'));

    document.getElementById('btn-tutup-edit').addEventListener('click', () => tutupModal('modal-edit'));
    document.getElementById('btn-batal-edit').addEventListener('click', () => tutupModal('modal-edit'));
    document.getElementById('backdrop-edit').addEventListener('click', () => tutupModal('modal-edit'));

    function bukaEditModal(btn) {
        const siswa = JSON.parse(btn.getAttribute('data-siswa'));
        const passwordPlain = btn.getAttribute('data-password');

        document.getElementById('form-edit').action = '/porosdata/siswa/' + siswa.id;
        document.getElementById('edit-name').value = siswa.user.name;
        document.getElementById('edit-username').value = siswa.user.username;
        document.getElementById('edit-nisn').value = siswa.nisn;
        document.getElementById('edit-kelas-id').value = siswa.kelas_id;
        document.getElementById('edit-status').value = siswa.status;
        document.getElementById('edit-password').value = passwordPlain || '';
        
        // Populate new fields
        document.getElementById('edit-angkatan').value = siswa.angkatan || '';
        document.getElementById('edit-jurusan').value = siswa.jurusan || '';
        document.getElementById('edit-nama-panggilan').value = siswa.nama_panggilan || '';
        document.getElementById('edit-jenis-kelamin').value = siswa.jenis_kelamin || '';
        document.getElementById('edit-tempat-lahir').value = siswa.tempat_lahir || '';
        document.getElementById('edit-tanggal-lahir').value = siswa.tanggal_lahir || '';
        document.getElementById('edit-agama').value = siswa.agama || '';
        document.getElementById('edit-kewarganegaraan').value = siswa.kewarganegaraan || '';
        document.getElementById('edit-alamat-lengkap').value = siswa.alamat_lengkap || '';
        document.getElementById('edit-nomor-telepon').value = siswa.nomor_telepon || '';
        document.getElementById('edit-tinggi-badan').value = siswa.tinggi_badan || '';
        document.getElementById('edit-berat-badan').value = siswa.berat_badan || '';
        
        document.getElementById('edit-anak-ke').value = siswa.anak_ke || '';
        document.getElementById('edit-jumlah-saudara-kandung').value = siswa.jumlah_saudara_kandung || '';
        document.getElementById('edit-status-yatim-piatu').value = siswa.status_yatim_piatu || '';
        document.getElementById('edit-tinggal-dengan').value = siswa.tinggal_dengan || '';
        document.getElementById('edit-nama-ayah').value = siswa.nama_ayah || '';
        document.getElementById('edit-pekerjaan-ayah').value = siswa.pekerjaan_ayah || '';
        document.getElementById('edit-nomor-hp-ayah').value = siswa.nomor_hp_ayah || '';
        document.getElementById('edit-nama-ibu').value = siswa.nama_ibu || '';
        document.getElementById('edit-pekerjaan-ibu').value = siswa.pekerjaan_ibu || '';
        document.getElementById('edit-nomor-hp-ibu').value = siswa.nomor_hp_ibu || '';

        bukaModal('modal-edit');
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            tutupModal('modal-create');
            tutupModal('modal-edit');
        }
    });
</script>
@endsection
