@extends('PorosDataHome.SubMenuApplication.DataSiswa.layouts.app')

@section('title', 'Kelola Siswa')

@section('content')
    <style>
        /* CSS overrides to ensure solid colors load properly in light/dark themes */
        
        /* ==================== DARK THEME ==================== */
        .dark div[class*="bg-[#0f172a]"] {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
        }
        .dark div[class*="bg-slate-950/80"] {
            background-color: rgba(2, 6, 23, 0.75) !important;
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
        div[class*="bg-slate-950/80"] {
            background-color: rgba(15, 23, 42, 0.4) !important;
            backdrop-filter: blur(4px) !important;
            -webkit-backdrop-filter: blur(4px) !important;
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
        <form method="GET" action="{{ route('datasiswa.kelola_siswa') }}" class="w-full flex flex-col sm:flex-row items-center gap-3">
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
                @if($user->role === 'wali_kelas')
                    <!-- Wali kelas only has access to their class, so "Semua Kelas" resolves to their class(es) -->
                    <option value="">Kelas Anda</option>
                @else
                    <option value="">Semua Kelas</option>
                @endif
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $kelasId == $class->id ? 'selected' : '' }}>{{ $class->nama_kelas }}</option>
                @endforeach
            </select>
            <select name="status" onchange="this.form.submit()" class="w-full sm:w-44 px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                <option value="">Semua Status</option>
                <option value="aktif" {{ $status === 'aktif' ? 'selected' : '' }}>Aktif</option>
            </select>
            @if($search || $kelasId || $status)
                <a href="{{ route('datasiswa.kelola_siswa') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 whitespace-nowrap">Hapus Filter</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800 text-slate-400 dark:text-slate-500 text-xs font-semibold uppercase tracking-wider">
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-16 text-center">No</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Siswa</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">NISN</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Password</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 text-center">Kelas</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 text-center">Status</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-32 text-center text-right pr-10">Aksi</th>
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
                            <td class="py-4 px-6 text-center">
                                @if($siswa->status === 'aktif')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400">Aktif</span>
                                @elseif($siswa->status === 'lulus')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-400">Lulus</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-400">Drop Out</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right pr-10">
                                <div class="inline-flex items-center gap-2 justify-end">
                                    <button data-siswa="{{ json_encode($siswa) }}" data-password="{{ $siswa->user->password_plain }}" onclick="bukaEditModal(this)"
                                        class="p-2 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-colors" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                    <button type="button" onclick="bukaDeleteModal('{{ route('datasiswa.kelola_siswa.destroy', $siswa->id) }}')"
                                        class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto mb-3 text-slate-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                </svg>
                                <p class="text-sm font-semibold">Belum ada data siswa</p>
                                <p class="text-xs mt-1">Coba sesuaikan filter pencarian Anda</p>
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

    <!-- ===================== MODAL EDIT ===================== -->
    <div id="modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-edit" class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm"></div>
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

                    <!-- Information Banner for Wali Kelas -->
                    @if($user->role === 'wali_kelas')
                        <div class="mb-4 p-3.5 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs flex gap-2.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 shrink-0 mt-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                            <div>
                                <span class="font-bold">Informasi:</span> Sebagai Wali Kelas, perubahan data ini harus menunggu persetujuan dari Admin terlebih dahulu sebelum resmi diperbarui di sistem.
                            </div>
                        </div>
                    @endif

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
                                            <select name="angkatan" id="edit-angkatan" required class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                                <option value="">Pilih...</option>
                                                @for($year = date('Y') + 2; $year >= 2020; $year--)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Kelas Saat Ini <span class="text-rose-500">*</span></label>
                                            <select name="kelas_id" id="edit-kelas-id" required class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                                <option value="">Pilih...</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->nama_kelas }}</option>
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
                                            <input type="text" name="jurusan" id="edit-jurusan" required placeholder="Contoh: IPA"
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Status Akademik <span class="text-rose-500">*</span></label>
                                            <select name="status" id="edit-status" required class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none">
                                                <option value="aktif">Aktif</option>
                                                <option value="drop_out">Drop Out</option>
                                            </select>
                                        </div>
                                        <div id="wrapper-alasan-dropout" class="hidden">
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Alasan Dropout <span class="text-rose-500">*</span></label>
                                            <textarea name="alasan_dropout" id="edit-alasan-dropout" placeholder="Tuliskan alasan detail dropout siswa..."
                                                class="w-full bg-[#070b13] border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-100 text-sm rounded-lg px-4 py-2.5 transition-colors focus:outline-none" rows="2"></textarea>
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

    <!-- ===================== MODAL PERSATUJUAN CONFIRMATION (For Wali Kelas) ===================== -->
    @if($user->role === 'wali_kelas')
        <div id="modal-confirm-approval" class="fixed inset-0 z-[60] hidden items-center justify-center p-4">
            <div id="backdrop-confirm" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="relative z-10 w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-amber-100 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 mb-4">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2">Persetujuan Admin Diperlukan</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-6">
                    Perubahan data siswa oleh Wali Kelas memerlukan persetujuan dari Admin terlebih dahulu. Pengajuan perubahan ini akan dikirim untuk menunggu tinjauan admin. Apakah Anda yakin?
                </p>
                <div class="flex justify-center gap-3">
                    <button type="button" onclick="tutupModal('modal-confirm-approval'); bukaModal('modal-edit');" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Batal</button>
                    <button type="button" id="btn-submit-confirmed" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs transition-colors">Ya, Kirim Pengajuan</button>
                </div>
            </div>
        </div>
    @endif

    <!-- ===================== MODAL DELETE CONFIRMATION ===================== -->
    <div id="modal-confirm-delete" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-delete-confirm" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 mb-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            @if($user->role === 'wali_kelas')
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2">Ajukan Penghapusan Siswa (Dropout)</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-4">
                    Sebagai Wali Kelas, penghapusan data siswa ini akan diajukan sebagai status **Drop Out** dan memerlukan persetujuan dari Admin Utama.
                </p>
                <form id="form-delete-confirm" method="POST" class="space-y-4 text-left">
                    @csrf
                    @method('DELETE')
                    <div>
                        <label for="alasan_dropout" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Alasan Dropout <span class="text-rose-500">*</span></label>
                        <textarea name="alasan_dropout" id="alasan_dropout" required placeholder="Tuliskan alasan detail dropout siswa..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-800 dark:text-slate-100 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors" rows="3"></textarea>
                    </div>
                    <div class="flex justify-end gap-3 pt-2 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" onclick="tutupModal('modal-confirm-delete')" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs transition-colors">Ya, Kirim Pengajuan</button>
                    </div>
                </form>
            @else
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2">Hapus Data Siswa</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-6">
                    Apakah Anda yakin ingin menghapus data siswa ini beserta akun loginnya? Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex justify-center gap-3">
                    <button type="button" onclick="tutupModal('modal-confirm-delete')" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Batal</button>
                    <form id="form-delete-confirm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs transition-colors">Ya, Hapus Data</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function bukaModal(id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.remove('hidden');
            el.classList.add('flex');
        }
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

    document.getElementById('btn-tutup-edit').addEventListener('click', () => tutupModal('modal-edit'));
    document.getElementById('btn-batal-edit').addEventListener('click', () => tutupModal('modal-edit'));
    document.getElementById('backdrop-edit').addEventListener('click', () => tutupModal('modal-edit'));

    const editStatus = document.getElementById('edit-status');
    const wrapperAlasanDropout = document.getElementById('wrapper-alasan-dropout');
    const editAlasanDropout = document.getElementById('edit-alasan-dropout');

    function toggleAlasanDropout() {
        if (editStatus && editStatus.value === 'drop_out') {
            wrapperAlasanDropout.classList.remove('hidden');
            editAlasanDropout.setAttribute('required', 'required');
        } else if (editStatus) {
            wrapperAlasanDropout.classList.add('hidden');
            editAlasanDropout.removeAttribute('required');
        }
    }

    if (editStatus) {
        editStatus.addEventListener('change', toggleAlasanDropout);
    }

    function bukaEditModal(btn) {
        const siswa = JSON.parse(btn.getAttribute('data-siswa'));
        const passwordPlain = btn.getAttribute('data-password');

        document.getElementById('form-edit').action = '/porosdata/datasiswa/kelola-siswa/' + siswa.id;
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
        
        if (editAlasanDropout) {
            editAlasanDropout.value = '';
        }
        toggleAlasanDropout();
        
        bukaModal('modal-edit');
    }

    // Intercept form edit submission if role is wali_kelas
    @if($user->role === 'wali_kelas')
        document.getElementById('form-edit').addEventListener('submit', function(e) {
            e.preventDefault(); // Stop direct submission
            tutupModal('modal-edit'); // Hide edit modal first
            bukaModal('modal-confirm-approval'); // Show the warning/popup
        });

        document.getElementById('btn-submit-confirmed').addEventListener('click', function() {
            tutupModal('modal-confirm-approval');
            document.getElementById('form-edit').submit(); // Submit after approval confirmation
        });

        const backdropConfirm = document.getElementById('backdrop-confirm');
        if (backdropConfirm) {
            backdropConfirm.addEventListener('click', () => {
                tutupModal('modal-confirm-approval');
                bukaModal('modal-edit');
            });
        }
    @endif

    function bukaDeleteModal(actionUrl) {
        document.getElementById('form-delete-confirm').action = actionUrl;
        const inputAlasan = document.getElementById('alasan_dropout');
        if (inputAlasan) {
            inputAlasan.value = '';
        }
        bukaModal('modal-confirm-delete');
    }

    const backdropDeleteConfirm = document.getElementById('backdrop-delete-confirm');
    if (backdropDeleteConfirm) {
        backdropDeleteConfirm.addEventListener('click', () => tutupModal('modal-confirm-delete'));
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            @if($user->role === 'wali_kelas')
                const confirmModal = document.getElementById('modal-confirm-approval');
                if (confirmModal && !confirmModal.classList.contains('hidden')) {
                    tutupModal('modal-confirm-approval');
                    bukaModal('modal-edit');
                    return;
                }
            @endif
            const deleteModal = document.getElementById('modal-confirm-delete');
            if (deleteModal && !deleteModal.classList.contains('hidden')) {
                tutupModal('modal-confirm-delete');
                return;
            }
            tutupModal('modal-edit');
        }
    });
</script>
@endsection
