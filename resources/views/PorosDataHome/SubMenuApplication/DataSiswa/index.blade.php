@extends('PorosDataHome.layouts.app')

@section('title', 'Data Siswa')

@section('content')
    <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-8 sm:p-10 transition-all duration-300">
        <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-bold shadow-md shadow-indigo-200 dark:shadow-none mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.052 20.3a11.386 11.386 0 0 1-4.953-1.063v-.109m10.003-3.07a9.383 9.383 0 0 0-4.122-3.765 4.125 4.125 0 0 0-7.38 2.85c0 1.91 1.254 3.527 2.99 4.09l-.014.072m1.226-7.9L10.05 9.03l2.678-2.03m-2.678 2.03-2.678-2.03m2.678 2.03V3.75" />
            </svg>
        </div>
        <h1 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-600 to-violet-500 bg-clip-text text-transparent dark:from-indigo-400 dark:to-violet-300">
            Halaman Data Siswa
        </h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm leading-relaxed">
            Selamat datang di modul Portal Aplikasi Data Siswa. Modul ini menyajikan informasi kesiswaan terpadu untuk administrasi sekolah SD PorosData.
        </p>
    </div>
@endsection