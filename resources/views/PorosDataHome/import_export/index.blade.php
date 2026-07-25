@extends('PorosDataHome.layouts.app')

@section('title', 'Import / Ekspor Data')

@section('content')
    <!-- Page Heading -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Import / Ekspor</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Halaman manajemen untuk mengunduh template dan mengimpor data siswa</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card Export -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3.5 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Export Data / Unduh Template</h2>
                        <p class="text-xs text-slate-400 font-medium">Format: CSV</p>
                    </div>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
                    Unduh data siswa saat ini dalam format CSV. Anda dapat membuka dan mengedit file ini menggunakan Microsoft Excel untuk memperbarui data massal, atau menambah data siswa baru, lalu mengimpornya kembali.
                </p>
            </div>
            <div>
                <a href="{{ route('import-export.export-siswa') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#3b82f6] hover:bg-blue-600 text-white font-semibold text-sm shadow-md shadow-blue-100 dark:shadow-none transition-colors cursor-pointer w-full sm:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4.5 h-4.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Download Data CSV
                </a>
            </div>
        </div>
        <!-- Card Import -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3.5 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Import Data Massal (CSV)</h2>
                        <p class="text-xs text-slate-400 font-medium">Format: CSV</p>
                    </div>
                </div>

                <div class="bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-700/50 rounded-xl p-4 mb-5">
                    <div class="flex items-center gap-2 text-amber-600 dark:text-amber-500 font-bold text-sm mb-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        Aturan Import Data:
                    </div>
                    <ul class="list-disc list-outside ml-4 text-xs text-slate-700 dark:text-slate-300 space-y-1.5 leading-relaxed">
                        <li>Pastikan file disimpan dari Excel dalam format <span class="font-bold text-amber-600 dark:text-amber-500">.CSV</span> (Comma Separated Values).</li>
                        <li><span class="font-bold text-amber-600 dark:text-amber-500">Jangan mengubah</span> nama kolom di baris pertama (Header).</li>
                        <li>Jika NISN di dalam CSV <span class="font-bold text-amber-600 dark:text-amber-500">sudah ada</span> di sistem, maka data akan diperbarui (Update/Tertindih).</li>
                        <li>Jika NISN <span class="font-bold text-amber-600 dark:text-amber-500">belum ada</span>, maka sistem akan menganggapnya sebagai siswa baru (Insert).</li>
                    </ul>
                </div>
            </div>

            <div>
                <form action="{{ route('import-export.import-siswa') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col sm:flex-row items-center gap-3 p-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl">
                        <div class="flex-1 w-full relative">
                            <input type="file" name="file_csv" id="file_csv" accept=".csv" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required onchange="document.getElementById('file_name').textContent = this.files[0] ? this.files[0].name : 'No file chosen'">
                            <div class="flex items-center gap-3 px-2 py-1">
                                <div class="bg-emerald-100 dark:bg-teal-900/50 text-emerald-700 dark:text-teal-400 px-4 py-2 rounded-lg text-xs font-bold border border-emerald-200 dark:border-teal-700/50">
                                    Choose File
                                </div>
                                <span id="file_name" class="text-xs text-slate-500 dark:text-slate-400 font-medium truncate max-w-[120px] sm:max-w-[150px]">No file chosen</span>
                            </div>
                        </div>
                        <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold flex items-center justify-center gap-2 shadow-md shadow-emerald-100 dark:shadow-none transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4.5 h-4.5">
                                <path fill-rule="evenodd" d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.03 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v4.94a.75.75 0 0 0 1.5 0v-4.94l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd" />
                            </svg>
                            Proses Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Area Reset Data -->
    <div class="mt-8 mb-4">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Reset Data Master</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Gunakan fitur ini dengan hati-hati. Tindakan ini akan menghapus data secara permanen.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card Reset Data Siswa -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3.5 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Reset Data Siswa</h2>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5">
                    Peringatan: Tindakan ini akan <span class="font-bold">menghapus seluruh data siswa</span> yang ada di sistem (baik siswa aktif maupun DO) secara permanen.
                </p>
            </div>
            <button type="button" onclick="bukaModalReset('{{ route('import-export.reset-siswa') }}', 'Data Siswa')" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm transition-colors shadow-md shadow-rose-100 dark:shadow-none w-full justify-center mt-auto">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4.5 h-4.5">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                Hapus Semua Data Siswa
            </button>
        </div>

        <!-- Card Reset Kelas -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3.5 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Reset Kelas</h2>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5">
                    Peringatan: Tindakan ini akan <span class="font-bold">menghapus seluruh data kelas</span> yang ada di sistem secara permanen.
                </p>
            </div>
            <button type="button" onclick="bukaModalReset('{{ route('import-export.reset-kelas') }}', 'Data Kelas')" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm transition-colors shadow-md shadow-rose-100 dark:shadow-none w-full justify-center mt-auto">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4.5 h-4.5">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                Hapus Semua Data Kelas
            </button>
        </div>

        <!-- Card Reset Wali Kelas -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3.5 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Reset Wali Kelas</h2>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5">
                    Peringatan: Tindakan ini akan <span class="font-bold">menghapus seluruh data wali kelas</span> yang ada di sistem secara permanen.
                </p>
            </div>
            <button type="button" onclick="bukaModalReset('{{ route('import-export.reset-walikelas') }}', 'Data Wali Kelas')" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm transition-colors shadow-md shadow-rose-100 dark:shadow-none w-full justify-center mt-auto">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4.5 h-4.5">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                Hapus Semua Wali Kelas
            </button>
        </div>

        <!-- Card Reset Guru -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3.5 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Reset Guru</h2>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5">
                    Peringatan: Tindakan ini akan <span class="font-bold">menghapus seluruh data guru</span> yang ada di sistem secara permanen.
                </p>
            </div>
            <button type="button" onclick="bukaModalReset('{{ route('import-export.reset-guru') }}', 'Data Guru')" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm transition-colors shadow-md shadow-rose-100 dark:shadow-none w-full justify-center mt-auto">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4.5 h-4.5">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                Hapus Semua Data Guru
            </button>
        </div>

        <!-- Card Reset Status -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3.5 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Reset Status</h2>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5">
                    Peringatan: Tindakan ini akan <span class="font-bold">menghapus seluruh status persetujuan</span> yang ada di sistem secara permanen.
                </p>
            </div>
            <button type="button" onclick="bukaModalReset('{{ route('import-export.reset-status') }}', 'Status Persetujuan')" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm transition-colors shadow-md shadow-rose-100 dark:shadow-none w-full justify-center mt-auto">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4.5 h-4.5">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                Hapus Status Persetujuan
            </button>
        </div>

        <!-- Card Reset Mapel -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3.5 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Reset Mapel</h2>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5">
                    Peringatan: Tindakan ini akan <span class="font-bold">menghapus seluruh data mapel</span> yang ada di sistem secara permanen.
                </p>
            </div>
            <button type="button" onclick="bukaModalReset('{{ route('import-export.reset-mapel') }}', 'Data Mapel')" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm transition-colors shadow-md shadow-rose-100 dark:shadow-none w-full justify-center mt-auto">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4.5 h-4.5">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                Hapus Semua Data Mapel
            </button>
        </div>

        <!-- Card Reset Riwayat Kelulusan -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3.5 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Reset Riwayat Kelulusan</h2>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5">
                    Peringatan: Tindakan ini akan <span class="font-bold">menghapus seluruh data riwayat kelulusan</span> yang ada di sistem secara permanen.
                </p>
            </div>
            <button type="button" onclick="bukaModalReset('{{ route('import-export.reset-riwayat-kelulusan') }}', 'Riwayat Kelulusan')" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm transition-colors shadow-md shadow-rose-100 dark:shadow-none w-full justify-center mt-auto">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4.5 h-4.5">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                Hapus Semua Riwayat Kelulusan
            </button>
        </div>
    </div>

    @push('modals')
    <!-- ===================== MODAL DELETE CONFIRMATION ===================== -->
    <div id="modal-confirm-reset" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-reset-confirm" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 mb-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 id="modal-reset-title" class="text-base font-bold text-slate-900 dark:text-white mb-2">Hapus Seluruh Data</h3>
            <p id="modal-reset-desc" class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-4">
                Tindakan ini akan menghapus semua data secara permanen. Silakan ketik <span class="font-bold text-rose-500">HAPUS</span> untuk mengonfirmasi.
            </p>
            <form id="form-reset-data" action="" method="POST" class="space-y-4 text-left">
                @csrf
                @method('DELETE')
                <div>
                    <input type="text" id="input-konfirmasi-hapus" placeholder="Ketik HAPUS di sini" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-800 dark:text-slate-200 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors text-center font-bold tracking-widest" autocomplete="off" required>
                </div>
                <div class="flex justify-center gap-3 pt-2">
                    <button type="button" onclick="tutupModalReset()" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Batal</button>
                    <button type="submit" id="btn-submit-reset" disabled class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold text-xs transition-colors">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
    @endpush

