<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation -->
        <header class="glass-panel sticky top-0 z-30 border-b border-slate-200/80 dark:border-slate-800/80 px-6 py-4 flex items-center justify-between">
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
                <span class="text-xs font-semibold px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    Login: <span class="font-bold text-blue-600 dark:text-blue-400 capitalize">{{ str_replace('_', ' ', $user->role ?? 'admin') }}</span>
                </span>
                <form action="{{ route('portalnilai.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-rose-600 dark:text-rose-400 bg-rose-50/50 dark:bg-rose-950/20 hover:bg-rose-50 dark:hover:bg-rose-950/40 border border-rose-100 dark:border-rose-950/30 hover:border-rose-200 dark:hover:border-rose-900/50 active:scale-[0.98] transition-all cursor-pointer">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-8 max-w-4xl w-full mx-auto flex items-center justify-center">
            <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 shadow-xl rounded-3xl p-8 sm:p-12 text-center max-w-xl space-y-6">
                <div class="h-20 w-20 rounded-full bg-blue-100 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center mx-auto shadow-md">
                    <i class="fa-solid fa-circle-check text-4xl"></i>
                </div>
                <div class="space-y-2">
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-800 dark:text-slate-100">
                        Login Berhasil!
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">
                        Anda telah berhasil masuk ke Portal Penilaian sebagai <span class="font-bold text-slate-700 dark:text-slate-300">{{ $user->name ?? 'User Dummy' }}</span> ({{ $user->username ?? 'admin_nilai' }}).
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800/80 text-left">
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-3">Detail Akun Ujicoba</h3>
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 dark:text-slate-500 block font-medium">Nama</span>
                            <span class="text-slate-800 dark:text-slate-200 font-bold">{{ $user->name ?? 'Administrator Dummy' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 dark:text-slate-500 block font-medium">Username</span>
                            <span class="text-slate-800 dark:text-slate-200 font-mono font-bold">{{ $user->username ?? 'admin_nilai' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 dark:text-slate-500 block font-medium">Role Aplikasi</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 border border-blue-200/50 dark:border-blue-900/30 capitalize">
                                {{ str_replace('_', ' ', $user->role ?? 'admin') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
