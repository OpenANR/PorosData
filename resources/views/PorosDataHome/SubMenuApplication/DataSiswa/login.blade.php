<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Halaman Login Portal Data Siswa - SD Negeri 01 Poros Data.">
    <title>Login Portal Data Siswa - SD Negeri 01 Poros Data</title>

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
            background-color: rgba(255, 255, 255, 0.90);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .dark .glass-panel {
            background-color: rgba(15, 23, 42, 0.80);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>
<body class="min-h-screen text-slate-900 dark:text-slate-100 antialiased transition-colors duration-300 flex items-center justify-center p-4 relative bg-slate-50 dark:bg-slate-950">

    <!-- Background Container -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-20">
        <!-- Subtle gradient and decorative blur circles -->
        <div class="absolute inset-0 bg-slate-100/40 dark:bg-slate-950/75 transition-colors duration-300"></div>
        <div class="absolute top-1/4 left-1/4 w-72 h-72 sm:w-96 sm:h-96 bg-indigo-500/20 dark:bg-indigo-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-72 h-72 sm:w-96 sm:h-96 bg-violet-500/20 dark:bg-violet-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Theme Toggle in corner -->
    <div class="absolute top-6 right-6">
        <button id="theme-toggle" class="p-2.5 rounded-xl border border-slate-200/80 dark:border-slate-800/80 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-white/50 dark:hover:bg-slate-900/50 focus:outline-none transition-all shadow-sm">
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

    <!-- Login Card Container -->
    <div class="w-full max-w-md relative">
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-2xl rounded-3xl p-8 sm:p-10 transition-all duration-300">
            
            <!-- School Logo/Icon -->
            <div class="flex flex-col items-center mb-6">
                <div class="h-16 w-16 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-bold shadow-md shadow-indigo-200 dark:shadow-none mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.052 20.3a11.386 11.386 0 0 1-4.953-1.063v-.109m10.003-3.07a9.383 9.383 0 0 0-4.122-3.765 4.125 4.125 0 0 0-7.38 2.85c0 1.91 1.254 3.527 2.99 4.09l-.014.072m1.226-7.9L10.05 9.03l2.678-2.03m-2.678 2.03-2.678-2.03m2.678 2.03V3.75" />
                    </svg>
                </div>
                
                <h1 class="text-2xl font-extrabold tracking-tight text-center text-indigo-600 dark:text-indigo-400">
                    SD Negeri 01 Poros Data
                </h1>
                <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200 mt-1">
                    Portal Data Siswa
                </h2>
                <p class="text-slate-400 dark:text-slate-500 text-xs font-semibold mt-1">
                    SDN01_POROSDATA
                </p>
                
                <hr class="w-full border-t border-slate-200 dark:border-slate-800 mt-5">
            </div>

            <!-- Login Form -->
            <form action="{{ route('datasiswa.login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Username / Kode DUK Input -->
                <div class="space-y-2">
                    <label for="username_or_duk" class="text-sm font-semibold text-slate-700 dark:text-slate-300 block">
                        Username / Kode DUK
                    </label>
                    <div class="relative rounded-2xl">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>
                        <input type="text" name="username_or_duk" id="username_or_duk" value="{{ old('username_or_duk') }}" required autofocus
                            class="block w-full pl-11 pr-4 py-3 bg-slate-100/60 dark:bg-slate-900/60 border border-slate-200/60 dark:border-slate-800/60 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-950 rounded-2xl text-sm transition-all focus:outline-none focus:ring-4 focus:ring-indigo-500/10 text-slate-900 dark:text-white @error('username_or_duk') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500/10 @enderror"
                            placeholder="Masukkan Username / Kode DUK">
                    </div>
                    @error('username_or_duk')
                        <p class="text-xs text-rose-600 dark:text-rose-400 font-medium flex items-center gap-1.5 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <label for="password" class="text-sm font-semibold text-slate-700 dark:text-slate-300 block">
                        Password
                    </label>
                    <div class="relative rounded-2xl">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="block w-full pl-11 pr-4 py-3 bg-slate-100/60 dark:bg-slate-900/60 border border-slate-200/60 dark:border-slate-800/60 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-950 rounded-2xl text-sm transition-all focus:outline-none focus:ring-4 focus:ring-indigo-500/10 text-slate-900 dark:text-white @error('password') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500/10 @enderror"
                            placeholder="Masukkan Password">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 mt-2 px-5 py-3 text-sm font-semibold rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg shadow-indigo-500/15 dark:shadow-none hover:shadow-xl hover:shadow-indigo-500/25 active:scale-[0.98] transition-all focus:outline-none focus:ring-4 focus:ring-indigo-500/25">
                    Masuk
                </button>
            </form>
        </div>
    </div>

    <!-- Toast Notifications -->
    @if (session('success') || session('error'))
        <div id="toast" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl border glass-panel transition-all duration-300 translate-y-12 opacity-0">
            @if (session('success'))
                <div class="h-8 w-8 rounded-xl bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ session('success') }}</span>
            @else
                <div class="h-8 w-8 rounded-xl bg-rose-100 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ session('error') }}</span>
            @endif
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toast = document.getElementById('toast');
                if (toast) {
                    setTimeout(() => {
                        toast.classList.remove('translate-y-12', 'opacity-0');
                    }, 100);

                    setTimeout(() => {
                        toast.classList.add('translate-y-12', 'opacity-0');
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
