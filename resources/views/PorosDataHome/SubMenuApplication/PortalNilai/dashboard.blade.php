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
    </style>
</head>
<body class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased transition-colors duration-300 flex flex-col">

    <!-- Top Navigation Header -->
    <header class="glass-panel sticky top-0 z-50 border-b border-slate-200/80 dark:border-slate-800/80 px-6 py-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-bold shadow-md shadow-blue-200 dark:shadow-none">
                <i class="fa-solid fa-graduation-cap text-lg"></i>
            </div>
            <div>
                <span class="font-bold text-lg leading-tight block bg-gradient-to-r from-blue-600 to-indigo-500 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-300">Portal Penilaian</span>
                <span class="text-[9px] text-slate-400 font-semibold block uppercase tracking-wider">SMK Teknologi Balung</span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <div class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $user->name ?? 'Administrator Dummy' }}</div>
                <div class="text-xs text-slate-400 capitalize">{{ str_replace('_', ' ', $user->role ?? 'admin') }}</div>
            </div>
            <!-- Theme Toggle -->
            <button id="theme-toggle" class="p-2 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-900 transition-all cursor-pointer">
                <i id="theme-toggle-light-icon" class="fa-regular fa-sun hidden"></i>
                <i id="theme-toggle-dark-icon" class="fa-regular fa-moon"></i>
            </button>
            <form action="{{ route('portalnilai.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-rose-600 dark:text-rose-400 bg-rose-50/50 dark:bg-rose-950/20 hover:bg-rose-50 dark:hover:bg-rose-950/40 border border-rose-100 dark:border-rose-950/30 hover:border-rose-200 dark:hover:border-rose-900/50 active:scale-[0.98] transition-all cursor-pointer">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-grow max-w-7xl w-full mx-auto p-4 md:p-6 flex flex-col gap-6">

        <!-- Toast Notifications -->
        <div id="toast-container" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-[999999] flex flex-col items-center pointer-events-none w-full max-w-sm px-4"></div>

        <!-- ======================= PENGATURAN JADWAL AKSES (ADMIN ONLY) ======================= -->
        @if(in_array($user->role ?? 'admin', ['admin', 'superadmin']))
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
                    <input type="datetime-local" id="admin-tugas-buka" class="w-full px-4.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-amber-600 dark:text-amber-400">Tutup Edit Tugas & ASTS</label>
                    <input type="datetime-local" id="admin-tugas-tutup" class="w-full px-4.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-1">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-blue-600 dark:text-blue-400">Buka Edit ASAS GENAP</label>
                    <input type="datetime-local" id="admin-waktu-buka" class="w-full px-4.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-blue-600 dark:text-blue-400">Tutup Edit ASAS GENAP</label>
                    <input type="datetime-local" id="admin-waktu-tutup" class="w-full px-4.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                </div>
            </div>

            <div class="flex justify-end mt-2">
                <button onclick="saveAdminSettings()" id="btn-save-settings" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 dark:bg-blue-700 dark:hover:bg-blue-600 text-white font-bold text-xs shadow-md shadow-blue-500/15 dark:shadow-none hover:shadow-xl hover:shadow-blue-500/25 active:scale-[0.98] transition-all flex items-center gap-2 cursor-pointer">
                    <span>Simpan Jadwal Akses</span>
                    <div id="settings-loader" class="loader hidden"></div>
                </button>
            </div>
        </div>
        @endif

        <!-- ======================= PANEL PEMILIHAN DATA (DINAMIS) ======================= -->
        <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm flex flex-col md:flex-row gap-4 items-end shrink-0">
            <div class="w-full md:w-1/3 space-y-1.5">
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400">Pilih Kelas</label>
                <div class="relative">
                    <select id="select-kelas" class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:border-blue-500 transition-all focus:outline-none focus:ring-4 focus:ring-blue-500/10 appearance-none cursor-pointer">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classes as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
            </div>
            
            <div class="w-full md:w-1/3 space-y-1.5" id="mapel-container">
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400">Pilih Mata Pelajaran</label>
                <div class="relative">
                    <select id="select-mapel" class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:border-blue-500 transition-all focus:outline-none focus:ring-4 focus:ring-blue-500/10 appearance-none cursor-pointer">
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/3">
                <button onclick="loadStudents()" id="btn-load" class="w-full bg-emerald-600 hover:bg-emerald-500 dark:bg-emerald-700 dark:hover:bg-emerald-600 text-white font-bold py-2.5 px-4 rounded-xl flex justify-center items-center gap-2 h-[38px] shadow-md shadow-emerald-500/15 dark:shadow-none hover:shadow-xl active:scale-[0.98] transition-all cursor-pointer text-xs">
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
        <div id="table-container" class="hidden flex-col flex-grow bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm">
            
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
                <div class="relative">
                    <select id="global-asas-mode" onchange="recalculateAll()" class="px-4 py-2 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 font-bold text-xs text-blue-800 dark:text-blue-400 outline-none focus:ring-4 focus:ring-blue-500/10 cursor-pointer appearance-none pr-8">
                        <option value="Benar">Tulis Benar</option>
                        <option value="Salah">Tulis Salah</option>
                        <option value="FastTrack">Fast Track (Ketik Jumlah Benar)</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-blue-600 dark:text-blue-400">
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
            <div class="bg-slate-50 dark:bg-slate-900 border-t border-slate-200/60 dark:border-slate-800/60 p-4 flex flex-col sm:flex-row justify-between items-center gap-4 sticky left-0 bottom-0 z-30 shadow-inner shrink-0">
                <div class="text-[10px] text-slate-400 dark:text-slate-500 hidden sm:block leading-relaxed">
                    <span class="font-bold text-rose-500">* Tugas 1, 2, & ASTS diambil dari sistem akademik pusat.</span><br>
                    <span class="text-blue-600 dark:text-blue-400">Untuk PG bisa ketik 'salah semua' atau 'benar semua'. Gunakan tombol 'Enter' untuk berpindah baris ke bawah dengan cepat.</span>
                </div>
                <button onclick="saveGrades()" id="btn-save" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 dark:bg-blue-700 dark:hover:bg-blue-600 text-white font-bold text-xs shadow-md shadow-blue-500/15 dark:shadow-none hover:shadow-xl active:scale-[0.98] transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fa-regular fa-floppy-disk"></i>
                    <span>Simpan Seluruh Nilai</span>
                    <div id="save-loader" class="loader hidden"></div>
                </button>
            </div>
        </div>

    </main>

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

        // Custom Toast Notification
        function showToast(message, type = "info") {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            let icon = '<i class="fa-solid fa-circle-info"></i>';
            let bgClass = "bg-blue-600 dark:bg-blue-700";

            if (type === "success") {
                bgClass = "bg-emerald-600 dark:bg-emerald-700";
                icon = '<i class="fa-solid fa-circle-check"></i>';
            } else if (type === "error") {
                bgClass = "bg-rose-600 dark:bg-rose-700";
                icon = '<i class="fa-solid fa-circle-exclamation"></i>';
            } else if (type === "warning") {
                bgClass = "bg-amber-500 dark:bg-amber-600";
                icon = '<i class="fa-solid fa-triangle-exclamation"></i>';
            }

            toast.className = `${bgClass} text-white px-5 py-3.5 rounded-2xl shadow-xl flex items-center gap-3 mb-3 transform transition-all duration-300 -translate-y-full opacity-0 pointer-events-auto text-xs font-semibold`;
            toast.innerHTML = `${icon} <span>${message}</span>`;
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('-translate-y-full', 'opacity-0');
            }, 10);

            setTimeout(() => {
                toast.classList.add('-translate-y-full', 'opacity-0');
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
            const adminPanel = document.getElementById('admin-panel');
            if (adminPanel) {
                fetchAdminSettings();
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
            currentMapel = document.getElementById('select-mapel').value;

            if (!currentClass) return showToast("Pilih Kelas terlebih dahulu!", "warning");
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

            const isProduktif = currentMapelType.toLowerCase() === "praktik" || currentMapelType.toLowerCase() === "produktif";
            let modeGlobalInit = document.getElementById('global-asas-mode') ? document.getElementById('global-asas-mode').value.toLowerCase() : "benar";

            // Hide PG/Essai controls for Praktik
            const modeContainer = document.getElementById('asas-mode-container');
            if (isProduktif) {
                modeContainer.classList.add('hidden');
            } else {
                modeContainer.classList.remove('hidden');
            }

            // Headers Setup
            const isTugasEditable = (currentRole === "Admin" || currentRole === "superadmin" || isAksesTugasBuka);
            let pgWidthClass = modeGlobalInit === 'fasttrack' ? 'w-32 min-w-[128px]' : 'w-[280px] min-w-[280px]';
            let thPG = isProduktif ? '' : `<th id="th-pg" class="px-4 py-4 ${pgWidthClass} text-center border-r border-b dark:border-slate-800 bg-blue-100/60 dark:bg-slate-800/80 text-blue-900 dark:text-blue-400 font-bold sticky top-0 z-40 transition-all duration-300" title="Ketik: salah semua / benar semua / Fast Track">Input PG ASAS GENAP</th>`;
            
            let thES = isProduktif ? '' : `
                <th class="px-2 py-4 min-w-[240px] text-center border-r border-b dark:border-slate-800 bg-blue-100/60 dark:bg-slate-800/80 text-blue-900 dark:text-blue-400 font-bold sticky top-0 z-40">
                    <div>Input Essai (Per Soal)</div>
                    <div class="text-[8px] text-blue-600 dark:text-blue-500 font-semibold normal-case mt-1">Pilih skor: 8 (Benar) \| 4 (Sebagian) \| 2 (Ongkos) \| 0</div>
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
                            <span class="text-[8px] text-slate-400 font-bold mb-[2px]">N${qNum}</span>
                            <select id="es${qNum}_${sId}" onchange="updateEsString('${sId}')" class="w-[38px] h-[26px] text-[10px] rounded border border-blue-200 dark:border-slate-700 outline-none focus:border-blue-500 bg-white dark:bg-slate-800 font-bold text-blue-900 dark:text-blue-300 text-center cursor-pointer select-hide-arrow hover:bg-blue-50/50 transition">
                                ${optionsHtml}
                            </select>
                        </div>
                    `;
                };

                let tdPG = isProduktif ? '' : `<td class="px-2 py-3 border-r dark:border-slate-800/80 bg-blue-50/10"><input type="text" id="pg_${sId}" class="w-full p-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-center outline-none focus:border-blue-500 text-xs font-semibold" placeholder="${pgPlaceholder}" value="${pgAsasVal}" oninput="calculateMurni('${sId}')" onkeydown="handleEnter(event, 'pg', ${index})"></td>`;
                
                let tdES = isProduktif ? '' : `
                    <td class="px-2 py-2 border-r dark:border-slate-800/80 bg-blue-50/5 dark:bg-slate-900/10">
                        <input type="hidden" id="es_${sId}" value="${esAsasVal}">
                        <div class="flex justify-center gap-[4px]">
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
                let murniOninput = isProduktif ? `oninput="calculateAkhir('${sId}')"` : '';
                let tdMurni = `<td class="px-2 py-3 border-r dark:border-slate-800/80 bg-blue-100/10"><input type="number" id="murni_${sId}" class="w-full text-center p-2 font-bold text-blue-700 dark:text-blue-400 outline-none rounded-lg ${murniClass}" value="${siswa.murni_asas ?? '0'}" ${murniReadonly} ${murniOninput} onkeydown="handleEnter(event, 'murni', ${index})"></td>`;

                let tdPerbaikan = isProduktif ? '' : `<td class="px-2 py-3 border-r dark:border-slate-800/80 bg-rose-50/10"><input type="number" id="perbaikan_${sId}" class="w-full text-center p-2 rounded-lg border border-slate-200 dark:border-slate-700 outline-none focus:border-rose-500 text-rose-600 dark:text-rose-400 font-bold bg-white dark:bg-slate-800 text-xs" value="${siswa.perbaikan ?? ''}" oninput="calculateAkhir('${sId}')" onkeydown="handleEnter(event, 'perbaikan', ${index})"></td>`;

                tr.innerHTML = `
                    <td class="px-4 py-3 text-center border-r dark:border-slate-800/80 font-medium sticky left-0 bg-white dark:bg-slate-900 z-10 text-slate-400">${index + 1}</td>
                    <td class="px-4 py-3 border-r dark:border-slate-800/80 sticky left-[48px] bg-white dark:bg-slate-900 z-10 font-bold shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] truncate max-w-[280px]" title="${siswa.nama}">${siswa.nama}<div class="text-[10px] font-semibold text-slate-400 mt-0.5">${siswa.nisn || '-'}</div></td>
                    
                    <td class="px-2 py-3 border-r dark:border-slate-800/80 ${tdTugasClass}"><input type="number" id="t1_${sId}" class="w-full text-center p-2 rounded-lg outline-none text-xs font-semibold ${tugasClass}" value="${siswa.tugas_1 ?? ''}" oninput="calculateAkhir('${sId}')" onkeydown="handleEnter(event, 't1', ${index})" ${tugasReadonly}></td>
                    <td class="px-2 py-3 border-r dark:border-slate-800/80 ${tdTugasClass}"><input type="number" id="t2_${sId}" class="w-full text-center p-2 rounded-lg outline-none text-xs font-semibold ${tugasClass}" value="${siswa.tugas_2 ?? ''}" oninput="calculateAkhir('${sId}')" onkeydown="handleEnter(event, 't2', ${index})" ${tugasReadonly}></td>
                    <td class="px-2 py-3 border-r dark:border-slate-800/80 ${tdTugasClass}"><input type="number" id="asts_${sId}" class="w-full text-center p-2 rounded-lg outline-none text-xs font-bold ${isTugasEditable ? 'text-slate-800 dark:text-slate-100 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-blue-500 cursor-text' : 'text-slate-600 dark:text-slate-400 admin-readonly cursor-not-allowed border border-transparent'}" value="${siswa.asts ?? ''}" oninput="calculateAkhir('${sId}')" onkeydown="handleEnter(event, 'asts', ${index})" ${tugasReadonly}></td>
                    
                    <td class="px-2 py-3 border-r dark:border-slate-800/80 bg-amber-50/5 dark:bg-slate-900/5"><input type="number" id="t4_${sId}" class="w-full text-center p-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 outline-none focus:border-blue-500 text-xs font-semibold cursor-text" value="${siswa.tugas_4 ?? ''}" oninput="calculateAkhir('${sId}')" onkeydown="handleEnter(event, 't4', ${index})"></td>
                    <td class="px-2 py-3 border-r dark:border-slate-800/80 bg-amber-50/5 dark:bg-slate-900/5"><input type="number" id="t5_${sId}" class="w-full text-center p-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 outline-none focus:border-blue-500 text-xs font-semibold cursor-text" value="${siswa.tugas_5 ?? ''}" oninput="calculateAkhir('${sId}')" onkeydown="handleEnter(event, 't5', ${index})"></td>
                    
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
