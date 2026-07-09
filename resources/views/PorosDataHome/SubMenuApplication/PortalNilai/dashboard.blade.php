<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Portal Penilaian - PorosData</title>

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
                        <span class="text-[10px] text-slate-400 font-medium truncate block max-w-[150px]" id="sidebar-sekolah-nama">{{ ($user && $user->instansi) ? $user->instansi->nama_sekolah : 'SD Negeri 01 Poros Data' }}</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1.5 flex-1">
                    <!-- Nav Dashboard -->
                    <button onclick="switchTab('dashboard')" id="nav-dashboard" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 text-left cursor-pointer">
                        <i class="fa-solid fa-house w-5 text-center"></i>
                        <span>Dashboard</span>
                    </button>

                    <!-- Nav Input Nilai / Pantau Nilai -->
                    <button onclick="switchTab('input-nilai')" id="nav-input-nilai" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200 text-left cursor-pointer">
                        @if($user && $user->role === 'wali_kelas')
                            <i class="fa-solid fa-chart-line w-5 text-center"></i>
                            <span>Pantau Nilai</span>
                        @else
                            <i class="fa-solid fa-pen-to-square w-5 text-center"></i>
                            <span>Input Nilai</span>
                        @endif
                    </button>

                    <!-- Nav Pengaturan Jadwal (Admin Only) -->
                    @if(in_array($user->role ?? 'admin', ['admin', 'superadmin']) || ($user && $user->id === 999999))
                    <button onclick="switchTab('pengaturan-jadwal')" id="nav-pengaturan-jadwal" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200 text-left cursor-pointer">
                        <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                        <span>Pengaturan Jadwal</span>
                    </button>
                    @endif
                </nav>
            </div>

            <!-- Footer Sidebar / Account Info -->
            <div class="p-6 border-t border-slate-100 dark:border-slate-800/80 flex flex-col gap-4">
                <!-- Account Info -->
                <div class="flex items-center gap-3 pt-1">
                    <div class="h-9 w-9 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-sm shadow-sm">
                        {{ strtoupper(substr($user->name ?? 'AD', 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-xs font-semibold truncate text-slate-800 dark:text-slate-200">{{ $user->name ?? 'Administrator' }}</span>
                        <span class="block text-[10px] text-slate-400 font-medium capitalize">{{ str_replace('_', ' ', $user->role ?? 'Admin') }}</span>
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
                        <span id="page-title-indicator">Dashboard</span>
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
                
                <!-- ======================= VIEW: DASHBOARD ======================= -->
                <div id="tab-dashboard" class="flex flex-col gap-8">
                    <!-- Welcome Card -->
                    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-indigo-500 to-violet-500 text-white p-6 md:p-8 shadow-xl shadow-indigo-100 dark:shadow-none mb-2">
                        <div class="relative z-10 max-w-xl">
                            <h2 class="text-3xl font-extrabold tracking-tight mb-2">Selamat Datang di Portal Penilaian!</h2>
                            <p class="text-indigo-100 text-sm md:text-base leading-relaxed mb-4">Gunakan menu di sidebar kiri untuk mengakses fitur penginputan nilai siswa dan pengaturan jadwal akses pengisian nilai akhir.</p>
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white/10 text-xs font-semibold backdrop-blur-sm">
                                <i class="fa-solid fa-circle-user"></i>
                                <span>Peran: {{ str_replace('_', ' ', $user->role ?? 'Admin') }}</span>
                            </div>
                        </div>
                        <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-72 h-72">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
                            </svg>
                        </div>
                    </div>

                    <!-- Statistics Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-2">
                        <!-- Card 1: Kelas -->
                        <div class="glass-panel border border-slate-200/60 dark:border-slate-800/80 rounded-2xl p-6 shadow-sm flex items-center justify-between hover:shadow-lg hover:shadow-indigo-50/20 dark:hover:shadow-none hover:border-indigo-500/50 transition-all duration-300">
                            <div class="space-y-1">
                                <span class="block text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Jumlah Kelas</span>
                                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $classes->count() }}</h3>
                                <span class="text-xs font-medium text-slate-400 flex items-center gap-1">
                                    Kelas Terdaftar
                                </span>
                            </div>
                            <div class="h-14 w-14 rounded-2xl bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-school text-2xl"></i>
                            </div>
                        </div>

                        <!-- Card 2: Mapel -->
                        <div class="glass-panel border border-slate-200/60 dark:border-slate-800/80 rounded-2xl p-6 shadow-sm flex items-center justify-between hover:shadow-lg hover:shadow-blue-50/20 dark:hover:shadow-none hover:border-blue-500/50 transition-all duration-300">
                            <div class="space-y-1">
                                <span class="block text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Mata Pelajaran</span>
                                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $mapels->count() }}</h3>
                                <span class="text-xs font-medium text-slate-400 flex items-center gap-1">
                                    Mapel Aktif
                                </span>
                            </div>
                            <div class="h-14 w-14 rounded-2xl bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-book-open text-2xl"></i>
                            </div>
                        </div>

                        <!-- Card 3: Siswa -->
                        <div class="glass-panel border border-slate-200/60 dark:border-slate-800/80 rounded-2xl p-6 shadow-sm flex items-center justify-between hover:shadow-lg hover:shadow-emerald-50/20 dark:hover:shadow-none hover:border-emerald-500/50 transition-all duration-300">
                            <div class="space-y-1">
                                <span class="block text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Siswa Aktif</span>
                                <h3 class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $totalStudents }}</h3>
                                <span class="text-xs font-medium text-slate-400 flex items-center gap-1">
                                    Siswa Terdata
                                </span>
                            </div>
                            <div class="h-14 w-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-users text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Status Cards -->
                    @php
                        $now = now();
                        $isTugasOpen = $accessSettings ? ($now->greaterThanOrEqualTo($accessSettings->tugas_buka) && $now->lessThanOrEqualTo($accessSettings->tugas_tutup)) : true;
                        $isAsasOpen = $accessSettings ? ($now->greaterThanOrEqualTo($accessSettings->asas_buka) && $now->lessThanOrEqualTo($accessSettings->asas_tutup)) : true;
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tugas & ASTS Card -->
                        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-2xl p-6 shadow-sm flex flex-col gap-5 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800/60 pb-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 flex items-center justify-center text-base shadow-sm">
                                        <i class="fa-solid fa-file-pen"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm">Jadwal Tugas & ASTS</h4>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Pengisian nilai tugas & ujian tengah semester.</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $isTugasOpen ? 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/40' : 'bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-900/40' }}">
                                    {{ $isTugasOpen ? 'Terbuka' : 'Terkunci' }}
                                </span>
                            </div>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                                    <span>Waktu Buka:</span>
                                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $accessSettings ? date('d F Y, H:i', strtotime($accessSettings->tugas_buka)) : '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                                    <span>Waktu Tutup:</span>
                                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $accessSettings ? date('d F Y, H:i', strtotime($accessSettings->tugas_tutup)) : '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- ASAS Genap Card -->
                        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-2xl p-6 shadow-sm flex flex-col gap-5 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800/60 pb-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-base shadow-sm">
                                        <i class="fa-solid fa-award"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm">Jadwal ASAS GENAP</h4>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Pengisian nilai ujian akhir semester genap.</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $isAsasOpen ? 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/40' : 'bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-900/40' }}">
                                    {{ $isAsasOpen ? 'Terbuka' : 'Terkunci' }}
                                </span>
                            </div>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                                    <span>Waktu Buka:</span>
                                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $accessSettings ? date('d F Y, H:i', strtotime($accessSettings->asas_buka)) : '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                                    <span>Waktu Tutup:</span>
                                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $accessSettings ? date('d F Y, H:i', strtotime($accessSettings->asas_tutup)) : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ======================= VIEW: INPUT NILAI ======================= -->
                <div id="tab-input-nilai" class="hidden flex flex-col gap-6">
                    <!-- PANEL PEMILIHAN DATA (DINAMIS) -->
                    <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm flex flex-col md:flex-row gap-4 items-end shrink-0">
                        <div class="w-full @if($user && $user->role === 'wali_kelas') md:w-1/2 @else md:w-1/3 @endif space-y-1.5">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400">Pilih Kelas</label>
                            <div class="relative" style="position: relative;">
                                <select id="select-kelas" class="block w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:border-blue-500 transition-all focus:outline-none focus:ring-4 focus:ring-blue-500/10 appearance-none cursor-pointer">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($classes as $kelas)
                                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 flex items-center pointer-events-none text-slate-400" style="position: absolute; right: 16px;">
                                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                </div>
                            </div>
                        </div>
                        
                        @if($user && $user->role !== 'wali_kelas')
                        <div class="w-full md:w-1/3 space-y-1.5" id="mapel-container">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400">Pilih Mata Pelajaran</label>
                            <div class="relative" style="position: relative;">
                                <select id="select-mapel" class="block w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:border-blue-500 transition-all focus:outline-none focus:ring-4 focus:ring-blue-500/10 appearance-none cursor-pointer">
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    @foreach($mapels as $mapel)
                                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 flex items-center pointer-events-none text-slate-400" style="position: absolute; right: 16px;">
                                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="w-full @if($user && $user->role === 'wali_kelas') md:w-1/2 @else md:w-1/3 @endif space-y-1.5">
                            <label class="block text-xs font-bold text-transparent select-none">&nbsp;</label>
                            <button onclick="loadStudents()" id="btn-load" class="w-full bg-emerald-600 hover:bg-emerald-500 dark:bg-emerald-700 dark:hover:bg-emerald-600 text-white font-bold py-2.5 px-4 rounded-xl flex justify-center items-center gap-2 shadow-md shadow-emerald-500/15 dark:shadow-none hover:shadow-xl active:scale-[0.98] transition-all cursor-pointer text-xs">
                                <span>Tampilkan Data</span>
                                <div id="load-loader" class="loader hidden"></div>
                            </button>
                        </div>
                    </div>

                    <!-- ACCESS CLOSED ALERT -->
                    <div id="alert-akses-tutup" class="hidden bg-rose-50 dark:bg-rose-950/20 border-l-4 border-rose-500 text-rose-800 dark:text-rose-400 p-4 rounded-r-xl shadow-sm border border-slate-200/40 dark:border-slate-800/40" role="alert">
                        <p class="font-bold text-sm flex items-center gap-1.5"><i class="fa-solid fa-circle-xmark text-rose-500"></i> Akses Penilaian Ditutup!</p>
                        <p class="text-xs mt-1">Waktu pengisian nilai telah berakhir atau belum dimulai. Anda hanya dapat melihat data (Read Only).</p>
                    </div>

                    <!-- ======================= DATA TABLE CONTAINER ======================= -->
                    <div id="table-container" class="hidden flex-col flex-grow bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm animate-fade-in">
                        <!-- Wali Kelas Mode Banner -->
                        <div id="walikelas-banner" class="hidden bg-purple-50/50 dark:bg-purple-950/20 border-b border-slate-200/60 dark:border-slate-800/60 p-4 flex items-center gap-2.5 shrink-0">
                            <div class="h-8 w-8 rounded-lg bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-purple-800 dark:text-purple-400 text-xs">Dashboard Wali Kelas (Mode Pantau)</h3>
                                <p class="text-[10px] text-purple-600 dark:text-purple-500">Menampilkan nilai akhir siswa. Apabila kosong (-), artinya guru mapel belum menginput nilai.</p>
                            </div>
                        </div>
                        <!-- PG Analysis Mode Picker (Hide for Praktik) -->
                        <div id="asas-mode-container" class="bg-blue-50/50 dark:bg-blue-950/20 border-b border-slate-200/60 dark:border-slate-800/60 p-4 flex flex-col sm:flex-row justify-between items-center gap-4 shrink-0">
                            <div class="flex items-center gap-2.5">
                                <div class="h-8 w-8 rounded-lg bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                                    <i class="fa-solid fa-circle-info"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-blue-800 dark:text-blue-400 text-xs">Mode Analisis Pilihan Ganda (PG)</h3>
                                    <p class="text-[10px] text-blue-600 dark:text-blue-500">Pilih mode pengerjaan PG untuk seluruh siswa di kelas ini.</p>
                                </div>
                            </div>
                            <div class="relative" style="position: relative;">
                                <select id="global-asas-mode" onchange="recalculateAll()" class="pl-4 pr-10 py-2 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 font-bold text-xs text-blue-800 dark:text-blue-400 outline-none focus:ring-4 focus:ring-blue-500/10 cursor-pointer appearance-none">
                                    <option value="Benar">Tulis Benar</option>
                                    <option value="Salah">Tulis Salah</option>
                                    <option value="FastTrack">Fast Track (Ketik Jumlah Benar)</option>
                                </select>
                                <div class="absolute inset-y-0 flex items-center pointer-events-none text-blue-600 dark:text-blue-400" style="position: absolute; right: 14px;">
                                    <i class="fa-solid fa-chevron-down text-[9px]"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Scrollable Table -->
                        <div class="overflow-auto max-h-[55vh] custom-scroll relative flex-grow">
                            <table class="w-full text-xs text-left border-collapse">
                                <thead class="text-slate-500 dark:text-slate-400 uppercase">
                                    <tr id="tr-headers" class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                                        <!-- Injected dynamically -->
                                    </tr>
                                </thead>
                                <tbody id="table-body" class="divide-y divide-slate-100 dark:divide-slate-800/60">
                                    <!-- Injected dynamically -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Table Footer Control -->
                        <div class="bg-slate-50 dark:bg-slate-900 border-t border-slate-200/60 dark:border-slate-800/60 p-4 flex justify-end sticky left-0 bottom-0 z-30 shadow-inner shrink-0">
                            <button onclick="saveGrades()" id="btn-save" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 dark:bg-blue-700 dark:hover:bg-blue-600 text-white font-bold text-xs shadow-md shadow-blue-500/15 dark:shadow-none hover:shadow-xl active:scale-[0.98] transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <i class="fa-regular fa-floppy-disk"></i>
                                <span>Simpan Seluruh Nilai</span>
                                <div id="save-loader" class="loader hidden"></div>
                            </button>
                        </div>
                    </div>

                    <!-- INFO CARD PENJELASAN KOLOM -->
                    <div id="info-card-container" class="hidden glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm max-w-md w-full mt-4 flex flex-col gap-3.5">
                        <div class="flex items-center gap-2.5 border-b border-slate-100 dark:border-slate-800/60" style="padding-bottom: 14px; margin-bottom: 16px;">
                            <div class="h-7 w-7 rounded-lg bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>
                            <h4 class="font-bold text-slate-800 dark:text-slate-200 text-xs">Petunjuk Penilaian</h4>
                        </div>
                        <div class="space-y-3.5 leading-relaxed">
                            <div>
                                <span class="font-bold text-rose-500 text-[11px] block mb-0.5">* Tugas 1, Tugas 2 & ASTS</span>
                                <span class="block pl-2 border-l border-slate-200 dark:border-slate-700 text-[10px] text-slate-500 dark:text-slate-400">Diambil secara otomatis dari sistem akademik pusat.</span>
                            </div>
                            <div id="info-pg-detail">
                                <span class="font-bold text-blue-600 dark:text-blue-400 text-[11px] block mb-0.5">* Input PG ASAS GENAP</span>
                                <span class="block pl-2 border-l border-slate-200 dark:border-slate-700 text-[10px] text-slate-500 dark:text-slate-400">Ketik jumlah benar (0-25) atau gunakan mode tulis untuk analisis praktis.</span>
                            </div>
                            <div id="info-essai-detail">
                                <span class="font-bold text-indigo-600 dark:text-indigo-400 text-[11px] block mb-0.5">* Skor Pilihan Ujian Essai</span>
                                <span class="block pl-2 border-l border-slate-200 dark:border-slate-700 text-[10px] text-slate-500 dark:text-slate-400">Skor yang tersedia: <strong class="text-slate-700 dark:text-slate-300">8</strong> (Benar), <strong class="text-slate-700 dark:text-slate-300">4</strong> (Sebagian), <strong class="text-slate-700 dark:text-slate-300">2</strong> (Ongkos), atau <strong class="text-slate-700 dark:text-slate-300">0</strong> (Salah/Kosong).</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ======================= VIEW: PENGATURAN JADWAL ======================= -->
                @if(in_array($user->role ?? 'admin', ['admin', 'superadmin']) || ($user && $user->id === 999999))
                <div id="tab-pengaturan-jadwal" class="hidden flex flex-col gap-6 animate-fade-in">
                    <div id="admin-panel" class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm flex flex-col gap-4">
                        <div class="flex items-center border-b border-slate-100 dark:border-slate-800/60 pb-3 gap-3">
                            <div class="h-9 w-9 rounded-lg bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm shadow-sm">
                                <i class="fa-solid fa-sliders"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 dark:text-slate-100 text-sm">Pengaturan Akses Penilaian</h3>
                                <p class="text-[10px] text-slate-400 dark:text-slate-500">Atur rentang waktu kapan guru bisa menginput dan menyimpan nilai.</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-amber-600 dark:text-amber-400">Buka Edit Tugas & ASTS</label>
                                <input type="datetime-local" id="admin-tugas-buka" class="w-full px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-amber-600 dark:text-amber-400">Tutup Edit Tugas & ASTS</label>
                                <input type="datetime-local" id="admin-tugas-tutup" class="w-full px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-1">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-blue-600 dark:text-blue-400">Buka Edit ASAS GENAP</label>
                                <input type="datetime-local" id="admin-waktu-buka" class="w-full px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-blue-600 dark:text-blue-400">Tutup Edit ASAS GENAP</label>
                                <input type="datetime-local" id="admin-waktu-tutup" class="w-full px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            </div>
                        </div>

                        <div class="flex justify-end mt-2">
                            <button onclick="saveAdminSettings()" id="btn-save-settings" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 dark:bg-blue-700 dark:hover:bg-blue-600 text-white font-bold text-xs shadow-md shadow-blue-500/15 dark:shadow-none hover:shadow-xl hover:shadow-blue-500/25 active:scale-[0.98] transition-all flex items-center gap-2 cursor-pointer">
                                <span>Simpan Jadwal Akses</span>
                                <div id="settings-loader" class="loader hidden"></div>
                            </button>
                        </div>
                    </div>
                </div>
                @endif

            </main>
        </div>
    </div>

    <!-- Script toggle theme, modal actions, and calculations -->
    <script>
        let currentUser = "{{ $user->name ?? 'Administrator Dummy' }}";
        let currentRole = "{{ $user->role ?? 'admin' }}";
        let currentClass = "";
        let currentMapel = "";
        let currentMapelType = "Reguler";
        let studentsData = [];
        let isAksesTugasBuka = false;

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
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(r => r.json());
        }

        // Tab switching logic
        function switchTab(tabId) {
            // Hide all tabs
            document.getElementById('tab-dashboard').classList.add('hidden');
            document.getElementById('tab-input-nilai').classList.add('hidden');
            const tabJadwal = document.getElementById('tab-pengaturan-jadwal');
            if (tabJadwal) tabJadwal.classList.add('hidden');

            // Show target tab
            if (tabId === 'dashboard') {
                document.getElementById('tab-dashboard').classList.remove('hidden');
            } else if (tabId === 'input-nilai') {
                document.getElementById('tab-input-nilai').classList.remove('hidden');
            } else if (tabId === 'pengaturan-jadwal') {
                if (tabJadwal) tabJadwal.classList.remove('hidden');
            }

            // Update navigation button active state
            const navs = ['nav-dashboard', 'nav-input-nilai', 'nav-pengaturan-jadwal'];
            navs.forEach(navId => {
                const navBtn = document.getElementById(navId);
                if (navBtn) {
                    if (navId === `nav-${tabId}`) {
                        navBtn.className = "w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 text-left cursor-pointer";
                    } else {
                        navBtn.className = "w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200 text-left cursor-pointer";
                    }
                }
            });

            // Update title indicator
            const titles = {
                'dashboard': 'Dashboard',
                'input-nilai': 'Input Nilai',
                'pengaturan-jadwal': 'Pengaturan Jadwal'
            };
            const titleIndicator = document.getElementById('page-title-indicator');
            if (titleIndicator) {
                titleIndicator.innerText = titles[tabId] || 'Dashboard';
            }

            // Store active tab in localStorage
            localStorage.setItem('portalnilai_active_tab', tabId);
        }

        // Custom Toast Notification
        function showToast(message, type = "info") {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            let icon = '<i class="fa-solid fa-circle-info shrink-0 text-sm"></i>';
            let bgClass = "bg-blue-600 dark:bg-blue-700";

            if (type === "success") {
                bgClass = "bg-emerald-600 dark:bg-emerald-700";
                icon = '<i class="fa-solid fa-circle-check shrink-0 text-sm"></i>';
            } else if (type === "error") {
                bgClass = "bg-rose-600 dark:bg-rose-700";
                icon = '<i class="fa-solid fa-circle-exclamation shrink-0 text-sm"></i>';
            } else if (type === "warning") {
                bgClass = "bg-amber-500 dark:bg-amber-600";
                icon = '<i class="fa-solid fa-triangle-exclamation shrink-0 text-sm"></i>';
            }

            toast.className = `${bgClass} text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-2.5 mb-2 transform transition-all duration-300 -translate-y-4 opacity-0 pointer-events-auto text-xs font-semibold w-full border border-white/10`;
            toast.innerHTML = `${icon} <span class="break-words leading-relaxed">${message}</span>`;
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('-translate-y-4', 'opacity-0');
            }, 10);

            setTimeout(() => {
                toast.classList.add('-translate-y-4', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Moving focus downwards using Enter key
        function handleEnter(e, colPrefix, currentIndex) {
            if (e.key === "Enter") {
                e.preventDefault();
                let nextIdx = currentIndex + 1;
                if (nextIdx < studentsData.length) {
                    let nextSId = studentsData[nextIdx].siswa_id;
                    let nextEl = document.getElementById(`${colPrefix}_${nextSId}`);
                    if (nextEl && !nextEl.readOnly && !nextEl.disabled) {
                        nextEl.focus();
                        if (typeof nextEl.select === 'function') nextEl.select();
                    } else if (nextEl) {
                        nextEl.focus();
                    }
                }
            }
        }

        // Load Settings on start
        document.addEventListener('DOMContentLoaded', () => {
            // Restore active tab
            const activeTab = localStorage.getItem('portalnilai_active_tab') || 'dashboard';
            switchTab(activeTab);

            // Fetch admin settings if panel exists
            const adminPanel = document.getElementById('admin-panel');
            if (adminPanel) {
                fetchAdminSettings();
            }

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

            // Auto select class if there is only one option in select-kelas (besides the placeholder)
            const selectKelas = document.getElementById('select-kelas');
            if (selectKelas && selectKelas.options.length === 2) {
                selectKelas.selectedIndex = 1;
                // If wali kelas, auto load data
                if (currentRole === 'wali_kelas') {
                    loadStudents();
                }
            }
        });

        function fetchAdminSettings() {
            ajaxGet("{{ route('portalnilai.settings.get') }}")
            .then(res => {
                if (res.status === "success") {
                    document.getElementById('admin-waktu-buka').value = res.data.asas_buka || "";
                    document.getElementById('admin-waktu-tutup').value = res.data.asas_tutup || "";
                    document.getElementById('admin-tugas-buka').value = res.data.tugas_buka || "";
                    document.getElementById('admin-tugas-tutup').value = res.data.tugas_tutup || "";
                }
            }).catch(() => showToast("Gagal mengambil data pengaturan jadwal.", "error"));
        }

        function saveAdminSettings() {
            const adminBuka = document.getElementById('admin-waktu-buka').value;
            const adminTutup = document.getElementById('admin-waktu-tutup').value;
            const tugasBuka = document.getElementById('admin-tugas-buka').value;
            const tugasTutup = document.getElementById('admin-tugas-tutup').value;

            if (!adminBuka || !adminTutup || !tugasBuka || !tugasTutup) {
                return showToast("Semua waktu buka dan tutup wajib diisi!", "warning");
            }

            const btnSaveSettings = document.getElementById('btn-save-settings');
            const loader = document.getElementById('settings-loader');
            btnSaveSettings.disabled = true;
            loader.classList.remove('hidden');

            ajaxPost("{{ route('portalnilai.settings.save') }}", {
                asas_buka: adminBuka,
                asas_tutup: adminTutup,
                tugas_buka: tugasBuka,
                tugas_tutup: tugasTutup
            }).then(res => {
                btnSaveSettings.disabled = false;
                loader.classList.add('hidden');
                if (res.status === "success") {
                    showToast(res.message, "success");
                } else {
                    showToast(res.message, "error");
                }
            }).catch(() => {
                btnSaveSettings.disabled = false;
                loader.classList.add('hidden');
                showToast("Terjadi kesalahan koneksi.", "error");
            });
        }

        function loadStudents() {
            currentClass = document.getElementById('select-kelas').value;
            if (!currentClass) return showToast("Pilih Kelas terlebih dahulu!", "warning");

            if (currentRole === 'wali_kelas') {
                loadWaliKelasData();
                return;
            }

            currentMapel = document.getElementById('select-mapel').value;
            if (!currentMapel) return showToast("Pilih Mata Pelajaran!", "warning");

            const btnLoad = document.getElementById('btn-load');
            const loader = document.getElementById('load-loader');
            btnLoad.disabled = true;
            loader.classList.remove('hidden');

            ajaxGet(`{{ route('portalnilai.students.get') }}?kelas_id=${currentClass}&mapel_id=${currentMapel}`)
            .then(res => {
                btnLoad.disabled = false;
                loader.classList.add('hidden');

                if (res.status === "success") {
                    // Check access alert
                    const alertTutup = document.getElementById('alert-akses-tutup');
                    const btnSave = document.getElementById('btn-save');
                    if (res.isAksesBuka === false) {
                        alertTutup.classList.remove('hidden');
                        btnSave.classList.add('hidden');
                    } else {
                        alertTutup.classList.add('hidden');
                        btnSave.classList.remove('hidden');
                    }

                    isAksesTugasBuka = res.isAksesTugasBuka;
                    currentMapelType = res.tipeMapel || "Reguler";
                    studentsData = res.data;

                    if (studentsData.length > 0 && studentsData[0].mode_asas) {
                        const globalMode = document.getElementById('global-asas-mode');
                        if (globalMode) {
                            globalMode.value = studentsData[0].mode_asas;
                        }
                    }

                    renderTableGuru();
                    showToast("Data berhasil dimuat.", "success");
                } else {
                    showToast(res.message, "error");
                }
            }).catch(() => {
                btnLoad.disabled = false;
                loader.classList.add('hidden');
                showToast("Gagal mengambil data.", "error");
            });
        }

        function loadWaliKelasData() {
            const btnLoad = document.getElementById('btn-load');
            const loader = document.getElementById('load-loader');
            btnLoad.disabled = true;
            loader.classList.remove('hidden');

            ajaxGet(`{{ route('portalnilai.walikelas.get') }}?kelas_id=${currentClass}`)
            .then(res => {
                btnLoad.disabled = false;
                loader.classList.add('hidden');

                if (res.status === "success") {
                    renderTableWaliKelas(res.students, res.mapels);
                    showToast("Data berhasil dimuat.", "success");
                } else {
                    showToast(res.message, "error");
                }
            }).catch(() => {
                btnLoad.disabled = false;
                loader.classList.add('hidden');
                showToast("Gagal mengambil data.", "error");
            });
        }

        function renderTableWaliKelas(students, mapels) {
            document.getElementById('table-container').classList.remove('hidden');
            document.getElementById('table-container').classList.add('flex');

            // Hide PG/Essai controls & info card
            const modeContainer = document.getElementById('asas-mode-container');
            if (modeContainer) modeContainer.classList.add('hidden');
            
            const infoCard = document.getElementById('info-card-container');
            if (infoCard) infoCard.classList.add('hidden');

            // Show Wali Kelas banner
            const wkBanner = document.getElementById('walikelas-banner');
            if (wkBanner) wkBanner.classList.remove('hidden');

            // Hide save button container
            const btnSave = document.getElementById('btn-save');
            if (btnSave && btnSave.parentElement) {
                btnSave.parentElement.classList.add('hidden');
            }

            // Build dynamic headers
            const trHeaders = document.getElementById('tr-headers');
            let headerHTML = `
                <th scope="col" class="px-4 py-4 text-center font-bold tracking-wider text-[11px] text-slate-800 dark:text-slate-200 border-r border-b dark:border-slate-800" style="width: 50px;">NO</th>
                <th scope="col" class="px-6 py-4 font-bold tracking-wider text-[11px] text-slate-800 dark:text-slate-200 border-r border-b dark:border-slate-800" style="min-width: 200px;">NAMA SISWA / NISN</th>
            `;

            mapels.forEach(mapel => {
                headerHTML += `
                    <th scope="col" class="px-4 py-4 text-center font-bold tracking-wider text-[11px] text-slate-800 dark:text-slate-200 border-r border-b dark:border-slate-800" style="min-width: 120px;">${mapel.nama}</th>
                `;
            });
            trHeaders.innerHTML = headerHTML;

            // Build rows
            const tbody = document.getElementById('table-body');
            let rowsHTML = "";

            students.forEach((student, index) => {
                let cellsHTML = "";
                mapels.forEach(mapel => {
                    const gradeVal = student.grades[mapel.id];
                    let displayGrade = "-";
                    let gradeClass = "text-slate-800 dark:text-slate-200 font-medium";

                    if (gradeVal !== null && gradeVal !== undefined) {
                        displayGrade = gradeVal;
                        // Under 75 (Passing grade KKM) is highlighted red
                        if (parseFloat(gradeVal) < 75) {
                            gradeClass = "text-rose-600 dark:text-rose-400 font-bold";
                        }
                    }

                    cellsHTML += `
                        <td class="px-4 py-4 text-center border-r border-b border-slate-100 dark:border-slate-800/60 ${gradeClass}">
                            ${displayGrade}
                        </td>
                    `;
                });

                rowsHTML += `
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors bg-white dark:bg-slate-900 border-b dark:border-slate-800/50">
                        <td class="px-4 py-4 text-center border-r border-b border-slate-100 dark:border-slate-800/60 font-medium text-slate-500">${index + 1}</td>
                        <td class="px-6 py-4 border-r border-b border-slate-100 dark:border-slate-800/60">
                            <span class="block font-bold text-slate-800 dark:text-slate-200 text-xs">${student.nama}</span>
                            <span class="block text-[10px] text-slate-400 font-medium mt-0.5">${student.nisn || '-'}</span>
                        </td>
                        ${cellsHTML}
                    </tr>
                `;
            });

            tbody.innerHTML = rowsHTML;
        }

        function updateEsString(siswaId) {
            let vals = [];
            for (let i = 1; i <= 5; i++) {
                vals.push(document.getElementById(`es${i}_${siswaId}`).value);
            }
            document.getElementById(`es_${siswaId}`).value = vals.join(',');
            calculateMurni(siswaId);
        }

        function renderTableGuru() {
            document.getElementById('table-container').classList.remove('hidden');
            document.getElementById('table-container').classList.add('flex');

            // Hide Wali Kelas banner in teacher/admin mode
            const wkBanner = document.getElementById('walikelas-banner');
            if (wkBanner) wkBanner.classList.add('hidden');

            // Show save button container in teacher/admin mode
            const btnSave = document.getElementById('btn-save');
            if (btnSave && btnSave.parentElement) {
                if (currentRole === 'wali_kelas') {
                    btnSave.parentElement.classList.add('hidden');
                } else {
                    btnSave.parentElement.classList.remove('hidden');
                }
            }

            const isProduktif = currentMapelType.toLowerCase() === "praktik" || currentMapelType.toLowerCase() === "produktif";
            let modeGlobalInit = document.getElementById('global-asas-mode') ? document.getElementById('global-asas-mode').value.toLowerCase() : "benar";

            // Hide PG/Essai controls for Praktik
            const modeContainer = document.getElementById('asas-mode-container');
            if (isProduktif) {
                modeContainer.classList.add('hidden');
            } else {
                modeContainer.classList.remove('hidden');
            }

            // Show/hide info card and toggle its children depending on mapel type
            const infoCard = document.getElementById('info-card-container');
            if (infoCard) {
                infoCard.classList.remove('hidden');
                const infoPg = document.getElementById('info-pg-detail');
                const infoEssai = document.getElementById('info-essai-detail');
                if (isProduktif) {
                    if (infoPg) infoPg.classList.add('hidden');
                    if (infoEssai) infoEssai.classList.add('hidden');
                } else {
                    if (infoPg) infoPg.classList.remove('hidden');
                    if (infoEssai) infoEssai.classList.remove('hidden');
                }
            }

            // Headers Setup
            const isTugasEditable = (currentRole === "Admin" || currentRole === "superadmin" || isAksesTugasBuka);
            let pgWidthClass = modeGlobalInit === 'fasttrack' ? 'w-32 min-w-[128px]' : 'w-[280px] min-w-[280px]';
            let thPG = isProduktif ? '' : `<th id="th-pg" class="px-4 py-4 ${pgWidthClass} text-center border-r border-b dark:border-slate-800 bg-blue-100/60 dark:bg-slate-800/80 text-blue-900 dark:text-blue-400 font-bold sticky top-0 z-40 transition-all duration-300" title="Ketik: salah semua / benar semua / Fast Track">Input PG ASAS GENAP</th>`;
            
            let thES = isProduktif ? '' : `
                <th class="px-2 py-4 min-w-[280px] text-center border-r border-b dark:border-slate-800 bg-blue-100/60 dark:bg-slate-800/80 text-blue-900 dark:text-blue-400 font-bold sticky top-0 z-40">
                    <div>Input Essai (Per Soal)</div>
                </th>
            `;
            let thMurniText = isProduktif ? 'Nilai ASAS' : 'Murni ASAS GENAP';
            let thMurni = `<th class="px-3 py-4 w-24 text-center border-r border-b dark:border-slate-800 bg-blue-200/60 dark:bg-slate-800 font-bold sticky top-0 z-40 text-blue-950 dark:text-blue-300">${thMurniText}</th>`;
            let thPerbaikan = isProduktif ? '' : `<th class="px-3 py-4 w-24 text-center border-r border-b dark:border-slate-800 bg-rose-100/50 dark:bg-rose-950/20 text-rose-800 dark:text-rose-400 sticky top-0 z-40 font-bold">Perbaikan</th>`;

            document.getElementById('tr-headers').innerHTML = `
                <th class="px-4 py-4 text-center w-12 sticky left-0 top-0 bg-slate-200 dark:bg-slate-800 border-r border-b dark:border-slate-800 z-50 text-slate-600 dark:text-slate-300">No</th>
                <th class="px-4 py-4 w-[280px] min-w-[280px] sticky left-[48px] top-0 bg-slate-200 dark:bg-slate-800 border-r border-b dark:border-slate-800 z-50 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] text-slate-600 dark:text-slate-300">Nama Siswa / NISN</th>
                <th class="px-3 py-4 w-20 text-center border-r border-b dark:border-slate-800 bg-slate-200/60 dark:bg-slate-800/60 sticky top-0 z-40 text-slate-600 dark:text-slate-300 font-bold">${isTugasEditable ? 'Tugas 1' : 'Tugas 1 🔒'}</th>
                <th class="px-3 py-4 w-20 text-center border-r border-b dark:border-slate-800 bg-slate-200/60 dark:bg-slate-800/60 sticky top-0 z-40 text-slate-600 dark:text-slate-300 font-bold">${isTugasEditable ? 'Tugas 2' : 'Tugas 2 🔒'}</th>
                <th class="px-3 py-4 w-20 text-center border-r border-b dark:border-slate-800 bg-slate-200/60 dark:bg-slate-800/60 sticky top-0 z-40 text-slate-600 dark:text-slate-300 font-bold">${isTugasEditable ? 'ASTS' : 'ASTS 🔒'}</th>
                <th class="px-3 py-4 w-20 text-center border-r border-b dark:border-slate-800 bg-amber-50/50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300 font-bold sticky top-0 z-40">Tugas 4</th>
                <th class="px-3 py-4 w-20 text-center border-r border-b dark:border-slate-800 bg-amber-50/50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300 font-bold sticky top-0 z-40">Tugas 5</th>
                ${thPG}
                ${thES}
                ${thMurni}
                ${thPerbaikan}
                <th class="px-3 py-4 w-24 text-center border-r border-b dark:border-slate-800 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold sticky top-0 z-40">Ketuntasan</th>
                <th class="px-3 py-4 w-24 text-center bg-emerald-100/60 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 border-b dark:border-slate-800 font-bold sticky top-0 z-40">Nilai Akhir</th>
            `;

            const tbody = document.getElementById('table-body');
            tbody.innerHTML = '';

            let tugasClass = isTugasEditable ? "bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-blue-500 cursor-text" : "admin-readonly cursor-not-allowed border border-transparent";
            let tugasReadonly = isTugasEditable ? "" : "readonly disabled";
            let tdTugasClass = isTugasEditable ? "bg-amber-50/10" : "bg-slate-100/50 dark:bg-slate-900/30";

            let pgPlaceholder = modeGlobalInit === 'fasttrack' ? "Cth: 24" : "Cth: 1,2.. / 25 / benar semua";

            studentsData.forEach((siswa, index) => {
                const sId = siswa.siswa_id;
                const tr = document.createElement('tr');
                tr.className = "bg-white dark:bg-slate-900 hover:bg-blue-50/30 dark:hover:bg-slate-800/30 transition border-b dark:border-slate-800/50";

                let pgAsasVal = siswa.pg_asas ?? '';
                let esAsasVal = siswa.essai_asas ?? '';

                let esVals = ["0","0","0","0","0"];
                let esStr = esAsasVal.toString().toLowerCase().trim();

                if (esStr === "benar semua") {
                    esVals = ["8","8","8","8","8"];
                    esAsasVal = "8,8,8,8,8";
                } else if (esStr === "salah semua") {
                    esVals = ["0","0","0","0","0"];
                    esAsasVal = "0,0,0,0,0";
                } else if (esStr !== "") {
                    let parsed = esStr.split(',').map(s => s.trim());
                    for (let i = 0; i < 5; i++) {
                        if (parsed[i] !== undefined && parsed[i] !== "") esVals[i] = parsed[i];
                    }
                }

                const buildEsSelect = (qNum, val) => {
                    let opts = ["0", "2", "4", "8"];
                    if (!opts.includes(val) && val !== "") opts.push(val);
                    let optionsHtml = opts.map(o => `<option value="${o}" ${val === o ? 'selected' : ''}>${o}</option>`).join('');
                    return `
                        <div class="flex flex-col items-center">
                            <span class="text-[10px] text-slate-400 font-bold mb-1">N${qNum}</span>
                            <select id="es${qNum}_${sId}" onchange="updateEsString('${sId}')" class="w-[42px] h-[28px] text-[11px] rounded border border-blue-200 dark:border-slate-700 outline-none focus:border-blue-500 bg-white dark:bg-slate-800 font-bold text-blue-900 dark:text-blue-300 text-center cursor-pointer select-hide-arrow hover:bg-blue-50/50 transition">
                                ${optionsHtml}
                            </select>
                        </div>
                    `;
                };

                let tdPG = isProduktif ? '' : `<td class="px-2 py-3 border-r dark:border-slate-800/80 bg-blue-50/10"><input type="text" id="pg_${sId}" class="w-full p-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-center outline-none focus:border-blue-500 text-xs font-semibold" placeholder="${pgPlaceholder}" value="${pgAsasVal}" oninput="calculateMurni('${sId}')" onkeydown="handleEnter(event, 'pg', ${index})"></td>`;
                
                let tdES = isProduktif ? '' : `
                    <td class="px-2 py-2 border-r dark:border-slate-800/80 bg-blue-50/5 dark:bg-slate-900/10">
                        <input type="hidden" id="es_${sId}" value="${esAsasVal}">
                        <div class="flex justify-center gap-3">
                            ${buildEsSelect(1, esVals[0])}
                            ${buildEsSelect(2, esVals[1])}
                            ${buildEsSelect(3, esVals[2])}
                            ${buildEsSelect(4, esVals[3])}
                            ${buildEsSelect(5, esVals[4])}
                        </div>
                    </td>
                `;

                let murniClass = isProduktif ? 'bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-blue-500 cursor-text' : 'bg-transparent border border-transparent cursor-not-allowed';
                let murniReadonly = isProduktif ? '' : 'readonly disabled';
                let murniOninput = isProduktif ? `oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAkhir('${sId}')"` : '';
                let tdMurni = `<td class="px-2 py-3 border-r dark:border-slate-800/80 bg-blue-100/10"><input type="number" id="murni_${sId}" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full text-center p-2 font-bold text-blue-700 dark:text-blue-400 outline-none rounded-lg ${murniClass}" value="${siswa.murni_asas ?? '0'}" ${murniReadonly} ${murniOninput} onkeydown="handleEnter(event, 'murni', ${index})"></td>`;

                let tdPerbaikan = isProduktif ? '' : `<td class="px-2 py-3 border-r dark:border-slate-800/80 bg-rose-50/10"><input type="number" id="perbaikan_${sId}" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full text-center p-2 rounded-lg border border-slate-200 dark:border-slate-700 outline-none focus:border-rose-500 text-rose-600 dark:text-rose-400 font-bold bg-white dark:bg-slate-800 text-xs" value="${siswa.perbaikan ?? ''}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAkhir('${sId}')" onkeydown="handleEnter(event, 'perbaikan', ${index})"></td>`;

                tr.innerHTML = `
                    <td class="px-4 py-3 text-center border-r dark:border-slate-800/80 font-medium sticky left-0 bg-white dark:bg-slate-900 z-10 text-slate-400">${index + 1}</td>
                    <td class="px-4 py-3 border-r dark:border-slate-800/80 sticky left-[48px] bg-white dark:bg-slate-900 z-10 font-bold shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] truncate max-w-[280px]" title="${siswa.nama}">${siswa.nama}<div class="text-[10px] font-semibold text-slate-400 mt-0.5">${siswa.nisn || '-'}</div></td>
                    
                    <td class="px-2 py-3 border-r dark:border-slate-800/80 ${tdTugasClass}"><input type="number" id="t1_${sId}" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full text-center p-2 rounded-lg outline-none text-xs font-semibold ${tugasClass}" value="${siswa.tugas_1 ?? ''}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAkhir('${sId}')" onkeydown="handleEnter(event, 't1', ${index})" ${tugasReadonly}></td>
                    <td class="px-2 py-3 border-r dark:border-slate-800/80 ${tdTugasClass}"><input type="number" id="t2_${sId}" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full text-center p-2 rounded-lg outline-none text-xs font-semibold ${tugasClass}" value="${siswa.tugas_2 ?? ''}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAkhir('${sId}')" onkeydown="handleEnter(event, 't2', ${index})" ${tugasReadonly}></td>
                    <td class="px-2 py-3 border-r dark:border-slate-800/80 ${tdTugasClass}"><input type="number" id="asts_${sId}" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full text-center p-2 rounded-lg outline-none text-xs font-bold ${isTugasEditable ? 'text-slate-800 dark:text-slate-100 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-blue-500 cursor-text' : 'text-slate-600 dark:text-slate-400 admin-readonly cursor-not-allowed border border-transparent'}" value="${siswa.asts ?? ''}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAkhir('${sId}')" onkeydown="handleEnter(event, 'asts', ${index})" ${tugasReadonly}></td>
                    
                    <td class="px-2 py-3 border-r dark:border-slate-800/80 bg-amber-50/5 dark:bg-slate-900/5"><input type="number" id="t4_${sId}" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full text-center p-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 outline-none focus:border-blue-500 text-xs font-semibold cursor-text" value="${siswa.tugas_4 ?? ''}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAkhir('${sId}')" onkeydown="handleEnter(event, 't4', ${index})"></td>
                    <td class="px-2 py-3 border-r dark:border-slate-800/80 bg-amber-50/5 dark:bg-slate-900/5"><input type="number" id="t5_${sId}" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full text-center p-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 outline-none focus:border-blue-500 text-xs font-semibold cursor-text" value="${siswa.tugas_5 ?? ''}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAkhir('${sId}')" onkeydown="handleEnter(event, 't5', ${index})"></td>
                    
                    ${tdPG}
                    ${tdES}
                    ${tdMurni}
                    ${tdPerbaikan}
                    
                    <td class="px-2 py-3 border-r dark:border-slate-800/80 bg-slate-50 dark:bg-slate-900/40 font-bold text-center" id="ketuntasan_${sId}">${siswa.ketuntasan || '-'}</td>
                    <td class="px-2 py-3 bg-emerald-50/30 dark:bg-emerald-950/20 font-bold text-center text-base text-emerald-700 dark:text-emerald-400" id="akhir_${sId}">${siswa.nilai_akhir ?? '0'}</td>
                `;
                tbody.appendChild(tr);

                if (siswa.murni_asas !== null || siswa.tugas_1 !== null || siswa.asts !== null) {
                    calculateAkhir(sId);
                }
            });
        }

        function recalculateAll() {
            const modeSelect = document.getElementById('global-asas-mode');
            const mode = modeSelect ? modeSelect.value.toLowerCase() : "benar";
            const thPg = document.getElementById('th-pg');

            if (thPg) {
                if (mode === 'fasttrack') {
                    thPg.className = "px-4 py-4 w-32 min-w-[128px] text-center border-r border-b dark:border-slate-800 bg-blue-100/60 dark:bg-slate-800/80 text-blue-900 dark:text-blue-400 font-bold sticky top-0 z-40 transition-all duration-300";
                } else {
                    thPg.className = "px-4 py-4 w-[280px] min-w-[280px] text-center border-r border-b dark:border-slate-800 bg-blue-100/60 dark:bg-slate-800/80 text-blue-900 dark:text-blue-400 font-bold sticky top-0 z-40 transition-all duration-300";
                }
            }

            studentsData.forEach(siswa => {
                const pgInput = document.getElementById(`pg_${siswa.siswa_id}`);
                if (pgInput) {
                    pgInput.placeholder = (mode === 'fasttrack') ? "Cth: 24" : "Cth: 1,2.. / 25 / benar semua";
                }
                calculateMurni(siswa.siswa_id);
            });
        }

        function calculateMurni(siswaId) {
            const isProduktif = currentMapelType.toLowerCase() === "praktik" || currentMapelType.toLowerCase() === "produktif";
            if (isProduktif) {
                calculateAkhir(siswaId);
                return;
            }

            const modeSelect = document.getElementById('global-asas-mode');
            const mode = modeSelect ? modeSelect.value.toLowerCase() : "benar";
            const pgInput = document.getElementById(`pg_${siswaId}`).value.trim().toLowerCase();
            const esInput = document.getElementById(`es_${siswaId}`).value.trim();

            const selectMapelEl = document.getElementById('select-mapel');
            const mapelText = (selectMapelEl && selectMapelEl.selectedIndex >= 0) 
                ? selectMapelEl.options[selectMapelEl.selectedIndex].text.toLowerCase() 
                : "";
            
            const isMath = currentMapelType.toLowerCase().includes("matematika") || 
                           mapelText.includes("matematika") || 
                           mapelText.includes("mtk");

            const maxPG = isMath ? 25 : 30;
            const bobotPG = isMath ? 2.4 : 2;
            const maxES = 5;

            let finalPG = 0;
            let finalES = 0;

            // PG Calculation
            if (pgInput === "benar semua") {
                finalPG = maxPG * bobotPG;
            } else if (pgInput === "salah semua") {
                finalPG = 0;
            } else if (mode === "fasttrack") {
                let countPG = parseInt(pgInput);
                if (isNaN(countPG)) countPG = 0;
                if (countPG > maxPG) countPG = maxPG;
                if (countPG < 0) countPG = 0;
                finalPG = countPG * bobotPG;
            } else {
                let countPG = pgInput ? pgInput.split(',').filter(i => i.trim() !== "").length : 0;
                if (countPG > maxPG) countPG = maxPG;
                if (mode === "benar") finalPG = countPG * bobotPG;
                else if (mode === "salah") finalPG = (maxPG - countPG) * bobotPG;
            }

            // Essai Calculation
            let scores = esInput.split(',').map(s => parseFloat(s.trim())).filter(n => !isNaN(n));
            scores = scores.slice(0, maxES);
            finalES = scores.reduce((total, num) => total + num, 0);
            if (finalES > 40) finalES = 40;

            let nilaiMurni = Math.round(finalPG + finalES);
            if (nilaiMurni > 100) nilaiMurni = 100;
            if (nilaiMurni < 0) nilaiMurni = 0;

            document.getElementById(`murni_${siswaId}`).value = nilaiMurni;
            calculateAkhir(siswaId);
        }

        function calculateAkhir(siswaId) {
            const getVal = (id) => {
                const el = document.getElementById(id);
                return el ? parseFloat(el.value) || 0 : 0;
            };

            const isProduktif = currentMapelType.toLowerCase() === "praktik" || currentMapelType.toLowerCase() === "produktif";
            let asas = 0;

            if (isProduktif) {
                asas = getVal(`murni_${siswaId}`);
            } else {
                let perbaikanEl = document.getElementById(`perbaikan_${siswaId}`);
                let perbaikan = perbaikanEl ? perbaikanEl.value : "";
                asas = perbaikan !== "" ? parseFloat(perbaikan) : getVal(`murni_${siswaId}`);
            }

            let rataRata = Math.round((getVal(`t1_${siswaId}`) + getVal(`t2_${siswaId}`) + getVal(`asts_${siswaId}`) + getVal(`t4_${siswaId}`) + getVal(`t5_${siswaId}`) + asas) / 6);
            document.getElementById(`akhir_${siswaId}`).innerText = rataRata;

            const elKetuntasan = document.getElementById(`ketuntasan_${siswaId}`);
            if (rataRata >= 75) {
                elKetuntasan.innerText = "TUNTAS";
                elKetuntasan.className = "px-2 py-3 border-r dark:border-slate-800/80 bg-emerald-50 dark:bg-emerald-950/20 font-bold text-center text-emerald-600 dark:text-emerald-400";
            } else {
                elKetuntasan.innerText = "TIDAK TUNTAS";
                elKetuntasan.className = "px-2 py-3 border-r dark:border-slate-800/80 bg-rose-50 dark:bg-rose-950/20 font-bold text-center text-rose-600 dark:text-rose-400";
            }
        }

        function saveGrades() {
            const modeGlobal = document.getElementById('global-asas-mode') ? document.getElementById('global-asas-mode').value : "Benar";

            const getValStr = (id) => { const el = document.getElementById(id); return el ? el.value : ""; };
            const getInnerStr = (id) => { const el = document.getElementById(id); return el ? el.innerText : ""; };

            const payloadData = studentsData.map(siswa => ({
                siswa_id: siswa.siswa_id,
                tugas_1: getValStr(`t1_${siswa.siswa_id}`),
                tugas_2: getValStr(`t2_${siswa.siswa_id}`),
                asts: getValStr(`asts_${siswa.siswa_id}`),
                tugas_4: getValStr(`t4_${siswa.siswa_id}`),
                tugas_5: getValStr(`t5_${siswa.siswa_id}`),
                mode_asas: modeGlobal,
                pg_asas: getValStr(`pg_${siswa.siswa_id}`),
                essai_asas: getValStr(`es_${siswa.siswa_id}`),
                murni_asas: getValStr(`murni_${siswa.id ?? siswa.siswa_id}`),
                perbaikan: getValStr(`perbaikan_${siswa.siswa_id}`),
                ketuntasan: getInnerStr(`ketuntasan_${siswa.siswa_id}`),
                nilai_akhir: getInnerStr(`akhir_${siswa.siswa_id}`)
            }));

            const btnSave = document.getElementById('btn-save');
            const loader = document.getElementById('save-loader');
            btnSave.disabled = true;
            loader.classList.remove('hidden');

            ajaxPost("{{ route('portalnilai.grades.save') }}", {
                kelas_id: currentClass,
                mapel_id: currentMapel,
                payload: payloadData
            }).then(res => {
                btnSave.disabled = false;
                loader.classList.add('hidden');
                if (res.status === "success") {
                    showToast(res.message, "success");
                } else {
                    showToast(res.message, "error");
                }
            }).catch(() => {
                btnSave.disabled = false;
                loader.classList.add('hidden');
                showToast("Gagal menyimpan data.", "error");
            });
        }
    </script>
</body>
</html>
