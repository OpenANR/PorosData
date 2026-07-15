<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Halaman Login Portal Siswa - PorosData.">
    <title>Login Portal Siswa - PorosData</title>

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

    <!-- Background Decoration -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-20">
        <div class="absolute inset-0 bg-slate-100/40 dark:bg-slate-950/75 transition-colors duration-300"></div>
        <div class="absolute top-1/4 left-1/4 w-72 h-72 sm:w-96 sm:h-96 bg-indigo-500/20 dark:bg-indigo-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-72 h-72 sm:w-96 sm:h-96 bg-violet-500/20 dark:bg-violet-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Theme Toggle in corner -->
    <div class="absolute top-6 right-6">
        <button id="theme-toggle" class="p-2.5 rounded-xl border border-slate-200/80 dark:border-slate-800/80 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-white/50 dark:hover:bg-slate-900/50 focus:outline-none transition-all shadow-sm cursor-pointer">
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

    <!-- Login Card -->
    <div class="w-full max-w-[420px] relative">
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-2xl rounded-3xl p-8 sm:p-10 transition-all duration-300">
            
            <!-- Icon/Title -->
            <div class="flex flex-col items-center mb-8">
                <div class="h-16 w-16 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-500/20 dark:shadow-none mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm-1.221 4.702c-.903-.112-1.807-.112-2.71 0a48.11 48.11 0 0 0-1.075.191c-.48.096-.827.514-.827 1.002v.294c0 .548.407.98 1.034 1.018a18.785 18.785 0 0 0 4.41 0c.627-.038 1.034-.47 1.034-1.018v-.294c0-.488-.347-.906-.827-1.002a48.48 48.48 0 0 0-1.075-.191Z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-center bg-gradient-to-r from-indigo-600 to-violet-500 bg-clip-text text-transparent dark:from-indigo-400 dark:to-violet-300">
                    Portal Siswa
                </h1>
                <p class="text-slate-400 dark:text-slate-500 text-xs font-semibold mt-1 uppercase tracking-wider">
                    SDN 01 Poros Data
                </p>
            </div>

            <!-- Form -->
            <form action="{{ route('portalsiswa.login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Username / NISN -->
                <div class="space-y-2">
                    <label for="username_or_nisn" class="text-sm font-semibold text-slate-600 dark:text-slate-300 block">
                        Username atau NISN
                    </label>
                    <div class="relative rounded-2xl">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fa-regular fa-user text-sm"></i>
                        </div>
                        <input type="text" name="username_or_nisn" id="username_or_nisn" value="{{ old('username_or_nisn') }}" required autofocus
                            class="block w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-950 rounded-xl text-sm transition-all focus:outline-none focus:ring-4 focus:ring-indigo-500/10 text-slate-900 dark:text-white @error('username_or_nisn') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500/10 @enderror"
                            placeholder="Masukkan Username atau NISN...">
                    </div>
                    @error('username_or_nisn')
                        <p class="text-xs text-rose-600 dark:text-rose-450 font-medium flex items-center gap-1.5 mt-1">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="text-sm font-semibold text-slate-600 dark:text-slate-300 block">
                        Password
                    </label>
                    <div class="relative rounded-2xl">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="block w-full pl-11 pr-10 py-3 bg-white dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-950 rounded-xl text-sm transition-all focus:outline-none focus:ring-4 focus:ring-indigo-500/10 text-slate-900 dark:text-white"
                            placeholder="••••••••">
                        <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-305 focus:outline-none cursor-pointer">
                            <i id="password-icon" class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 mt-2 px-5 py-3 text-sm font-semibold rounded-xl bg-indigo-600 hover:bg-indigo-500 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white shadow-lg shadow-indigo-500/15 dark:shadow-none hover:shadow-xl hover:shadow-indigo-500/25 active:scale-[0.98] transition-all focus:outline-none focus:ring-4 focus:ring-indigo-500/25 cursor-pointer">
                    Masuk Portal <i class="fa-solid fa-sign-in-alt text-xs ml-1"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Script toggle password and theme switcher -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Password toggle
            const passwordInput = document.getElementById('password');
            const togglePasswordBtn = document.getElementById('toggle-password');
            const passwordIcon = document.getElementById('password-icon');

            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', () => {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    if (type === 'password') {
                        passwordIcon.classList.remove('fa-eye-slash');
                        passwordIcon.classList.add('fa-eye');
                    } else {
                        passwordIcon.classList.remove('fa-eye');
                        passwordIcon.classList.add('fa-eye-slash');
                    }
                });
            }

            // Dark Mode toggle
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
