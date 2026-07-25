@extends('PorosDataHome.layouts.app')

@section('title', 'Riwayat Kelulusan')

@section('content')
    <!-- Information Panel -->
    <div class="mb-8 p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 shadow-sm">
        <div class="flex items-start gap-4">
            <div class="h-10 w-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Modul Riwayat Kelulusan</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-1 leading-relaxed">
                    Halaman ini menampilkan daftar siswa yang telah lulus (alumni). Anda dapat melihat data alumni berdasarkan pencarian nama atau NISN. Anda juga dapat menghapus data alumni dari sistem.
                </p>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-950 dark:text-white">Riwayat Kelulusan</h1>
        <p class="text-slate-400 dark:text-slate-500 text-xs font-semibold mt-0.5">Daftar siswa alumni</p>
    </div>

    <!-- Search and Filter Bar -->
    <form method="GET" action="{{ route('siswa.riwayat_lulus') }}" class="p-4 mb-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 shadow-sm flex flex-col lg:flex-row gap-4 items-center justify-between">
        <div class="relative w-full shrink-0" style="max-width: 240px;">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4.5 h-4.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.637 10.637Z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ $search }}" onkeydown="if(event.key === 'Enter') this.form.submit();" placeholder="Cari nama atau NISN..." class="block w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800/60 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500/20 text-slate-800 dark:text-slate-100">
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto justify-end">
            <select name="kelas_id" onchange="this.form.submit()" class="w-full sm:w-48 px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800/60 rounded-xl text-xs text-slate-600 dark:text-slate-400 cursor-pointer" style="min-width: 240px;">
                <option value="">Semua Kelas</option>
                @foreach($classes as $kelas)
                    <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                @endforeach
            </select>
            <select name="angkatan" onchange="this.form.submit()" class="w-full sm:w-48 px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800/60 rounded-xl text-xs text-slate-600 dark:text-slate-400 cursor-pointer" style="min-width: 240px;">
                <option value="">Semua Angkatan</option>
                @foreach($angkatans as $akt)
                    <option value="{{ $akt }}" {{ $angkatan == $akt ? 'selected' : '' }}>{{ $akt }}</option>
                @endforeach
            </select>
            
            <div class="flex gap-2 w-full sm:w-auto">
                @if($search || $kelasId || $angkatan)
                    <a href="{{ route('siswa.riwayat_lulus') }}" class="w-full sm:w-auto px-4 py-2 bg-rose-50 hover:bg-rose-100 dark:bg-rose-500/10 dark:hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 rounded-xl text-xs font-semibold transition-colors text-center whitespace-nowrap border border-rose-200 dark:border-rose-500/20">
                        Reset Filter
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Log Table -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-16 text-center">No</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Siswa</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">NISN</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 text-center">Kelas Terakhir</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 text-center">Angkatan</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($siswas as $index => $siswa)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                            <td class="py-4 px-6 text-sm text-slate-500 text-center font-medium">{{ $siswas->firstItem() + $index }}</td>
                            <td class="py-4 px-6">
                                <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ $siswa->user->name ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-6 text-sm font-mono text-slate-600 dark:text-slate-300">{{ $siswa->nisn }}</td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                    {{ $siswa->kelas->nama_kelas ?? 'Tanpa Kelas' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center text-sm font-semibold text-slate-700 dark:text-slate-300">
                                {{ $siswa->angkatan ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data alumni ini? Tindakan ini tidak dapat dibatalkan.')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors" title="Hapus Data">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto mb-3 text-slate-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v-3.375" />
                                </svg>
                                <p class="text-sm font-semibold">Belum ada riwayat kelulusan</p>
                                <p class="text-xs mt-1">Siswa yang berstatus lulus akan muncul di sini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Area -->
        @if($siswas->hasPages())
            <div class="px-6 py-4.5 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/60">
                {{ $siswas->appends(request()->query())->links() }}
            </div>
        @else
            <div class="px-6 py-4.5 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between">
                <span class="text-[11px] font-semibold text-slate-400">Menampilkan {{ $siswas->count() }} dari {{ $siswas->total() }} riwayat lulus</span>
            </div>
        @endif
    </div>
@endsection
