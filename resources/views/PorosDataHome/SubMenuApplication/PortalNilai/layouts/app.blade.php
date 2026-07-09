<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Penilaian - PorosData')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
            background-color: rgba(255, 255, 255, 0.90);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .dark .glass-panel {
            background-color: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .admin-readonly {
            background-color: #f1f5f9;
            color: #64748b;
            cursor: not-allowed;
        }
        .dark .admin-readonly {
            background-color: #1e293b;
            color: #475569;
        }
        .custom-scroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 4px;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.15);
            border-radius: 4px;
        }
        .dark .custom-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
        }
        .select-hide-arrow {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            text-align-last: center;
        }
        .loader {
            border: 2.5px solid rgba(255,255,255,0.2);
            border-radius: 50%;
            border-top: 2.5px solid currentColor;
            width: 16px;
            height: 16px;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { 
            0% { transform: rotate(0deg); } 
            100% { transform: rotate(360deg); } 
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(1.5rem);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Fix dark mode calendar picker indicator */
        .dark input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            filter: invert(1) brightness(0.9);
        }

        /* Ensure options in select dropdown are readable in both themes */
        select option {
            background-color: #ffffff !important;
            color: #0f172a !important;
        }
        .dark select option {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
        }

        /* Reset and enforce appearance for select dropdowns to prevent default browser arrow overlaps */
        select {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
        }

        /* Hide spin buttons for Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Hide spin buttons for Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased transition-colors duration-300">

    <!-- Toast Notifications -->
    <div id="toast-container" class="fixed top-6 right-6 flex flex-col items-end gap-3 pointer-events-none w-80 max-w-[calc(100vw-2rem)]" style="z-index: 999999;"></div>

    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed md:sticky top-0 left-0 z-40 w-64 h-screen -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-slate-200/80 dark:border-slate-800/80 bg-white dark:bg-slate-900 flex flex-col justify-between shrink-0">
            <div class="px-6 py-5 flex-1 flex flex-col overflow-y-auto">
                <!-- Logo / Header -->
                <div class="flex items-center gap-3 mb-8">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-bold shadow-md shadow-blue-200 dark:shadow-none">
                        <i class="fa-solid fa-graduation-cap text-lg"></i>
                    </div>
                    <div>
                        <span class="font-bold text-base leading-tight block bg-gradient-to-r from-blue-600 to-indigo-500 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-300">Portal Nilai</span>
                        <span class="text-[10px] text-slate-400 font-medium truncate block max-w-[150px]" id="sidebar-sekolah-nama">{{ ($portalnilaiUser && $portalnilaiUser->instansi) ? $portalnilaiUser->instansi->nama_sekolah : 'SD Negeri 01 Poros Data' }}</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1.5 flex-1">
                    @if($portalnilaiUser && (in_array($portalnilaiUser->role, ['admin', 'superadmin']) || $portalnilaiUser->id === 999999))
                        <!-- Nav Dashboard Admin -->
                        <a href="/porosdata/portalnilai/admin/dashboard" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ Request::is('*admin/dashboard') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-house w-5 text-center"></i>
                            <span>Dashboard</span>
                        </a>

                        <!-- Nav Input Nilai Admin -->
                        <a href="/porosdata/portalnilai/admin/inputnilai" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ Request::is('*admin/inputnilai') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-pen-to-square w-5 text-center"></i>
                            <span>Input Nilai</span>
                        </a>

                        <!-- Nav Pengaturan Jadwal Admin -->
                        <a href="/porosdata/portalnilai/admin/jadwal" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ Request::is('*admin/jadwal') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                            <span>Pengaturan Jadwal</span>
                        </a>
                    @elseif($portalnilaiUser && $portalnilaiUser->role === 'wali_kelas')
                        <!-- Nav Dashboard Wali -->
                        <a href="/porosdata/portalnilai/walikelas/dashboard" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ Request::is('*walikelas/dashboard') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-house w-5 text-center"></i>
                            <span>Dashboard</span>
                        </a>

                        <!-- Nav Pantau Nilai Wali -->
                        <a href="/porosdata/portalnilai/walikelas/viewnilai" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ Request::is('*walikelas/viewnilai') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-chart-line w-5 text-center"></i>
                            <span>Pantau Nilai</span>
                        </a>
                    @elseif($portalnilaiUser && $portalnilaiUser->role === 'guru')
                        <!-- Nav Dashboard Guru -->
                        <a href="/porosdata/portalnilai/guru/dashboard" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ Request::is('*guru/dashboard') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-house w-5 text-center"></i>
                            <span>Dashboard</span>
                        </a>

                        <!-- Nav Input Nilai Guru -->
                        <a href="/porosdata/portalnilai/guru/inputnilai" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ Request::is('*guru/inputnilai') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
                            <i class="fa-solid fa-pen-to-square w-5 text-center"></i>
                            <span>Input Nilai</span>
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Footer Sidebar / Account Info -->
            <div class="p-6 border-t border-slate-100 dark:border-slate-800/80 flex flex-col gap-4">
                <!-- Account Info -->
                <div class="flex items-center gap-3 pt-1">
                    <div class="h-9 w-9 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-sm shadow-sm">
                        {{ strtoupper(substr($portalnilaiUser->name ?? 'AD', 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-xs font-semibold truncate text-slate-800 dark:text-slate-200">{{ $portalnilaiUser->name ?? 'Administrator' }}</span>
                        <span class="block text-[10px] text-slate-400 font-medium capitalize">{{ str_replace('_', ' ', $portalnilaiUser->role ?? 'Admin') }}</span>
                    </div>
                </div>

                <!-- Logout Button -->
                <form action="{{ route('portalnilai.logout') }}" method="POST" class="w-full">
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
            <header class="glass-panel sticky top-0 z-30 border-b border-slate-200/80 dark:border-slate-800/80 px-6 py-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-4">
                    <!-- Hamburger Toggle Button (mobile only) -->
                    <button id="sidebar-toggle" class="p-2 -ml-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-slate-200 md:hidden focus:outline-none cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    <!-- Page Title / Path Indicator -->
                    <div class="text-sm font-bold text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        <span class="text-slate-400 dark:text-slate-500">Portal Nilai</span>
                        <span class="text-slate-300 dark:text-slate-700">/</span>
                        <span id="page-title-indicator">@yield('page_title', 'Dashboard')</span>
                    </div>
                </div>

                <!-- Utilities (Search / Dark Mode Toggle) -->
                <div class="flex items-center gap-3">
                    <!-- Dark Mode Toggle Button -->
                    <button id="theme-toggle" class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-100/50 dark:hover:bg-slate-800/50 focus:outline-none transition-all cursor-pointer">
                        <svg id="theme-toggle-light-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21M4.22 4.22l1.636 1.636m12.296 12.296l1.636 1.636M3 12h2.25m13.5 0H21M5.858 18.142l1.636-1.636m12.296-12.296l1.636-1.636M12 7.5a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9Z" />
                        </svg>
                        <svg id="theme-toggle-dark-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Main Workspace Container -->
            <main class="flex-grow p-4 md:p-6 flex flex-col gap-6 max-w-[1600px] w-full mx-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Script toggle theme and basic actions -->
    <script>
        let currentUser = "{{ $portalnilaiUser->name ?? 'Administrator Dummy' }}";
        let currentRole = "{{ $portalnilaiUser->role ?? 'admin' }}";
        
        // AJAX Helper Setup
        function ajaxPost(url, data) {
            return fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            }).then(r => r.json());
        }

        function ajaxGet(url) {
            return fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(r => r.json());
        }

        // Toast Helpers
        function showToast(message, type = "success") {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            
            let bgClass = 'bg-emerald-50/95 dark:bg-emerald-950/90 text-emerald-800 dark:text-emerald-200 border-emerald-200 dark:border-emerald-900/40';
            let icon = '<i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-sm shrink-0"></i>';
            
            if (type === "error") {
                icon = '<i class="fa-solid fa-circle-exclamation text-rose-600 dark:text-rose-400 text-sm shrink-0"></i>';
                bgClass = 'bg-rose-50/95 dark:bg-rose-950/90 text-rose-800 dark:text-rose-200 border-rose-200 dark:border-rose-900/40';
            } else if (type === "warning") {
                icon = '<i class="fa-solid fa-triangle-exclamation text-amber-600 dark:text-amber-400 text-sm shrink-0"></i>';
                bgClass = 'bg-amber-50/95 dark:bg-amber-950/90 text-amber-800 dark:text-amber-200 border-amber-200 dark:border-amber-900/40';
            }

            toast.className = `flex items-center gap-3 px-6 py-3.5 rounded-xl border text-sm font-semibold shadow-lg animate-slide-in pointer-events-auto transition-all duration-300 ${bgClass}`;
            toast.innerHTML = `
                ${icon}
                <span>${message}</span>
            `;

            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-x-10');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

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
    @yield('scripts')
</body>
</html>
