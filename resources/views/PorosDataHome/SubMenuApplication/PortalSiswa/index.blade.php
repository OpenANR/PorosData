@extends('PorosDataHome.layouts.app')

@section('title', 'Portal Siswa')

@section('content')
    <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-8 sm:p-10 transition-all duration-300">
        <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-bold shadow-md shadow-indigo-200 dark:shadow-none mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm-1.221 4.702c-.903-.112-1.807-.112-2.71 0a48.11 48.11 0 0 0-1.075.191c-.48.096-.827.514-.827 1.002v.294c0 .548.407.98 1.034 1.018a18.785 18.785 0 0 0 4.41 0c.627-.038 1.034-.47 1.034-1.018v-.294c0-.488-.347-.906-.827-1.002a48.48 48.48 0 0 0-1.075-.191Z" />
            </svg>
        </div>
        <h1 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-600 to-violet-500 bg-clip-text text-transparent dark:from-indigo-400 dark:to-violet-300">
            Halaman Portal Siswa
        </h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm leading-relaxed">
            Selamat datang di modul Portal Siswa. Modul ini merupakan gerbang akses mandiri bagi siswa untuk melihat data akademik, absensi, dan profil mereka.
        </p>
    </div>
@endsection