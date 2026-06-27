@extends('PorosDataHome.layouts.app')

@section('title', 'Portal PKL')

@section('content')
    <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-8 sm:p-10 transition-all duration-300">
        <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-bold shadow-md shadow-indigo-200 dark:shadow-none mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .621-.504 1.125-1.125 1.125H4.875A1.125 1.125 0 0 1 3.75 19.4v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.453.254-.718.254H4.875a1.03 1.03 0 0 1-.718-.254m16.5-3.658v-.294a2.238 2.238 0 0 0-2.25-2.25h-1.5a2.238 2.238 0 0 0-2.25 2.25v.294m3.5-2.285a4.9 4.9 0 0 1-3.036-1.508m0 0a4.9 4.9 0 0 1-3.036 1.508m0 0a4.9 4.9 0 0 0-3.036-1.508m0 0a4.9 4.9 0 0 0-3.036 1.508m0 0a4.9 4.9 0 0 0-3.036-1.508m0 0a4.9 4.9 0 0 0-3.036-1.508m0 0A4.9 4.9 0 0 0 4.686 6.03M11.235 9.538v-.294a2.238 2.238 0 0 0-2.25-2.25h-1.5a2.238 2.238 0 0 0-2.25 2.25v.294m-3.5-2.285a4.9 4.9 0 0 1 3.036-1.508M12 12.75a2.25 2.25 0 1 1 0-4.5 2.25 2.25 0 0 1 0 4.5Z" />
            </svg>
        </div>
        <h1 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-600 to-violet-500 bg-clip-text text-transparent dark:from-indigo-400 dark:to-violet-300">
            Halaman Portal PKL
        </h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm leading-relaxed">
            Selamat datang di modul Portal PKL (Praktik Kerja Lapangan). Modul ini digunakan untuk memantau, mendata, dan menilai kegiatan praktik kerja lapangan.
        </p>
    </div>
@endsection