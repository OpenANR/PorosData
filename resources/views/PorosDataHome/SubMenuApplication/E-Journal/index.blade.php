<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Dashboard E-Jurnal Guru - SD Negeri 01 Poros Data.">
    <title>Dashboard E-Jurnal - SD Negeri 01 Poros Data</title>

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

        /* Content Entry Animation */
        @keyframes contentFadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .animate-content-fade-in {
            animation: contentFadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="min-h-full bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased transition-colors duration-300">

    <div class="min-h-screen flex flex-col">
        <!-- Top Navbar -->
        <header class="glass-panel sticky top-0 z-30 border-b border-slate-200/80 dark:border-slate-800/80 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-bold shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div>
                    <span class="font-bold text-lg leading-tight block bg-gradient-to-r from-blue-600 to-indigo-500 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-300">E-Journal</span>
                    <span class="text-xs text-slate-400 font-medium">SD Negeri 01 Poros Data</span>
                </div>
            </div>

            <!-- Header Utilities -->
            <div class="flex items-center gap-4">
                <!-- Theme Toggle Button -->
                <button id="theme-toggle" class="p-2 rounded-xl border border-slate-200/80 dark:border-slate-800/80 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-white/50 dark:hover:bg-slate-900/50 focus:outline-none transition-all shadow-sm">
                    <svg id="theme-toggle-light-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21M4.22 4.22l1.636 1.636m12.296 12.296l1.636 1.636M3 12h2.25m13.5 0H21M5.858 18.142l1.636-1.636m12.296-12.296l1.636-1.636M12 7.5a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9Z" />
                    </svg>
                    <svg id="theme-toggle-dark-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>
                </button>

                <!-- User Info and Logout -->
                <div class="h-px w-6 bg-slate-200 dark:bg-slate-800 rotate-90 hidden sm:block"></div>

                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-sm shadow-sm">
                        {{ strtoupper(substr($ejournalUser->name ?? 'GU', 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1 hidden md:block">
                        <span class="block text-xs font-semibold truncate text-slate-800 dark:text-slate-200">{{ $ejournalUser->name ?? 'Guru' }}</span>
                        <span class="block text-[10px] text-slate-400 font-medium capitalize">{{ str_replace('_', ' ', $ejournalUser->role ?? 'guru') }}</span>
                    </div>
                </div>

                <form action="{{ route('ejournal.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="flex items-center justify-center p-2 rounded-xl text-rose-600 dark:text-rose-400 bg-rose-50/50 dark:bg-rose-950/20 hover:bg-rose-50 dark:hover:bg-rose-950/40 border border-rose-100 dark:border-rose-950/30 hover:border-rose-200 dark:hover:border-rose-900/50 transition-all cursor-pointer" title="Keluar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 p-6 sm:p-8 max-w-5xl mx-auto w-full animate-content-fade-in">
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-8 sm:p-10 transition-all duration-300">
                <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-bold shadow-md shadow-blue-200 dark:shadow-none mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-blue-600 to-indigo-500 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-300">
                    Halaman E-Journal Guru
                </h1>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm leading-relaxed max-w-2xl">
                    Selamat datang di modul Aplikasi E-Journal. Modul ini digunakan untuk mengelola jurnal kelas dan aktivitas belajar mengajar harian.
                </p>

                <!-- User Profile Info Card -->
                <div class="mt-8 border-t border-slate-200 dark:border-slate-800 pt-6">
                    <h3 class="text-sm font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-4">
                        Informasi Akun Anda
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="p-5 bg-slate-100/50 dark:bg-slate-900/40 rounded-2xl border border-slate-200/50 dark:border-slate-800/40">
                            <span class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Nama Lengkap</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $ejournalUser->name }}</span>
                        </div>
                        <div class="p-5 bg-slate-100/50 dark:bg-slate-900/40 rounded-2xl border border-slate-200/50 dark:border-slate-800/40">
                            <span class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Kode DUK / Username</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">{{ $ejournalUser->duk ?? $ejournalUser->username }}</span>
                        </div>
                        <div class="p-5 bg-slate-100/50 dark:bg-slate-900/40 rounded-2xl border border-slate-200/50 dark:border-slate-800/40">
                            <span class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Peran (Role)</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1 capitalize">{{ str_replace('_', ' ', $ejournalUser->role) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Toast Notifications -->
    @if (session('success'))
        <div id="toast" class="fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl border bg-emerald-50/95 dark:bg-emerald-950/90 text-emerald-800 dark:text-emerald-200 border-emerald-200 dark:border-emerald-900/40 transition-all duration-300 translate-x-12 opacity-0">
            <div class="h-8 w-8 rounded-xl bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toast = document.getElementById('toast');
                if (toast) {
                    setTimeout(() => {
                        toast.classList.remove('translate-x-12', 'opacity-0');
                    }, 100);
                    setTimeout(() => {
                        toast.classList.add('translate-x-12', 'opacity-0');
                    }, 4000);
                }
            });
        </script>
    @endif

    <!-- Theme Switcher Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');

            if (document.documentElement.classList.contains('dark')) {
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleDarkIcon.classList.add('hidden');
            } else {
                themeToggleLightIcon.classList.add('hidden');
                themeToggleDarkIcon.classList.remove('hidden');
            }

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', () => {
                    themeToggleLightIcon.classList.toggle('hidden');
                    themeToggleDarkIcon.classList.toggle('hidden');

                    if (localStorage.getItem('theme')) {
                        if (localStorage.getItem('theme') === 'light') {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('theme', 'dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('theme', 'light');
                        }
                    } else {
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
        });
    </script>
</body>
</html>