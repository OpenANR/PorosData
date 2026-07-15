<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Dashboard E-Jurnal Guru - SD Negeri 01 Poros Data.">
    <title>@yield('title', 'E-Journal') - SD Negeri 01 Poros Data</title>

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
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-bold shadow-md shadow-blue-200 dark:shadow-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold text-lg leading-tight block bg-gradient-to-r from-blue-600 to-indigo-500 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-300">E-Journal</span>
                        <span class="text-[10px] text-slate-400 font-semibold block uppercase">SDN 01 Poros Data</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1.5 flex-1">
                    @if(in_array($ejournalUser->role, ['guru', 'wali_kelas']))
                        <a href="{{ route('ejournal.guru.isi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('ejournal.guru.isi') ? 'bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                            Isi Jurnal Baru
                        </a>

                        <a href="{{ route('ejournal.guru.riwayat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('ejournal.guru.riwayat') ? 'bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            Riwayat Jurnal
                        </a>
                    @endif

                    @if(in_array($ejournalUser->role, ['admin', 'superadmin']))
                        <a href="{{ route('ejournal.admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('ejournal.admin.index') ? 'bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            Data Jurnal Masuk
                        </a>

                        <a href="{{ route('ejournal.admin.guru') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('ejournal.admin.guru') ? 'bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            Kelola Guru
                        </a>

                        <a href="{{ route('ejournal.admin.siswa') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('ejournal.admin.siswa') ? 'bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.052 20.3a11.386 11.386 0 0 1-4.953-1.063v-.109m10.003-3.07a9.383 9.383 0 0 0-4.122-3.765 4.125 4.125 0 0 0-7.38 2.85c0 1.91 1.254 3.527 2.99 4.09l-.014.072m1.226-7.9L10.05 9.03l2.678-2.03m-2.678 2.03-2.678-2.03m2.678 2.03V3.75" />
                            </svg>
                            Kelola Siswa
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Footer Sidebar / Account Info -->
            <div class="p-6 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-sm shadow-sm">
                        {{ strtoupper(substr($ejournalUser->name ?? 'GU', 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-xs font-semibold truncate text-slate-800 dark:text-slate-200">{{ $ejournalUser->name ?? 'Guru' }}</span>
                        <span class="block text-[10px] text-slate-400 font-medium capitalize">{{ str_replace('_', ' ', $ejournalUser->role ?? 'guru') }}</span>
                    </div>
                </div>

                <form action="{{ route('ejournal.logout') }}" method="POST" class="w-full">
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
                    <h2 class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider hidden md:block">
                        @yield('subtitle', 'SD Negeri 01 Poros Data')
                    </h2>
                </div>

                <!-- Utilities (Dark Mode Toggle) -->
                <div class="flex items-center gap-3">
                    <!-- Dark Mode Toggle Button -->
                    <button id="theme-toggle" class="p-2.5 rounded-xl border border-slate-200/80 dark:border-slate-800/80 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-white/50 dark:hover:bg-slate-900/50 focus:outline-none transition-all shadow-sm cursor-pointer">
                        <svg id="theme-toggle-light-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21M4.22 4.22l1.636 1.636m12.296 12.296l1.636 1.636M3 12h2.25m13.5 0H21M5.858 18.142l1.636-1.636m12.296-12.296l1.636-1.636M12 7.5a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9Z" />
                        </svg>
                        <svg id="theme-toggle-dark-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 md:p-8">
                @yield('content')
            </main>
        </div>
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

    <!-- Base Scripts for Toggle and Sidebar -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar toggle for mobile
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            if (sidebarToggle && sidebar && sidebarOverlay) {
                const toggleSidebar = () => {
                    sidebar.classList.toggle('-translate-x-full');
                    sidebarOverlay.classList.toggle('hidden');
                };

                sidebarToggle.addEventListener('click', toggleSidebar);
                sidebarOverlay.addEventListener('click', toggleSidebar);
            }

            // Theme toggle script
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

                    if (localStorage.getItem('theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
