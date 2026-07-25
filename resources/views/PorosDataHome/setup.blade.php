<!DOCTYPE html>
<html lang="id" class="h-full antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Instansi - Poros Data</title>
    <!-- Theme Script to Prevent FOUC -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, .font-heading { font-family: 'Outfit', sans-serif; }
        
        /* Glassmorphism Panel */
        .glass-panel {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08);
        }
        .dark .glass-panel {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(51, 65, 85, 0.6);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* Animated Background Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.6;
            animation: float 20s infinite alternate ease-in-out;
        }
        .orb-1 {
            width: 400px; height: 400px;
            top: -10%; left: -10%;
            background: radial-gradient(circle, rgba(99,102,241,0.5) 0%, rgba(168,85,247,0) 70%);
            animation-delay: 0s;
        }
        .orb-2 {
            width: 500px; height: 500px;
            bottom: -20%; right: -10%;
            background: radial-gradient(circle, rgba(168,85,247,0.5) 0%, rgba(236,72,153,0) 70%);
            animation-delay: -5s;
        }
        .orb-3 {
            width: 300px; height: 300px;
            top: 40%; left: 50%;
            background: radial-gradient(circle, rgba(56,189,248,0.4) 0%, rgba(59,130,246,0) 70%);
            animation-delay: -10s;
            transform: translate(-50%, -50%);
        }

        .dark .orb { opacity: 0.35; }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0, 0) scale(1); }
        }

        /* Form Controls Animations */
        .input-transition {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-transition:focus {
            transform: translateY(-1px);
        }

        /* Fade In Up Animation */
        .animate-fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(16px);
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 dark:bg-slate-950 flex flex-col items-center justify-center py-10 px-4 text-slate-800 dark:text-slate-200 relative overflow-x-hidden transition-colors duration-300">
    
    <!-- Dark/Light Theme Toggle Button -->
    <button id="theme-toggle" type="button" style="position: fixed !important; top: 1.25rem !important; right: 1.25rem !important; z-index: 9999 !important;" class="p-2.5 rounded-2xl bg-white/90 dark:bg-slate-800/90 border border-slate-200 dark:border-slate-700/80 text-slate-700 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400 shadow-lg backdrop-blur-md transition-all duration-300 hover:scale-105 active:scale-95 flex items-center gap-2 text-xs font-semibold">
        <!-- Sun Icon -->
        <svg id="theme-toggle-light-icon" class="w-4 h-4 text-amber-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <!-- Moon Icon -->
        <svg id="theme-toggle-dark-icon" class="w-4 h-4 text-indigo-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
        <span id="theme-toggle-text">Mode Gelap</span>
    </button>

    <!-- Animated Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="w-full max-w-4xl z-10 animate-fade-in-up my-auto">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600 dark:bg-indigo-500 text-white shadow-xl shadow-indigo-500/20 mb-4 transform transition hover:scale-105 duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white font-heading tracking-tight mb-2">Setup Poros Data</h1>
            <p class="text-slate-600 dark:text-slate-300 text-sm md:text-base font-medium max-w-md mx-auto">Lengkapi konfigurasi awal sekolah dan perbarui kredensial superadmin untuk memulai.</p>
        </div>

        <!-- Main Form Card -->
        <div class="glass-panel rounded-3xl p-6 md:p-8 relative overflow-hidden animate-fade-in-up delay-100">
            
            @if ($errors->any() || session('warning'))
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900/50 text-rose-700 dark:text-rose-300 text-sm font-medium shadow-sm flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-rose-500 mt-0.5 shrink-0">
                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        @if (session('warning'))
                            <p class="text-sm font-semibold mb-0.5">{{ session('warning') }}</p>
                        @endif
                        <ul class="list-disc pl-4 space-y-0.5 text-xs text-rose-600 dark:text-rose-300">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form id="setup-form" action="{{ route('instance-setup.process') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- FLEX CONTAINER: SIDE BY SIDE -->
                <div class="flex flex-col md:flex-row gap-8 items-stretch">
                    
                    <!-- LEFT COLUMN: Section 1 Kredensial Superadmin -->
                    <div class="flex-1 space-y-4 animate-fade-in-up delay-200">
                        <div class="flex items-center gap-2.5 border-b border-slate-200 dark:border-slate-700/80 pb-3">
                            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 font-bold text-xs">1</div>
                            <h2 class="text-base font-bold text-slate-800 dark:text-slate-100 font-heading">Kredensial Superadmin</h2>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Username Baru</label>
                                <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}" required 
                                    class="input-transition w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 outline-none text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm font-medium">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Password Baru <span class="text-slate-400 dark:text-slate-500 font-normal">(Opsional)</span></label>
                                <input type="password" name="password" placeholder="Kosongkan jika tak diubah" 
                                    class="input-transition w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 outline-none text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                                    class="input-transition w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 outline-none text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- DIVIDER LINE BETWEEN FLEX ITEMS -->
                    <div class="hidden md:block w-px bg-slate-200 dark:bg-slate-700/80 self-stretch my-1"></div>

                    <!-- RIGHT COLUMN: Section 2 Profil Instansi -->
                    <div class="flex-1 space-y-4 animate-fade-in-up delay-300">
                        <div class="flex items-center gap-2.5 border-b border-slate-200 dark:border-slate-700/80 pb-3">
                            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-purple-100 dark:bg-purple-950/80 text-purple-600 dark:text-purple-400 font-bold text-xs">2</div>
                            <h2 class="text-base font-bold text-slate-800 dark:text-slate-100 font-heading">Profil Instansi Sekolah</h2>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Nama Sekolah</label>
                                <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}" required placeholder="Contoh: SMK Negeri 1 Jakarta" 
                                    class="input-transition w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 dark:focus:border-purple-400 outline-none text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm font-medium">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Tingkat Sekolah</label>
                                <div class="relative">
                                    <select name="tingkat" required 
                                        class="input-transition w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 dark:focus:border-purple-400 outline-none text-slate-900 dark:text-white appearance-none cursor-pointer text-sm font-medium pr-10">
                                        <option value="" disabled selected>-- Pilih Tingkat Sekolah --</option>
                                        <option value="SD" {{ old('tingkat') == 'SD' ? 'selected' : '' }}>SD / MI</option>
                                        <option value="SMP" {{ old('tingkat') == 'SMP' ? 'selected' : '' }}>SMP / MTs</option>
                                        <option value="SMA" {{ old('tingkat') == 'SMA' ? 'selected' : '' }}>SMA / MA</option>
                                        <option value="SMK" {{ old('tingkat') == 'SMK' ? 'selected' : '' }}>SMK</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-500 dark:text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                <p class="mt-1.5 text-[11px] text-purple-600 dark:text-purple-400 flex items-center gap-1 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 shrink-0"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.025.025 0 01.025.025v2.25c0 .138.112.25.25.25h.5a.75.75 0 000-1.5h-.253a.025.025 0 01-.025-.025V9.75A.75.75 0 009 9z" clip-rule="evenodd" /></svg>
                                    Memilih SMK akan mengaktifkan fitur Portal PKL.
                                </p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Logo Sekolah <span class="text-slate-400 dark:text-slate-500 font-normal">(Opsional)</span></label>
                                <input type="file" name="logo" id="logo-input" accept="image/jpeg,image/png,image/jpg,image/svg+xml" 
                                    class="w-full text-xs text-slate-600 dark:text-slate-300 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-purple-100 dark:file:bg-purple-950/80 file:text-purple-700 dark:file:text-purple-300 hover:file:bg-purple-200 dark:hover:file:bg-purple-900 cursor-pointer border border-slate-300 dark:border-slate-700 rounded-xl p-1 bg-white dark:bg-slate-900 transition-colors">
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Maksimal 2MB (JPG, PNG, SVG).</p>

                                <!-- Pesan Error File -->
                                <div id="logo-error-msg" class="hidden text-[11px] text-rose-600 dark:text-rose-400 font-semibold mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span id="logo-error-text"></span>
                                </div>

                                <!-- Container Pratinjau Logo -->
                                <div id="logo-preview-container" class="hidden mt-3 p-3.5 bg-purple-50/60 dark:bg-purple-950/30 border border-purple-200 dark:border-purple-800/60 rounded-2xl transition-all duration-300">
                                    <div class="text-[11px] font-semibold text-purple-700 dark:text-purple-300 mb-2 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Pratinjau Logo Terpilih:
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="relative w-16 h-16 rounded-xl bg-white dark:bg-slate-900 border border-purple-200 dark:border-purple-800/80 overflow-hidden flex items-center justify-center shrink-0 shadow-sm">
                                            <img id="logo-preview-img" src="#" alt="Pratinjau Logo" class="max-w-full max-h-full object-contain p-1">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p id="logo-file-name" class="text-xs font-semibold text-slate-800 dark:text-slate-100 truncate"></p>
                                            <p id="logo-file-size" class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 font-medium"></p>
                                        </div>
                                        <button type="button" id="remove-logo-btn" class="p-1.5 px-2.5 rounded-xl bg-rose-100/80 dark:bg-rose-950/80 border border-rose-200 dark:border-rose-800/60 text-rose-600 dark:text-rose-400 hover:bg-rose-200/80 dark:hover:bg-rose-900/80 transition-all text-xs font-semibold shrink-0 flex items-center gap-1.5 cursor-pointer" title="Hapus Gambar">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            <span>Hapus</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="pt-6 mt-6 border-t border-slate-200 dark:border-slate-700/80 animate-fade-in-up delay-300">
                    <button type="submit" id="submit-btn" class="w-full md:w-auto md:min-w-[280px] mx-auto flex items-center justify-center gap-2 py-3.5 px-8 text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-600 dark:hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 shadow-md shadow-indigo-500/20 transition-all duration-200 active:scale-[0.98] cursor-pointer">
                        <span id="btn-text" class="flex items-center gap-2">
                            Simpan Konfigurasi & Masuk
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="text-center mt-6 text-xs text-slate-500 dark:text-slate-400 font-medium animate-fade-in-up delay-300 pb-4">
            &copy; {{ date('Y') }} Poros Data System. Dirancang dengan <span class="text-rose-500">♥</span> untuk pendidikan.
        </div>
    </div>

    <!-- Script for Theme Toggle, Image Preview & Form Loading -->
    <script>
        // Dark / Light Theme Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');
        const themeText = document.getElementById('theme-toggle-text');

        function updateThemeUI() {
            const isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                darkIcon.classList.add('hidden');
                lightIcon.classList.remove('hidden');
                themeText.textContent = 'Mode Terang';
            } else {
                lightIcon.classList.add('hidden');
                darkIcon.classList.remove('hidden');
                themeText.textContent = 'Mode Gelap';
            }
        }

        updateThemeUI();

        themeToggleBtn.addEventListener('click', function() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
            updateThemeUI();
        });

        // Logo Live Preview Logic
        const logoInput = document.getElementById('logo-input');
        const logoPreviewContainer = document.getElementById('logo-preview-container');
        const logoPreviewImg = document.getElementById('logo-preview-img');
        const logoFileName = document.getElementById('logo-file-name');
        const logoFileSize = document.getElementById('logo-file-size');
        const removeLogoBtn = document.getElementById('remove-logo-btn');
        const logoErrorMsg = document.getElementById('logo-error-msg');
        const logoErrorText = document.getElementById('logo-error-text');

        function hideLogoError() {
            logoErrorMsg.classList.add('hidden');
            logoErrorText.textContent = '';
        }

        function showLogoError(msg) {
            logoErrorText.textContent = msg;
            logoErrorMsg.classList.remove('hidden');
        }

        function resetLogoPreview() {
            logoInput.value = '';
            logoPreviewContainer.classList.add('hidden');
            logoPreviewImg.src = '#';
            logoFileName.textContent = '';
            logoFileSize.textContent = '';
            hideLogoError();
        }

        if (logoInput) {
            logoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                hideLogoError();

                if (file) {
                    // Maximum 2MB
                    const maxSize = 2 * 1024 * 1024;
                    if (file.size > maxSize) {
                        showLogoError('Ukuran file melebihi 2MB. Silakan pilih file yang lebih kecil.');
                        resetLogoPreview();
                        return;
                    }

                    // Check allowed extension / mimetype
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/svg+xml'];
                    if (!allowedTypes.includes(file.type)) {
                        showLogoError('Format file tidak didukung. Harap upload gambar JPG, PNG, atau SVG.');
                        resetLogoPreview();
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        logoPreviewImg.src = evt.target.result;
                        logoFileName.textContent = file.name;
                        
                        let formattedSize = '';
                        if (file.size >= 1024 * 1024) {
                            formattedSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                        } else {
                            formattedSize = (file.size / 1024).toFixed(1) + ' KB';
                        }
                        logoFileSize.textContent = formattedSize;

                        logoPreviewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    resetLogoPreview();
                }
            });

            if (removeLogoBtn) {
                removeLogoBtn.addEventListener('click', resetLogoPreview);
            }
        }

        // Form Submit Loading State
        const form = document.getElementById('setup-form');
        const submitBtn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');

        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
            btnText.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan...
            `;
        });
    </script>
</body>
</html>
