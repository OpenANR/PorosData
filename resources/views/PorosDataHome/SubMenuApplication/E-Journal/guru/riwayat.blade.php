@extends('PorosDataHome.SubMenuApplication.E-Journal.layouts.app')

@section('title', 'Riwayat Jurnal Saya')
@section('subtitle', 'Riwayat Pengiriman Jurnal Pembelajaran')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight bg-gradient-to-r from-blue-600 to-indigo-500 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-300">
                Riwayat Jurnal Saya
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Daftar rekapan jurnal mengajar dan kehadiran siswa yang telah Anda kirimkan.
            </p>
        </div>

        <a href="{{ route('ejournal.guru.riwayat') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-800 dark:hover:text-slate-250 transition-all shadow-sm cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
            Refresh
        </a>
    </div>

    <!-- Filters Section -->
    <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-3xl shadow-md p-6 mb-6">
        <form action="{{ route('ejournal.guru.riwayat') }}" method="GET" id="filter-form">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Filter Kelas -->
                <div>
                    <label for="kelas_id" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Filter Berdasarkan Kelas
                    </label>
                    <select name="kelas_id" id="kelas_id" onchange="this.form.submit()"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-semibold cursor-pointer">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $kelasId == $class->id ? 'selected' : '' }}>
                                {{ $class->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Mata Pelajaran -->
                <div>
                    <label for="mata_pelajaran" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Filter Berdasarkan Mata Pelajaran
                    </label>
                    <select name="mata_pelajaran" id="mata_pelajaran" onchange="this.form.submit()"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-semibold cursor-pointer">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}" {{ $mataPelajaran == $subject ? 'selected' : '' }}>
                                {{ $subject }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($kelasId || $mataPelajaran)
                <div class="mt-4 flex justify-end">
                    <a href="{{ route('ejournal.guru.riwayat') }}"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/20 border border-rose-100 dark:border-rose-900/30 hover:bg-rose-100 dark:hover:bg-rose-950/40 transition-all shadow-sm cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                        Reset Filter
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-3xl shadow-xl overflow-hidden transition-all duration-300">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100/50 dark:bg-slate-900/60 border-b border-slate-200/80 dark:border-slate-800/80">
                        <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Tanggal</th>
                        <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Kelas</th>
                        <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Mapel</th>
                        <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Materi</th>
                        <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Absensi (A/I/S/P)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-150 dark:divide-slate-850">
                    @forelse($journals as $journal)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                            <!-- Tanggal -->
                            <td class="px-6 py-4 text-xs font-medium text-slate-500 whitespace-nowrap">
                                {{ $journal->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <!-- Kelas -->
                            <td class="px-6 py-4 text-sm font-bold text-slate-800 dark:text-slate-200 whitespace-nowrap">
                                {{ $journal->kelas->nama_kelas ?? '-' }}
                            </td>
                            <!-- Mapel -->
                            <td class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-350 whitespace-nowrap">
                                {{ $journal->mata_pelajaran }}
                            </td>
                            <!-- Materi -->
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-450 italic">
                                {{ $journal->materi }}
                            </td>
                            <!-- Absensi -->
                            <td class="px-6 py-4">
                                @php
                                    $absents = $journal->attendances->filter(function($att) {
                                        return $att->status !== 'Hadir';
                                    });
                                @endphp

                                @if($absents->isEmpty())
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-extrabold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100/50 dark:border-emerald-950/20">
                                        Nihil (Semua Hadir)
                                    </span>
                                @else
                                    <span class="text-xs font-bold text-rose-600 dark:text-rose-400 leading-relaxed block max-w-xs break-words">
                                        {{ $absents->map(function($att) {
                                            $name = $att->siswa->user->name ?? 'Siswa';
                                            return $name . ' (' . $att->status . ')';
                                        })->implode(' | ') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-slate-400 dark:text-slate-500 font-semibold text-sm">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="h-12 w-12 rounded-2xl bg-slate-100 dark:bg-slate-800/60 flex items-center justify-center text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                        </svg>
                                    </div>
                                    @if($kelasId || $mataPelajaran)
                                        <span>Tidak ada riwayat jurnal yang cocok dengan filter yang dipilih.</span>
                                    @else
                                        <span>Belum ada riwayat jurnal yang Anda kirimkan.</span>
                                    @endif
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
