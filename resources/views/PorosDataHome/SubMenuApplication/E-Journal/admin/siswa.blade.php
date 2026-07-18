@extends('PorosDataHome.SubMenuApplication.E-Journal.layouts.app')

@section('title', 'Kelola Siswa')
@section('subtitle', 'Daftar Siswa Sekolah')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header Page -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight bg-gradient-to-r from-blue-600 to-indigo-500 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-300">
            Kelola Siswa
        </h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
            Daftar siswa aktif di lingkungan sekolah. Pengelolaan data siswa hanya dapat dilakukan melalui portal utama PorosData.
        </p>
    </div>

    <!-- Alert Banner -->
    <div class="mb-6 p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/20 border border-amber-100 dark:border-amber-900/30 flex items-start gap-3">
        <div class="h-6 w-6 rounded-lg bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 mt-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.008v.008H12v-.008Z" />
            </svg>
        </div>
        <div>
            <span class="block text-xs font-bold text-amber-800 dark:text-amber-300">Mode Read-Only Aktif</span>
            <span class="block text-xs text-amber-650 dark:text-amber-455 mt-0.5">Data siswa tersinkronisasi langsung dari database PorosData. Hubungi administrator utama untuk melakukan perubahan data.</span>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-3xl shadow-md p-6 mb-6">
        <form action="{{ route('ejournal.admin.siswa') }}" method="GET" id="filter-form" class="max-w-md">
            <div>
                <label for="kelas_id" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Filter Berdasarkan Kelas
                </label>
                <select name="kelas_id" id="kelas_id" onchange="this.form.submit()"
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-semibold cursor-pointer">
                    <option value="" class="bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" class="bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200" {{ $kelasId == $class->id ? 'selected' : '' }}>
                            {{ $class->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-3xl shadow-xl overflow-hidden transition-all duration-300">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100/50 dark:bg-slate-900/60 border-b border-slate-200/80 dark:border-slate-800/80">
                        <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 w-16 text-center">No</th>
                        <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Nama Siswa</th>
                        <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Kelas</th>
                        <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 w-48 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/60 dark:divide-slate-800/60">
                    @forelse($students as $index => $student)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                            <!-- No -->
                            <td class="px-6 py-4 text-sm font-bold text-slate-400 dark:text-slate-500 text-center whitespace-nowrap">
                                {{ $index + 1 }}
                            </td>
                            <!-- Nama Siswa -->
                            <td class="px-6 py-4 text-sm font-bold text-slate-800 dark:text-slate-200 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span>{{ $student->user->name ?? 'Siswa' }}</span>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-semibold font-mono">NISN: {{ $student->nisn }}</span>
                                </div>
                            </td>
                            <!-- Kelas -->
                            <td class="px-6 py-4 text-sm font-bold text-slate-650 dark:text-slate-350 whitespace-nowrap">
                                {{ $student->kelas->nama_kelas ?? '-' }}
                            </td>
                            <!-- Aksi -->
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold text-slate-500 bg-slate-100 dark:bg-slate-800/50 dark:text-slate-400 border border-slate-200/50 dark:border-slate-700/30">
                                    Hubungi administrator
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center text-slate-400 dark:text-slate-500 font-semibold text-sm">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="h-12 w-12 rounded-2xl bg-slate-100 dark:bg-slate-800/60 flex items-center justify-center text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </div>
                                    <span>Tidak ada data siswa yang ditemukan untuk kelas ini.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
