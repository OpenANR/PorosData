@extends('PorosDataHome.SubMenuApplication.DataSiswa.layouts.app')

@section('title', 'Riwayat Dropout Siswa')

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
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Modul Riwayat Dropout Siswa</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-1 leading-relaxed">
                    Halaman ini dikhususkan untuk mencatat dan mengarsipkan seluruh riwayat siswa yang dikeluarkan, mengundurkan diri (mutasi keluar), atau dinyatakan putus sekolah (Dropout). Modul ini akan mencatat tanggal status berubah, kelas terakhir, alasan detail dropout, dan berkas pendukung (surat pernyataan) guna keperluan administrasi audit sekolah serta laporan dinas pendidikan setempat.
                </p>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-950 dark:text-white">Riwayat Dropout Siswa</h1>
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
            <input type="text" placeholder="Cari nama siswa..." class="block w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800/60 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-rose-500/20 text-slate-400 cursor-not-allowed" readonly>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <select class="w-full md:w-48 px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800/60 rounded-xl text-xs text-slate-400 cursor-not-allowed" disabled>
                <option>Filter Alasan</option>
            </select>
        </div>
    </div>

    <!-- Mock Log Table -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800/60 text-slate-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Tanggal Keluar</th>
                        <th class="px-6 py-4">Nama Siswa</th>
                        <th class="px-6 py-4">Kelas Terakhir</th>
                        <th class="px-6 py-4">Alasan Dropout</th>
                        <th class="px-6 py-4">Penanggung Jawab</th>
                        <th class="px-6 py-4">Status Arsip</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs font-semibold text-slate-700 dark:text-slate-300">
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                        <td class="px-6 py-4.5 text-slate-500 font-mono">12 Jan 2026</td>
                        <td class="px-6 py-4.5">
                            <span class="block text-slate-900 dark:text-white">Riki Hermawan</span>
                            <span class="block text-[10px] text-slate-400 font-medium">NISN: 0112348574</span>
                        </td>
                        <td class="px-6 py-4.5 text-slate-500">Kelas 4B</td>
                        <td class="px-6 py-4.5 text-slate-500">
                            <span class="block">Pindah Domisili Luar Provinsi</span>
                            <span class="block text-[10px] text-slate-400 font-normal">Mengikuti pekerjaan orang tua</span>
                        </td>
                        <td class="px-6 py-4.5 text-slate-500">Drs. Mulyadi</td>
                        <td class="px-6 py-4.5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/30">
                                Terverifikasi
                            </span>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                        <td class="px-6 py-4.5 text-slate-500 font-mono">05 Feb 2026</td>
                        <td class="px-6 py-4.5">
                            <span class="block text-slate-900 dark:text-white">Putri Handayani</span>
                            <span class="block text-[10px] text-slate-400 font-medium">NISN: 0109384756</span>
                        </td>
                        <td class="px-6 py-4.5 text-slate-500">Kelas 6A</td>
                        <td class="px-6 py-4.5 text-slate-500">
                            <span class="block">Faktor Ekonomi Keluarga</span>
                            <span class="block text-[10px] text-slate-400 font-normal">Bantuan dinas sosial sedang diproses</span>
                        </td>
                        <td class="px-6 py-4.5 text-slate-500">Dra. Herlina</td>
                        <td class="px-6 py-4.5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/30">
                                Terverifikasi
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination Area -->
        <div class="px-6 py-4.5 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between">
            <span class="text-[11px] font-semibold text-slate-400">Menampilkan 2 dari 2 riwayat dropout</span>
        </div>
    </div>
@endsection
