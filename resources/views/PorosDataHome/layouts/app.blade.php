<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Aplikasi CRUD Pengelolaan Data Siswa dan Guru Sekolah SD PorosData.">
    <title>@yield('title', 'PorosData') - Portal Sekolah SD</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Inline script to apply dark mode before page render to avoid flash -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
        .glass-panel {
            background-color: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .dark .glass-panel {
            background-color: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="min-h-full bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased transition-colors duration-300">

    <div class="min-h-full flex flex-col md:flex-row">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed md:sticky top-0 left-0 z-40 w-64 h-screen -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-slate-200/80 dark:border-slate-800/80 bg-white dark:bg-slate-900 flex flex-col justify-between shrink-0">
            <div class="px-6 py-5 flex-1 flex flex-col overflow-y-auto">
                <!-- Logo / Header -->
                <div class="flex items-center gap-3 mb-8">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-bold shadow-md shadow-indigo-200 dark:shadow-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold text-lg leading-tight block bg-gradient-to-r from-indigo-600 to-violet-500 bg-clip-text text-transparent dark:from-indigo-400 dark:to-violet-300">PorosData</span>
                        <span class="text-xs text-slate-400 font-medium">Elementary Admin</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1.5 flex-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('kelas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('kelas.*') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                        </svg>
                        Kelola Kelas
                    </a>

                    <a href="{{ route('walikelas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('walikelas.*') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
                        </svg>
                        Kelola Wali Kelas
                    </a>

                    <a href="{{ route('guru.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('guru.*') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Kelola Guru
                    </a>

                    <a href="{{ route('siswa.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('siswa.*') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.052 20.3a11.386 11.386 0 0 1-4.953-1.063v-.109m10.003-3.07a9.383 9.383 0 0 0-4.122-3.765 4.125 4.125 0 0 0-7.38 2.85c0 1.91 1.254 3.527 2.99 4.09l-.014.072m1.226-7.9L10.05 9.03l2.678-2.03m-2.678 2.03-2.678-2.03m2.678 2.03V3.75" />
                        </svg>
                        Kelola Siswa
                    </a>

                    <a href="{{ route('persetujuan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('persetujuan.*') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12z" />
                        </svg>
                        Status Persetujuan
                    </a>

                    <a href="{{ route('mapel.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('mapel.*') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                        Kelola Mapel
                    </a>

                    <a href="{{ route('admin_users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin_users.*') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.09 9.09 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        Kelola Admin
                    </a>
                </nav>
            </div>

            <!-- Footer Sidebar / Account Info -->
            <div class="p-6 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-4">
                @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin'))
                <!-- Apps Menu Dropdown Button -->
                <div class="relative">
                    <button id="apps-menu-button" type="button" class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200 border border-slate-100 dark:border-slate-800/40 hover:border-slate-200 dark:hover:border-slate-700/60 transition-all cursor-pointer">
                        <span class="flex items-center gap-2.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-indigo-600 dark:text-indigo-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25v2.25a2.25 2.25 0 0 1-2.25 2.25h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-1.8 1.8h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                            </svg>
                            Menu Aplikasi
                        </span>
                        <svg id="apps-menu-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3 text-slate-400 dark:text-slate-500 transition-transform duration-200">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                        </svg>
                    </button>

                    <!-- Popup Content -->
                    <div id="apps-menu-dropdown" class="absolute left-0 right-0 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-xl p-2 hidden z-50 flex flex-col gap-1" style="bottom: 100%; margin-bottom: 0.75rem; transform-origin: bottom; transition: all 0.2s ease-in-out; transform: scale(0.95); opacity: 0;">
                        <div class="px-3 py-1.5 text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider border-b border-slate-100 dark:border-slate-800/60 mb-1">
                            Pilihan Aplikasi
                        </div>
                        <a href="{{ route('datasiswa.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-slate-400 dark:text-slate-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.052 20.3a11.386 11.386 0 0 1-4.953-1.063v-.109m10.003-3.07a9.383 9.383 0 0 0-4.122-3.765 4.125 4.125 0 0 0-7.38 2.85c0 1.91 1.254 3.527 2.99 4.09l-.014.072m1.226-7.9L10.05 9.03l2.678-2.03m-2.678 2.03-2.678-2.03m2.678 2.03V3.75" />
                            </svg>
                            Data Siswa
                        </a>
                        <a href="{{ route('ejournal.index') }}" target="_blank" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-slate-400 dark:text-slate-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            E-Journal
                        </a>
                        <a href="{{ route('portalnilai.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-slate-400 dark:text-slate-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
                            </svg>
                            Portal Nilai
                        </a>
                        <a href="{{ route('portalpkl.dashboard') }}" target="_blank" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-slate-400 dark:text-slate-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .621-.504 1.125-1.125 1.125H4.875A1.125 1.125 0 0 1 3.75 19.4v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.453.254-.718.254H4.875a1.03 1.03 0 0 1-.718-.254m16.5-3.658v-.294a2.238 2.238 0 0 0-2.25-2.25h-1.5a2.238 2.238 0 0 0-2.25 2.25v.294m3.5-2.285a4.9 4.9 0 0 1-3.036-1.508m0 0a4.9 4.9 0 0 1-3.036 1.508m0 0a4.9 4.9 0 0 0-3.036-1.508m0 0a4.9 4.9 0 0 0-3.036 1.508m0 0a4.9 4.9 0 0 0-3.036-1.508m0 0A4.9 4.9 0 0 0 4.686 6.03m6.549 3.508v-.294a2.238 2.238 0 0 0-2.25-2.25h-1.5a2.238 2.238 0 0 0-2.25 2.25v.294m-3.5-2.285a4.9 4.9 0 0 1 3.036-1.508M12 12.75a2.25 2.25 0 1 1 0-4.5 2.25 2.25 0 0 1 0 4.5Z" />
                            </svg>
                            Portal PKL
                        </a>
                        <a href="{{ route('portalsiswa.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-slate-400 dark:text-slate-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm-1.221 4.702c-.903-.112-1.807-.112-2.71 0a48.11 48.11 0 0 0-1.075.191c-.48.096-.827.514-.827 1.002v.294c0 .548.407.98 1.034 1.018a18.785 18.785 0 0 0 4.41 0c.627-.038 1.034-.47 1.034-1.018v-.294c0-.488-.347-.906-.827-1.002a48.48 48.48 0 0 0-1.075-.191Z" />
                            </svg>
                            Portal Siswa
                        </a>
                    </div>
                </div>
                @endif

                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-sm shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-xs font-semibold truncate text-slate-800 dark:text-slate-200">{{ Auth::user()->name ?? 'Administrator' }}</span>
                        <span class="block text-[10px] text-slate-400 font-medium capitalize">{{ Auth::user()->role ?? 'Admin' }}</span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-rose-600 dark:text-rose-400 bg-rose-50/50 dark:bg-rose-950/20 hover:bg-rose-50 dark:hover:bg-rose-950/40 border border-rose-100 dark:border-rose-950/30 hover:border-rose-200 dark:hover:border-rose-900/50 active:scale-[0.98] transition-all cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Sidebar Overlay (mobile) -->
        <div id="sidebar-overlay" class="fixed inset-0 z-30 bg-slate-900/50 hidden md:hidden"></div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 min-h-screen">
            <!-- Top Header -->
            <header class="glass-panel sticky top-0 z-30 border-b border-slate-200/80 dark:border-slate-800/80 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <!-- Hamburger Toggle Button (mobile only) -->
                    <button id="sidebar-toggle" class="p-2 -ml-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-slate-200 md:hidden focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    <!-- Navigation Breadcrumbs -->
                    <div class="text-sm font-bold text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        <span class="text-slate-400 dark:text-slate-500 font-medium">PorosData</span>
                        <span class="text-slate-300 dark:text-slate-700 font-medium">/</span>
                        <span>@yield('title', 'Dashboard')</span>
                    </div>
                </div>

                <!-- Utilities (Search / Dark Mode Toggle) -->
                <div class="flex items-center gap-3">
                    <!-- Dark Mode Toggle Button -->
                    <button id="theme-toggle" class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-100/50 dark:hover:bg-slate-800/50 focus:outline-none transition-all">
                        <!-- Sun Icon (visible in dark mode) -->
                        <svg id="theme-toggle-light-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21M4.22 4.22l1.636 1.636m12.296 12.296l1.636 1.636M3 12h2.25m13.5 0H21M5.858 18.142l1.636-1.636m12.296-12.296l1.636-1.636M12 7.5a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9Z" />
                        </svg>
                        <!-- Moon Icon (visible in light mode) -->
                        <svg id="theme-toggle-dark-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Main Workspace Container -->
            <main class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Toast Notifications -->
    @if (session('success') || session('error'))
        <div id="toast" class="fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl border transition-all duration-300 translate-x-12 opacity-0 {{ session('success') ? 'bg-emerald-50/95 dark:bg-emerald-950/90 text-emerald-800 dark:text-emerald-200 border-emerald-200 dark:border-emerald-900/40' : 'bg-rose-50/95 dark:bg-rose-950/90 text-rose-800 dark:text-rose-200 border-rose-200 dark:border-rose-900/40' }}">
            @if (session('success'))
                <div class="h-8 w-8 rounded-xl bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            @else
                <div class="h-8 w-8 rounded-xl bg-rose-100 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            @endif
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toast = document.getElementById('toast');
                if (toast) {
                    // Slide in
                    setTimeout(() => {
                        toast.classList.remove('translate-x-12', 'opacity-0');
                    }, 100);

                    // Slide out
                    setTimeout(() => {
                        toast.classList.add('translate-x-12', 'opacity-0');
                    }, 4000);
                }
            });
        </script>
    @endif

    <!-- General Application Script (Sidebar & Theme Toggling) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar Toggle
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            if (sidebarToggle && sidebar && sidebarOverlay) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('-translate-x-full');
                    sidebarOverlay.classList.toggle('hidden');
                });

                sidebarOverlay.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                });
            }

            // Theme Toggle
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');

            // Change icon status on load
            if (document.documentElement.classList.contains('dark')) {
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleDarkIcon.classList.add('hidden');
            } else {
                themeToggleLightIcon.classList.add('hidden');
                themeToggleDarkIcon.classList.remove('hidden');
            }

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', () => {
                    // toggle icons inside button
                    themeToggleLightIcon.classList.toggle('hidden');
                    themeToggleDarkIcon.classList.toggle('hidden');

                    // if set via local storage previously
                    if (localStorage.getItem('theme')) {
                        if (localStorage.getItem('theme') === 'light') {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('theme', 'dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('theme', 'light');
                        }
                    } else {
                        // if not set via local storage previously
                        if (document.documentElement.classList.contains('dark')) {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('theme', 'light');
                        } else {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('theme', 'dark');
                        }
                    }
                });
            }

            // Apps Menu Dropdown Toggle
            const appsMenuButton = document.getElementById('apps-menu-button');
            const appsMenuDropdown = document.getElementById('apps-menu-dropdown');
            const appsMenuArrow = document.getElementById('apps-menu-arrow');

            if (appsMenuButton && appsMenuDropdown) {
                appsMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isHidden = appsMenuDropdown.classList.contains('hidden');
                    
                    if (isHidden) {
                        appsMenuDropdown.classList.remove('hidden');
                        setTimeout(() => {
                            appsMenuDropdown.style.transform = 'scale(1)';
                            appsMenuDropdown.style.opacity = '1';
                        }, 10);
                        if (appsMenuArrow) appsMenuArrow.classList.add('rotate-180');
                    } else {
                        appsMenuDropdown.style.transform = 'scale(0.95)';
                        appsMenuDropdown.style.opacity = '0';
                        setTimeout(() => {
                            appsMenuDropdown.classList.add('hidden');
                        }, 200);
                        if (appsMenuArrow) appsMenuArrow.classList.remove('rotate-180');
                    }
                });

                document.addEventListener('click', (e) => {
                    if (!appsMenuDropdown.contains(e.target) && !appsMenuButton.contains(e.target)) {
                        appsMenuDropdown.style.transform = 'scale(0.95)';
                        appsMenuDropdown.style.opacity = '0';
                        setTimeout(() => {
                            appsMenuDropdown.classList.add('hidden');
                        }, 200);
                        if (appsMenuArrow) appsMenuArrow.classList.remove('rotate-180');
                    }
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
