@extends('PorosDataHome.layouts.app')

@section('title', 'Kelola Guru')

@section('content')
    <!-- Page Heading -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Kelola Guru</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $sd ? $sd->nama_sekolah : 'Sekolah SD' }} — Manajemen data guru pengajar</p>
    </div>

    <!-- Actions Bar -->
    <div class="mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('guru.index') }}" class="w-full sm:w-80 relative">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau username..."
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
            <div class="absolute left-3.5 top-3 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.608 10.608Z" />
                </svg>
            </div>
            @if($search)
                <a href="{{ route('guru.index') }}" class="absolute right-3 top-3 text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </a>
            @endif
        </form>

        <button id="btn-buka-create" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-100 dark:shadow-none transition-colors flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Guru
        </button>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/20 border border-rose-200/50 dark:border-rose-900/50 text-rose-800 dark:text-rose-400">
            <p class="font-bold text-sm mb-1">Gagal menyimpan data:</p>
            <ul class="list-disc pl-5 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-16 text-center">No</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Kode DUK</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Lengkap</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Username</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Mata Pelajaran</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Kelas</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($gurus as $index => $guru)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                            <td class="py-4 px-6 text-sm text-slate-500 text-center font-medium">{{ $gurus->firstItem() + $index }}</td>
                            <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-300 font-mono">{{ $guru->duk ?: '—' }}</td>
                            <td class="py-4 px-6 text-sm font-semibold text-slate-900 dark:text-white">{{ $guru->name }}</td>
                            <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-300">{{ $guru->username }}</td>
                            <td class="py-4 px-6 text-sm">
                                <div class="flex flex-wrap gap-1 max-w-xs">
                                    @forelse($guru->guru_mapel as $mapel)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-900/50">
                                            {{ $mapel->nama_mapel }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400">—</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-4 px-6 text-sm">
                                <div class="flex flex-wrap gap-1 max-w-xs">
                                    @forelse($guru->guru_kelas as $kelas)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-900/50">
                                            {{ $kelas->nama_kelas }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400">—</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <button onclick="bukaEditModal('{{ $guru->id }}', '{{ addslashes($guru->name) }}', '{{ $guru->username }}', '{{ $guru->duk }}', '{{ addslashes($guru->password_plain ?? 'password123') }}', [{{ $guru->guru_kelas->pluck('id')->implode(',') }}], [{{ $guru->guru_mapel->pluck('id')->implode(',') }}])"
                                        class="p-2 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-colors" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('guru.destroy', $guru->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus data guru ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto mb-3 text-slate-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                </svg>
                                <p class="text-sm font-semibold">Belum ada data guru</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($gurus->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">{{ $gurus->links() }}</div>
        @endif
    </div>

    <!-- ===================== MODAL TAMBAH ===================== -->
    <div id="modal-create" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-create" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800">
            <form action="{{ route('guru.store') }}" method="POST">
                @csrf
                <input type="hidden" name="role" value="guru">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Tambah Guru Baru</h3>
                        <button type="button" id="btn-tutup-create" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column: Personal Info & Account Details -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                                <input type="text" name="name" required placeholder="Contoh: Budi Santoso, M.Pd"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Kode DUK (Opsional)</label>
                                <input type="text" name="duk" placeholder="Contoh: 199006152015041002"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Username</label>
                                <input type="text" name="username" required placeholder="Contoh: budisantoso"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Peran</label>
                                    <select disabled class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 text-sm cursor-not-allowed text-slate-500">
                                        <option value="guru" selected>Guru</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                                    <input type="text" name="password" required placeholder="Minimal 6 karakter"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors">
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Assignments -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Mata Pelajaran Yang Diajar</label>
                                <div class="border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 rounded-xl p-3 h-[130px] overflow-y-auto space-y-2">
                                    @forelse($mapels as $mapel)
                                        <label class="flex items-center gap-2.5 cursor-pointer text-sm text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                            <input type="checkbox" name="mapel_ids[]" value="{{ $mapel->id }}"
                                                class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 bg-white dark:bg-slate-900">
                                            <span>{{ $mapel->nama_mapel }}</span>
                                        </label>
                                    @empty
                                        <p class="text-xs text-slate-400">Belum ada mata pelajaran</p>
                                    @endforelse
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Kelas Yang Diajar</label>
                                <div class="border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 rounded-xl p-3 h-[130px] overflow-y-auto space-y-2">
                                    @forelse($classes as $kelas)
                                        <label class="flex items-center gap-2.5 cursor-pointer text-sm text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                            <input type="checkbox" name="kelas_ids[]" value="{{ $kelas->id }}"
                                                class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 bg-white dark:bg-slate-900">
                                            <span>{{ $kelas->nama_kelas }}</span>
                                        </label>
                                    @empty
                                        <p class="text-xs text-slate-400">Belum ada kelas</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" id="btn-batal-create" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition-colors">Simpan Guru</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===================== MODAL EDIT ===================== -->
    <div id="modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-edit" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800">
            <form id="form-edit" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="role" value="guru">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Ubah Data Guru</h3>
                        <button type="button" id="btn-tutup-edit" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column: Personal Info & Account Details -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                                <input type="text" name="name" id="edit-name" required placeholder="Contoh: Budi Santoso, M.Pd"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Kode DUK (Opsional)</label>
                                <input type="text" name="duk" id="edit-duk" placeholder="Contoh: 199006152015041002"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Username</label>
                                <input type="text" name="username" id="edit-username" required placeholder="Contoh: budisantoso"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Peran</label>
                                    <select disabled class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 text-sm cursor-not-allowed text-slate-500">
                                        <option value="guru" selected>Guru</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                                    <input type="text" name="password" id="edit-password" required placeholder="Kata Sandi Guru"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-colors">
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Assignments -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Mata Pelajaran Yang Diajar</label>
                                <div class="border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 rounded-xl p-3 h-[130px] overflow-y-auto space-y-2">
                                    @forelse($mapels as $mapel)
                                        <label class="flex items-center gap-2.5 cursor-pointer text-sm text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                            <input type="checkbox" name="mapel_ids[]" value="{{ $mapel->id }}"
                                                class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 bg-white dark:bg-slate-900">
                                            <span>{{ $mapel->nama_mapel }}</span>
                                        </label>
                                    @empty
                                        <p class="text-xs text-slate-400">Belum ada mata pelajaran</p>
                                    @endforelse
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Kelas Yang Diajar</label>
                                <div class="border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 rounded-xl p-3 h-[130px] overflow-y-auto space-y-2">
                                    @forelse($classes as $kelas)
                                        <label class="flex items-center gap-2.5 cursor-pointer text-sm text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                            <input type="checkbox" name="kelas_ids[]" value="{{ $kelas->id }}"
                                                class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 bg-white dark:bg-slate-900">
                                            <span>{{ $kelas->nama_kelas }}</span>
                                        </label>
                                    @empty
                                        <p class="text-xs text-slate-400">Belum ada kelas</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" id="btn-batal-edit" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function bukaModal(id) {
        const el = document.getElementById(id);
        el.classList.remove('hidden');
        el.classList.add('flex');
    }
    function tutupModal(id) {
        const el = document.getElementById(id);
        el.classList.add('hidden');
        el.classList.remove('flex');
    }

    document.getElementById('btn-buka-create').addEventListener('click', () => bukaModal('modal-create'));
    document.getElementById('btn-tutup-create').addEventListener('click', () => tutupModal('modal-create'));
    document.getElementById('btn-batal-create').addEventListener('click', () => tutupModal('modal-create'));
    document.getElementById('backdrop-create').addEventListener('click', () => tutupModal('modal-create'));

    document.getElementById('btn-tutup-edit').addEventListener('click', () => tutupModal('modal-edit'));
    document.getElementById('btn-batal-edit').addEventListener('click', () => tutupModal('modal-edit'));
    document.getElementById('backdrop-edit').addEventListener('click', () => tutupModal('modal-edit'));

    function bukaEditModal(id, name, username, duk, password, kelasIds, mapelIds) {
        document.getElementById('form-edit').action = '/porosdata/guru/' + id;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-username').value = username;
        document.getElementById('edit-duk').value = duk || '';
        document.getElementById('edit-password').value = password;

        // Clear all checkboxes first
        document.querySelectorAll('#form-edit input[name="kelas_ids[]"]').forEach(cb => cb.checked = false);
        document.querySelectorAll('#form-edit input[name="mapel_ids[]"]').forEach(cb => cb.checked = false);

        // Check assigned ones
        kelasIds.forEach(id => {
            const cb = document.querySelector(`#form-edit input[name="kelas_ids[]"][value="${id}"]`);
            if (cb) cb.checked = true;
        });
        mapelIds.forEach(id => {
            const cb = document.querySelector(`#form-edit input[name="mapel_ids[]"][value="${id}"]`);
            if (cb) cb.checked = true;
        });

        bukaModal('modal-edit');
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            tutupModal('modal-create');
            tutupModal('modal-edit');
        }
    });
</script>
@endsection