@endsection

@section('scripts')
<script>
    function bukaModalReset(url, label) {
        const el = document.getElementById('modal-confirm-reset');
        if (el) {
            el.classList.remove('hidden');
            el.classList.add('flex');
            
            document.getElementById('modal-reset-title').textContent = 'Hapus Seluruh ' + label;
            document.getElementById('modal-reset-desc').innerHTML = 'Tindakan ini akan menghapus semua <strong>' + label + '</strong> beserta kaitannya secara permanen. Silakan ketik <span class="font-bold text-rose-500">HAPUS</span> untuk mengonfirmasi.';
            document.getElementById('form-reset-data').action = url;
            
            const input = document.getElementById('input-konfirmasi-hapus');
            input.value = '';
            document.getElementById('btn-submit-reset').disabled = true;
            setTimeout(() => {
                input.focus();
            }, 100);
        }
    }

    function tutupModalReset() {
        const el = document.getElementById('modal-confirm-reset');
        if (!el || el.classList.contains('hidden')) return;
        
        // Tambahkan class animasi penutupan
        el.classList.add('modal-closing');
        
        // Tunggu animasi selesai (180ms) baru benar-benar disembunyikan
        setTimeout(() => {
            el.classList.add('hidden');
            el.classList.remove('flex');
            el.classList.remove('modal-closing');
        }, 180);
    }

    const inputKonfirmasi = document.getElementById('input-konfirmasi-hapus');
    const btnSubmitReset = document.getElementById('btn-submit-reset');
    
    if (inputKonfirmasi) {
        inputKonfirmasi.addEventListener('input', function() {
            if (this.value === 'HAPUS') {
                btnSubmitReset.disabled = false;
            } else {
                btnSubmitReset.disabled = true;
            }
        });
    }

    const backdropResetConfirm = document.getElementById('backdrop-reset-confirm');
    if (backdropResetConfirm) {
        backdropResetConfirm.addEventListener('click', tutupModalReset);
    }
    
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            tutupModalReset();
        }
    });
</script>
@endsection
