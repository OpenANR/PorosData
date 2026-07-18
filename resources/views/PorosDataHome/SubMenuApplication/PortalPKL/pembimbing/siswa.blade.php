@extends('PorosDataHome.SubMenuApplication.PortalPKL.layouts.app')

@section('title', 'Kelola Siswa PKL')

@section('content')
    <!-- Page Heading -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Kelola Siswa PKL</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar siswa peserta PKL bimbingan Anda dan penempatan industrinya</p>
    </div>

    <!-- Actions Bar & Search -->
    <div class="mb-6">
        <form method="GET" action="{{ route('portalpkl.pembimbing.siswa') }}" class="w-full sm:w-80 relative">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, username, atau NISN..."
                class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </div>
            @if($search)
                <a href="{{ route('portalpkl.pembimbing.siswa') }}" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Table of Siswa PKL -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-16 text-center">No</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Siswa</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Username</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Password</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Kelas</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Tempat PKL</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Pembimbing</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($siswas as $index => $siswa)
                        @php
                            $pembimbing = $siswa->mitra?->pembimbings?->first();
                        @endphp
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                            <td class="py-4 px-6 text-sm text-slate-500 text-center font-medium">
                                {{ $siswas->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-6 text-sm">
                                <div class="font-bold text-slate-900 dark:text-white">{{ $siswa->user->name }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">NISN: {{ $siswa->nisn }}</div>
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-300">
                                {{ $siswa->user->username }}
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-400 font-mono">
                                ••••••••
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-300 font-semibold">
                                {{ $siswa->kelas->nama_kelas ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-sm">
                                @if($siswa->mitra)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200/30 dark:border-orange-900/30">
                                        <i class="fa-solid fa-building text-[10px]"></i>
                                        {{ $siswa->mitra->nama_perusahaan }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-medium bg-slate-50 dark:bg-slate-800/40 text-slate-400 dark:text-slate-500 border border-slate-200/30 dark:border-slate-800/30">
                                        <i class="fa-solid fa-circle-question text-[10px]"></i>
                                        Belum ditentukan
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-sm">
                                @if($pembimbing)
                                    <div>
                                        <span class="font-bold text-slate-800 dark:text-slate-200 block">{{ $pembimbing->name }}</span>
                                        <span class="text-xs text-slate-400 font-mono mt-0.5 block">ID: {{ $pembimbing->id_pembimbing }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 italic">Belum ditentukan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center text-slate-400">
                                <i class="fa-solid fa-user-graduate text-3xl mb-3 text-slate-300 dark:text-slate-700"></i>
                                <p class="text-sm font-semibold">Belum ada data Siswa PKL bimbingan Anda</p>
                                <p class="text-xs text-slate-400 mt-1">Siswa akan muncul setelah ditempatkan pada Mitra DUDI bimbingan Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($siswas->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">{{ $siswas->links() }}</div>
        @endif
    </div>
@endsection
