@extends('PorosDataHome.SubMenuApplication.DataSiswa.layouts.app')

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
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Modul Otorisasi & Status Persetujuan</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-1 leading-relaxed">
                    Halaman ini berfungsi sebagai alur kontrol otorisasi (approval flow) untuk setiap perubahan kritis data kesiswaan. Pengajuan pendaftaran siswa baru, mutasi masuk/keluar, dan permohonan penonaktifan siswa (dropout) oleh Wali Kelas harus melalui persetujuan (Approve/Reject) Admin Utama atau Kepala Sekolah sebelum tercermin secara formal di sistem.
                </p>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-950 dark:text-white">Status Persetujuan Pengajuan</h1>
        <p class="text-slate-400 dark:text-slate-500 text-xs font-semibold mt-0.5">Prototipe UI / Halaman Statis untuk Review</p>
    </div>

    <!-- Mock Search and Filter Bar -->
    <div class="p-4 mb-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 shadow-sm flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="relative w-full md:max-w-xs">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4.5 h-4.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.637 10.637Z" />
                </svg>
            </div>
            <input type="text" placeholder="Cari NISN atau nama..." class="block w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800/60 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-amber-500/20 text-slate-400 cursor-not-allowed" readonly>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <select class="w-full md:w-48 px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800/60 rounded-xl text-xs text-slate-400 cursor-not-allowed" disabled>
                <option>Filter Jenis Pengajuan</option>
            </select>
        </div>
    </div>

    <!-- Mock Approval Requests Table -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800/60 text-slate-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">ID Pengajuan</th>
                        <th class="px-6 py-4">Nama Siswa / Detail</th>
                        <th class="px-6 py-4">Jenis Pengajuan</th>
                        <th class="px-6 py-4">Diajukan Oleh</th>
                        <th class="px-6 py-4">Status Otorisasi</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs font-semibold text-slate-700 dark:text-slate-300">
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                        <td class="px-6 py-4.5 font-mono text-slate-500 text-xs">REQ-2026-004</td>
                        <td class="px-6 py-4.5">
                            <span class="block text-slate-900 dark:text-white">Bayu Samudra</span>
                            <span class="block text-[10px] text-slate-400 font-medium">NISN: 0134958372 - Kelas 3A</span>
                        </td>
                        <td class="px-6 py-4.5 text-slate-500">Mutasi Masuk (Pindahan)</td>
                        <td class="px-6 py-4.5 text-slate-500">
                            <span class="block">Dian Sastro, S.Pd.</span>
                            <span class="block text-[10px] text-slate-400 font-medium">Wali Kelas 3A</span>
                        </td>
                        <td class="px-6 py-4.5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-900/30">
                                Menunggu Verifikasi
                            </span>
                        </td>
                        <td class="px-6 py-4.5 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <button class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-[10px] font-bold shadow-sm transition-all cursor-not-allowed opacity-80" disabled>Setujui</button>
                                <button class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-500 text-white rounded-lg text-[10px] font-bold shadow-sm transition-all cursor-not-allowed opacity-80" disabled>Tolak</button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                        <td class="px-6 py-4.5 font-mono text-slate-500 text-xs">REQ-2026-003</td>
                        <td class="px-6 py-4.5">
                            <span class="block text-slate-900 dark:text-white">Lina Marlina</span>
                            <span class="block text-[10px] text-slate-400 font-medium">NISN: 0129384756 - Kelas 5B</span>
                        </td>
                        <td class="px-6 py-4.5 text-slate-500">Pengajuan Dropout (DO)</td>
                        <td class="px-6 py-4.5 text-slate-500">
                            <span class="block">Sutrisno, M.Pd.</span>
                            <span class="block text-[10px] text-slate-400 font-medium">Wali Kelas 5B</span>
                        </td>
                        <td class="px-6 py-4.5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-900/30">
                                Menunggu Verifikasi
                            </span>
                        </td>
                        <td class="px-6 py-4.5 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <button class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-[10px] font-bold shadow-sm transition-all cursor-not-allowed opacity-80" disabled>Setujui</button>
                                <button class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-500 text-white rounded-lg text-[10px] font-bold shadow-sm transition-all cursor-not-allowed opacity-80" disabled>Tolak</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination Area -->
        <div class="px-6 py-4.5 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between">
            <span class="text-[11px] font-semibold text-slate-400">Menampilkan 2 dari 2 pengajuan menunggu</span>
        </div>
    </div>
@endsection
