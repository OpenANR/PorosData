<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Halaman Login Portal Penilaian - PorosData.">
    <title>Login Portal Penilaian - PorosData</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome (for icons) -->
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

    <!-- Background Container -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-20">
        <!-- Subtle gradient and decorative blur circles to match PorosData theme -->
        <div class="absolute inset-0 bg-slate-100/40 dark:bg-slate-950/75 transition-colors duration-300"></div>
        <div class="absolute top-1/4 left-1/4 w-72 h-72 sm:w-96 sm:h-96 bg-blue-500/20 dark:bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-72 h-72 sm:w-96 sm:h-96 bg-indigo-500/20 dark:bg-indigo-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
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
    <div class="w-full max-w-[420px] relative">
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-2xl rounded-3xl p-8 sm:p-10 transition-all duration-300 animate-fade-in">
            
            <!-- School Logo/Icon -->
            <div class="flex flex-col items-center mb-6">
                <!-- Logo Box with border matching screenshot -->
                <div class="h-24 w-24 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 flex items-center justify-center p-2.5 shadow-sm mb-4">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK" class="h-full w-full object-contain">
                </div>
                
                <h1 class="text-3xl font-extrabold tracking-tight text-center text-slate-800 dark:text-slate-100">
                    Portal Penilaian
                </h1>
                <p id="login-subtitle" class="text-slate-400 dark:text-slate-500 text-sm font-semibold mt-1">
                    Masuk dengan Kode Guru & Tgl Lahir
                </p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('portalnilai.login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Masuk Sebagai Role Dropdown -->
                <div class="space-y-2">
                    <label for="role" class="text-sm font-semibold text-slate-600 dark:text-slate-300 block">
                        Masuk Sebagai
                    </label>
                    <div class="relative rounded-2xl">
                        <select name="role" id="role" onchange="updateFormFields(this.value)"
                            class="block w-full px-4 py-3 bg-white dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-950 rounded-xl text-sm transition-all focus:outline-none focus:ring-4 focus:ring-blue-500/10 text-slate-900 dark:text-white cursor-pointer appearance-none">
                            <option value="guru" {{ old('role') === 'guru' ? 'selected' : '' }}>🧑‍🏫 Guru Pengajar</option>
                            <option value="wali_kelas" {{ old('role') === 'wali_kelas' ? 'selected' : '' }}>📋 Wali Kelas</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>🛡️ Administrator</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Username Input -->
                <div class="space-y-2">
                    <label id="lbl-username" for="username" class="text-sm font-semibold text-slate-600 dark:text-slate-300 block">
                        Username / Kode Guru
                    </label>
                    <div class="relative rounded-2xl">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fa-regular fa-user text-sm"></i>
                        </div>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus
                            class="block w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-950 rounded-xl text-sm transition-all focus:outline-none focus:ring-4 focus:ring-blue-500/10 text-slate-900 dark:text-white @error('username') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500/10 @enderror"
                            placeholder="Contoh: 20221114">
                    </div>
                    @error('username')
                        <p class="text-xs text-rose-600 dark:text-rose-400 font-medium flex items-center gap-1.5 mt-1">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <label id="lbl-password" for="password" class="text-sm font-semibold text-slate-600 dark:text-slate-300 block">
                        Password / Tgl Lahir
                    </label>
                    <div class="relative rounded-2xl">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="block w-full pl-11 pr-10 py-3 bg-white dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-950 rounded-xl text-sm transition-all focus:outline-none focus:ring-4 focus:ring-blue-500/10 text-slate-900 dark:text-white @error('password') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500/10 @enderror"
                            placeholder="Contoh: 15081985">
                        <!-- Toggle Password Visibility -->
                        <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 focus:outline-none cursor-pointer">
                            <i id="password-icon" class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 mt-2 px-5 py-3 text-sm font-semibold rounded-xl bg-blue-600 hover:bg-blue-500 dark:bg-blue-700 dark:hover:bg-blue-600 text-white shadow-lg shadow-blue-500/15 dark:shadow-none hover:shadow-xl hover:shadow-blue-500/25 active:scale-[0.98] transition-all focus:outline-none focus:ring-4 focus:ring-blue-500/25 cursor-pointer">
                    Masuk Aplikasi <i class="fa-solid fa-sign-in-alt text-xs ml-1"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Toast Notifications -->
    @if (session('success') || session('error'))
        <div id="toast" class="fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl border transition-all duration-300 translate-x-12 opacity-0 {{ session('success') ? 'bg-emerald-50/95 dark:bg-emerald-950/90 text-emerald-800 dark:text-emerald-200 border-emerald-200 dark:border-emerald-900/40' : 'bg-rose-50/95 dark:bg-rose-950/90 text-rose-800 dark:text-rose-200 border-rose-200 dark:border-rose-900/40' }}">
            @if (session('success'))
                <div class="h-8 w-8 rounded-xl bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            @else
                <div class="h-8 w-8 rounded-xl bg-rose-100 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
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

    <!-- Script toggle password, theme switcher, and dynamic labels -->
    <script>
        // Form field mapping based on selected role
        function updateFormFields(role) {
            const subtitle = document.getElementById('login-subtitle');
            const lblUsername = document.getElementById('lbl-username');
            const txtUsername = document.getElementById('username');
            const lblPassword = document.getElementById('lbl-password');
            const txtPassword = document.getElementById('password');

            if (role === 'guru') {
                subtitle.innerText = "Masuk dengan Kode Guru & Tgl Lahir";
                lblUsername.innerText = "Username / Kode Guru";
                txtUsername.placeholder = "Contoh: 20221114";
                lblPassword.innerText = "Password / Tgl Lahir";
                txtPassword.placeholder = "Contoh: 15081985";
            } else if (role === 'wali_kelas') {
                subtitle.innerText = "Masuk dengan Kode DUK & Tgl Lahir";
                lblUsername.innerText = "Username / Kode DUK";
                txtUsername.placeholder = "Contoh: 20091513";
                lblPassword.innerText = "Password / Tgl Lahir";
                txtPassword.placeholder = "Contoh: 15081985";
            } else if (role === 'admin') {
                subtitle.innerText = "Masuk dengan Akun Administrator";
                lblUsername.innerText = "Username / Email";
                txtUsername.placeholder = "Contoh: admin_nilai";
                lblPassword.innerText = "Password";
                txtPassword.placeholder = "Masukkan password...";
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Initialize labels on load
            const roleSelect = document.getElementById('role');
            if (roleSelect) {
                updateFormFields(roleSelect.value);
            }

            // Password visibility toggle
            const passwordInput = document.getElementById('password');
            const togglePasswordBtn = document.getElementById('toggle-password');
            const passwordIcon = document.getElementById('password-icon');

            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', () => {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    // Toggle icons
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
