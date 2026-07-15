<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Portal PKL - Praktik Kerja Lapangan.">
    <title>@yield('title', 'Portal PKL') - PorosData</title>

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
<body class="min-h-full bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased transition-colors duration-300">

    <div class="min-h-full flex flex-col md:flex-row">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed md:sticky top-0 left-0 z-40 w-64 h-screen -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-slate-200/80 dark:border-slate-800/80 bg-white dark:bg-slate-900 flex flex-col justify-between shrink-0">
            <div class="px-6 py-5 flex-1 flex flex-col overflow-y-auto no-scrollbar">
                <!-- Logo / Header -->
                <div class="flex items-center gap-3 mb-8">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-orange-600 to-amber-500 flex items-center justify-center text-white font-bold shadow-md shadow-orange-200 dark:shadow-none">
                        <i class="fa-solid fa-briefcase text-lg"></i>
                    </div>
                    <div>
                        <span class="font-bold text-lg leading-tight block bg-gradient-to-r from-orange-600 to-amber-500 bg-clip-text text-transparent dark:from-orange-400 dark:to-amber-300">Portal PKL</span>
                        <span class="text-[9px] text-slate-400 font-semibold block uppercase tracking-wider">SMK Teknologi Balung</span>
                    </div>
                </div>

                <!-- Navigation Links based on role -->
                <nav class="space-y-1.5 flex-1">
                    <div class="px-3 py-1.5 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">
                        Menu Utama
                    </div>

                    @if($portalpklUser->role === 'superadmin')
                        <!-- Superadmin Links -->
                        <a href="{{ route('portalpkl.superadmin') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('portalpkl.superadmin') ? 'bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-circle-nodes text-base w-5 text-center"></i>
                            Dashboard Superadmin
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                            <i class="fa-solid fa-city text-base w-5 text-center"></i>
                            Kelola Instansi
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                            <i class="fa-solid fa-users-gear text-base w-5 text-center"></i>
                            Kelola Pengguna
                        </a>
                    @elseif($portalpklUser->role === 'admin')
                        <!-- Admin Links -->
                        <a href="{{ route('portalpkl.admin') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('portalpkl.admin') ? 'bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-chart-line text-base w-5 text-center"></i>
                            Dashboard Admin
                        </a>
                        <a href="{{ route('portalpkl.admin.mitra.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('portalpkl.admin.mitra.*') ? 'bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-building text-base w-5 text-center"></i>
                            Mitra DUDI
                        </a>
                        <a href="{{ route('portalpkl.admin.pembimbing.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('portalpkl.admin.pembimbing.*') ? 'bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-user-tie text-base w-5 text-center"></i>
                            Data Pembimbing
                        </a>
                        <a href="{{ route('portalpkl.admin.siswa.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('portalpkl.admin.siswa.*') ? 'bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-user-graduate text-base w-5 text-center"></i>
                            Siswa PKL
                        </a>
                        <a href="{{ route('portalpkl.admin.kehadiran') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('portalpkl.admin.kehadiran*') ? 'bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-calendar-check text-base w-5 text-center"></i>
                            Kehadiran Siswa
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                            <i class="fa-solid fa-book-bookmark text-base w-5 text-center"></i>
                            Laporan & Nilai
                        </a>
                    @elseif($portalpklUser->role === 'pembimbing')
                        <!-- Pembimbing Links -->
                        <a href="{{ route('portalpkl.pembimbing') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('portalpkl.pembimbing') ? 'bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-desktop text-base w-5 text-center"></i>
                            Dashboard Pembimbing
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                            <i class="fa-solid fa-graduation-cap text-base w-5 text-center"></i>
                            Bimbingan Siswa
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                            <i class="fa-solid fa-list-check text-base w-5 text-center"></i>
                            Monitoring & Presensi
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                            <i class="fa-solid fa-award text-base w-5 text-center"></i>
                            Penilaian PKL
                        </a>
                    @elseif($portalpklUser->role === 'siswa')
                        <!-- Siswa Links -->
                        <a href="{{ route('portalpkl.siswa') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('portalpkl.siswa') ? 'bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-house text-base w-5 text-center"></i>
                            Dashboard Siswa
                        </a>
                        <a href="{{ route('portalpkl.siswa.kehadiran') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('portalpkl.siswa.kehadiran*') ? 'bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-user-clock text-base w-5 text-center"></i>
                            Kehadiran PKL
                        </a>
                        <a href="{{ route('portalpkl.siswa.riwayat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('portalpkl.siswa.riwayat*') ? 'bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-clock-rotate-left text-base w-5 text-center"></i>
                            Riwayat Absensi
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Footer Sidebar / Account Info -->
            <div class="p-6 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 flex items-center justify-center font-bold text-sm shadow-sm">
                        {{ strtoupper(substr($portalpklUser->name ?? 'US', 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-xs font-semibold truncate text-slate-800 dark:text-slate-200">{{ $portalpklUser->name ?? 'User PKL' }}</span>
                        <span class="block text-[10px] text-slate-400 font-medium capitalize">{{ str_replace('_', ' ', $portalpklUser->role ?? 'Siswa') }}</span>
                    </div>
                </div>

                <form action="{{ route('portalpkl.logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-rose-600 dark:text-rose-400 bg-rose-50/50 dark:bg-rose-950/20 hover:bg-rose-50 dark:hover:bg-rose-950/40 border border-rose-100 dark:border-rose-950/30 hover:border-rose-200 dark:hover:border-rose-900/50 active:scale-[0.98] transition-all cursor-pointer">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Keluar Portal
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
                    <button id="sidebar-toggle" class="p-2 -ml-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-slate-200 md:hidden focus:outline-none cursor-pointer">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <h2 class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider hidden md:block">
                        @yield('subtitle', 'SMK Teknologi Balung')
                    </h2>
                </div>

                <!-- Utilities (Search / Dark Mode Toggle) -->
                <div class="flex items-center gap-3">
                    <!-- Dark Mode Toggle Button -->
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
                </div>
            </header>

            <!-- Main Workspace Container -->
            <main class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto animate-fade-in">
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

    <!-- Script toggle sidebar and theme switcher -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar Toggle
            const sidebar = document.getElementById('sidebar');
            const sidebarToggleBtn = document.getElementById('sidebar-toggle');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            if (sidebarToggleBtn && sidebar && sidebarOverlay) {
                const toggleSidebar = () => {
                    sidebar.classList.toggle('-translate-x-full');
                    sidebarOverlay.classList.toggle('hidden');
                };

                sidebarToggleBtn.addEventListener('click', toggleSidebar);
                sidebarOverlay.addEventListener('click', toggleSidebar);
            }

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
</body>
</html>
