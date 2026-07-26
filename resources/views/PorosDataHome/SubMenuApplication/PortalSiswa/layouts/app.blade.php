<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Portal Siswa - Poros Data.">
    <title>@yield('title', 'Portal Siswa') - Poros Data</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
<body class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased transition-colors duration-300 flex flex-col">

    <!-- Header Navigation -->
    <header class="glass-panel sticky top-0 z-30 border-b border-slate-200/80 dark:border-slate-800/80 px-6 py-4 flex items-center justify-between">
        <div class="max-w-7xl w-full mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                @if(isset($instansi_app) && $instansi_app->logo)
                    <div class="h-10 w-10 rounded-xl overflow-hidden shadow-md shadow-slate-200 dark:shadow-none bg-white flex shrink-0">
                        <img src="{{ Storage::url($instansi_app->logo) }}" alt="Logo" class="w-full h-full object-contain p-1">
                    </div>
                @else
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-bold shadow-md shadow-indigo-200 dark:shadow-none shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm-1.221 4.702c-.903-.112-1.807-.112-2.71 0a48.11 48.11 0 0 0-1.075.191c-.48.096-.827.514-.827 1.002v.294c0 .548.407.98 1.034 1.018a18.785 18.785 0 0 0 4.41 0c.627-.038 1.034-.47 1.034-1.018v-.294c0-.488-.347-.906-.827-1.002a48.48 48.48 0 0 0-1.075-.191Z" />
                        </svg>
                    </div>
                @endif
                <div>
                    <span class="font-bold text-lg leading-tight block mb-1 bg-gradient-to-r from-indigo-600 to-violet-500 bg-clip-text text-transparent dark:from-indigo-400 dark:to-violet-300">Portal Siswa</span>
                    <span class="text-xs text-slate-400 font-medium">{{ isset($instansi_app) && $instansi_app->nama_sekolah ? $instansi_app->nama_sekolah : 'School Name' }}</span>
                </div>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-4">
                <!-- Theme Toggle -->
                <button id="theme-toggle-header" class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-100/50 dark:hover:bg-slate-800/50 focus:outline-none transition-all cursor-pointer">
                    <!-- Sun Icon (visible in dark mode) -->
                    <svg id="theme-toggle-light-icon-header" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21M4.22 4.22l1.636 1.636m12.296 12.296l1.636 1.636M3 12h2.25m13.5 0H21M5.858 18.142l1.636-1.636m12.296-12.296l1.636-1.636M12 7.5a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9Z" />
                    </svg>
                    <!-- Moon Icon (visible in light mode) -->
                    <svg id="theme-toggle-dark-icon-header" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>
                </button>

                @if(isset($portalsiswaUser))
                    <!-- User Info & Logout Dropdown -->
                    <div class="h-px w-6 bg-slate-200 dark:bg-slate-800"></div>
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:block text-right">
                            <span class="block text-xs font-semibold text-slate-850 dark:text-slate-200">{{ $portalsiswaUser->name }}</span>
                            <span class="block text-[10px] text-slate-400 font-medium">NISN: {{ $portalsiswaUser->siswa->nisn ?? '-' }}</span>
                        </div>
                        <form action="{{ route('portalsiswa.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2.5 rounded-xl border border-rose-200/50 dark:border-rose-950/50 text-rose-600 dark:text-rose-450 hover:bg-rose-50 dark:hover:bg-rose-950/20 active:scale-[0.98] transition-all cursor-pointer" title="Keluar">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto animate-fade-in">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-6 border-t border-slate-200/80 dark:border-slate-800/80 text-center text-xs text-slate-400 dark:text-slate-500">
        <p>&copy; 2026 Poros Data - Student Identity Portal. All Rights Reserved.</p>
    </footer>

    <!-- Toast Notifications -->
    @if (session('success') || session('error'))
        <div id="toast" class="fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl border transition-all duration-300 translate-x-12 opacity-0 {{ session('success') ? 'bg-emerald-50/95 dark:bg-emerald-950/90 text-emerald-800 dark:text-emerald-200 border-emerald-200 dark:border-emerald-900/40' : 'bg-rose-50/95 dark:bg-rose-950/90 text-rose-800 dark:text-rose-200 border-rose-200 dark:border-rose-900/40' }}">
            @if (session('success'))
                <div class="h-8 w-8 rounded-xl bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            @else
                <div class="h-8 w-8 rounded-xl bg-rose-100 dark:bg-rose-950/40 text-rose-600 dark:text-rose-450 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            @endif
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Dark Mode Toggle
            const themeToggleBtn = document.getElementById('theme-toggle-header');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon-header');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon-header');

            if (themeToggleBtn && themeToggleLightIcon && themeToggleDarkIcon) {
                const applyThemeIcons = () => {
                    if (document.documentElement.classList.contains('dark')) {
                        themeToggleLightIcon.classList.remove('hidden');
                        themeToggleDarkIcon.classList.add('hidden');
                    } else {
                        themeToggleLightIcon.classList.add('hidden');
                        themeToggleDarkIcon.classList.remove('hidden');
                    }
                };

                applyThemeIcons();

                themeToggleBtn.addEventListener('click', () => {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    }
                    applyThemeIcons();
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
