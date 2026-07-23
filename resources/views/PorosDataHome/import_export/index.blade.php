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
    </div>
@endsection
