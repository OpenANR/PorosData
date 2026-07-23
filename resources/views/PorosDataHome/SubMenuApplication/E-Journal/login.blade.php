<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Halaman Login E-Journal - PorosData.">
    <title>Login - E-Journal - PorosData</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Inline script to apply dark mode before page render -->
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
    </style>
</head>
<body class="min-h-screen bg-slate-100 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased transition-colors duration-300 flex items-center justify-center p-4 sm:p-6 lg:p-8 relative">

    @php
        $instansiData = $instansi ?? \App\Models\Instansi::first();
    @endphp

    <!-- Background Decorative Ambience -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-violet-500/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Main Split-Screen Login Card -->
    <div class="w-full max-w-4xl bg-white dark:bg-slate-900 rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-12 border border-slate-200/80 dark:border-slate-800/80 transition-all duration-300">
        
        <!-- Left Side: Hero Banner / App Info -->
        <div class="md:col-span-5 flex flex-col justify-between p-8 sm:p-10 text-white relative overflow-hidden min-h-[380px] md:min-h-[560px]">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat transition-transform duration-700 hover:scale-105" style="background-image: url('{{ asset('images/loginBackground.jpg') }}');"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/70 to-slate-950/50 backdrop-blur-[2px]"></div>

            <!-- Top Header: Dynamic Logo & Brand Name -->
            <div class="relative z-10 flex items-center gap-3.5">
                @if(!empty($instansiData) && !empty($instansiData->logo) && file_exists(public_path('storage/' . $instansiData->logo)))
                    <div class="h-12 w-12 rounded-2xl bg-white/10 backdrop-blur-md p-1.5 border border-white/20 shadow-lg flex items-center justify-center shrink-0">
                        <img src="{{ asset('storage/' . $instansiData->logo) }}" alt="Logo {{ $instansiData->nama_sekolah ?? 'Sekolah' }}" class="max-h-full max-w-full object-contain rounded-xl">
                    </div>
                @else
                    <!-- Default School Logo Icon -->
                    <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 border border-white/20 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5M4.5 21V10.5M12 10.5h.008v.008H12V10.5Z" />
                        </svg>
                    </div>
                @endif
                
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-white leading-tight">
                        {{ $instansiData->nama_sekolah ?? 'PorosData' }}
                    </h2>
                    <p class="text-xs font-medium text-slate-300/80 tracking-wide uppercase">
                        Portal E-Journal
                    </p>
                </div>
            </div>

            <!-- Bottom: Application Functionality Box (No Name/Title as requested) -->
            <div class="relative z-10 mt-auto pt-8">
                <div class="bg-white/10 dark:bg-slate-950/40 backdrop-blur-md border border-white/15 rounded-2xl p-5 shadow-xl">
                    <div class="flex items-center gap-2 mb-2 text-indigo-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        <span class="text-xs font-semibold uppercase tracking-wider">Tentang Platform</span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-200 leading-relaxed font-normal">
                        "E-Journal adalah platform digital untuk mencatat, mengelola, dan memantau jurnal kegiatan mengajar guru secara terstruktur dan efisien."
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form Area -->
        <div class="md:col-span-7 flex flex-col justify-between p-8 sm:p-10 lg:p-12 relative bg-white dark:bg-slate-900">
            
            <!-- Top Action Row: Theme Toggle -->
            <div class="flex items-center justify-between mb-6 sm:mb-8">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    E-Journal Authentication
                </span>
                <button id="theme-toggle" type="button" class="p-2 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    <!-- Sun Icon (dark mode active) -->
                    <svg id="theme-toggle-light-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 hidden">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21M4.22 4.22l1.636 1.636m12.296 12.296l1.636 1.636M3 12h2.25m13.5 0H21M5.858 18.142l1.636-1.636m12.296-12.296l1.636-1.636M12 7.5a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9Z" />
                    </svg>
                    <!-- Moon Icon (light mode active) -->
                    <svg id="theme-toggle-dark-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>
                </button>
            </div>

            <!-- Form Content Wrapper -->
            <div class="my-auto">
                <!-- Welcome Title -->
                <div class="mb-8">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Welcome back to E-Journal
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed">
                        Silakan masukkan username dan password Anda untuk masuk ke sistem dashboard.
                    </p>
                </div>

                <!-- Login Form -->
                <form action="{{ url('/porosdata/e-journal/login') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Username Field -->
                    <div class="space-y-1.5">
                        <label for="username" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Username
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <input type="text" name="username_or_duk" id="username_or_duk" value="{{ old('username_or_duk') }}" required autofocus
                                class="block w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20 rounded-xl text-sm font-medium transition-all text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none @error('username_or_duk') border-rose-500 focus:border-rose-500 focus:ring-rose-500/20 @enderror"
                                placeholder="Masukkan Username / Kode DUK">
                        </div>
                        @error('username_or_duk')
                            <p class="text-xs text-rose-600 dark:text-rose-400 font-medium flex items-center gap-1 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 shrink-0">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                                Password
                            </label>
                            <a href="#" onclick="alert('Silakan hubungi Superadmin atau Administrator Sekolah untuk melakukan reset password.'); return false;" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 transition-colors">
                                Lupa password?
                            </a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" required
                                class="block w-full pl-10 pr-10 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20 rounded-xl text-sm font-medium transition-all text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none @error('password') border-rose-500 focus:border-rose-500 focus:ring-rose-500/20 @enderror"
                                placeholder="••••••••">
                            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 dark:text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none transition-colors">
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 hidden">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <svg id="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-rose-600 dark:text-rose-400 font-medium flex items-center gap-1 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 shrink-0">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me Toggle Switch -->
                    <div class="flex items-center justify-between pt-1">
                        <label for="remember" class="flex items-center cursor-pointer select-none group">
                            <div class="relative">
                                <input id="remember" name="remember" type="checkbox" class="sr-only peer">
                                <div class="w-9 h-5 bg-slate-200 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                            </div>
                            <span class="ml-2.5 text-xs font-semibold text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-slate-200 transition-colors">
                                Ingat saya di perangkat ini
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-3.5 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:scale-[0.99] text-white font-semibold text-sm shadow-lg shadow-indigo-600/25 dark:shadow-none hover:shadow-indigo-600/35 transition-all flex items-center justify-center gap-2 group cursor-pointer mt-2">
                        Log in
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Footer Info -->
            <div class="mt-8 pt-4 border-t border-slate-100 dark:border-slate-800/80 text-center">
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                    Belum memiliki akun? <span class="text-indigo-600 dark:text-indigo-400 font-semibold">Hubungi Administrator Sekolah</span>
                </p>
            </div>

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

    <!-- Toggle Password Visibility Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const togglePassword = document.getElementById('toggle-password');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeSlashIcon = document.getElementById('eye-slash-icon');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', () => {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    eyeIcon.classList.toggle('hidden');
                    eyeSlashIcon.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>
