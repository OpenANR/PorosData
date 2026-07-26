@extends('PorosDataHome.SubMenuApplication.PortalPKL.layouts.app')

@section('title', 'Kelola Siswa PKL')

@section('content')
    <!-- Page Heading -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Kelola Siswa PKL</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar siswa peserta PKL, penempatan industri, dan pembimbing pendamping</p>
    </div>

    <!-- Actions Bar & Filters -->
    <div class="mb-6 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-4">
        <form method="GET" action="{{ route('portalpkl.admin.siswa.index') }}" class="w-full flex flex-col sm:flex-row items-center gap-3">
            <!-- Search -->
            <div class="w-full sm:w-72 relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, username, atau NISN..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <!-- Hidden button for Enter key submit -->
                <button type="submit" class="hidden"></button>
            </div>

            <!-- Filter Kelas -->
            <div class="w-full sm:w-44 relative">
                <select name="kelas" onchange="this.form.submit()"
                    class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all appearance-none cursor-pointer font-medium">
                    <option value="">Semua Kelas</option>
                    @foreach($allKelas as $kelas)
                        <option value="{{ $kelas->id }}" {{ $kelasFilter == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </div>
            </div>

            <!-- Filter Tempat PKL -->
            <div class="w-full sm:w-44 relative">
                <select name="mitra" onchange="this.form.submit()"
                    class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all appearance-none cursor-pointer font-medium">
                    <option value="">Semua Tempat PKL</option>
                    <option value="belum_ditentukan" {{ $mitraFilter === 'belum_ditentukan' ? 'selected' : '' }}>Belum ditentukan</option>
                    @foreach($allMitras as $mitra)
                        <option value="{{ $mitra->id }}" {{ $mitraFilter == $mitra->id ? 'selected' : '' }}>
                            {{ Str::limit($mitra->nama_perusahaan, 25) }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </div>
            </div>

            @if($search || $kelasFilter || $mitraFilter)
                <a href="{{ route('portalpkl.admin.siswa.index') }}" class="text-xs font-semibold text-orange-600 hover:text-orange-700 dark:text-orange-400 whitespace-nowrap ml-1">Hapus Filter</a>
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
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-24 text-center">Aksi</th>
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
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <!-- Edit Button (Ubah Penempatan) -->
                                    <button onclick="bukaEditModal('{{ $siswa->id }}', '{{ addslashes($siswa->user->name) }}', '{{ $siswa->mitra_dudi_id }}')"
                                        class="p-2 rounded-lg text-slate-500 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-950/30 transition-colors cursor-pointer" title="Ubah Penempatan Mitra">
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </button>

                                    <!-- Delete Button (Batalkan Penempatan) -->
                                    @if($siswa->mitra_dudi_id)
                                        <form action="{{ route('portalpkl.admin.siswa.destroy', $siswa->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus/Batalkan penempatan PKL untuk siswa ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors cursor-pointer" title="Batalkan Penempatan">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="p-2 text-slate-300 dark:text-slate-700 cursor-not-allowed" title="Belum Ditempatkan">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-16 text-center text-slate-400">
                                <i class="fa-solid fa-user-graduate text-3xl mb-3 text-slate-300 dark:text-slate-700"></i>
                                <p class="text-sm font-semibold">Belum ada data Siswa PKL</p>
                                <p class="text-xs text-slate-400 mt-1">Gunakan import/seeder untuk memasukkan data siswa kelas.</p>
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

    <!-- ===================== MODALS ===================== -->
    @push('modals')
    <!-- ===================== MODAL EDIT PENEMPATAN ===================== -->
    <div id="modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-edit" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
            <form id="form-edit" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Atur Penempatan PKL</h3>
                        <button type="button" id="btn-tutup-edit" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 cursor-pointer">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nama Siswa</label>
                            <input type="text" id="edit-nama-siswa" disabled 
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-500 dark:text-slate-400 text-sm font-semibold cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Pilih Mitra DU/DI (Industri)</label>
                            <select name="mitra_dudi_id" id="edit-mitra_dudi_id"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all cursor-pointer">
                                <option value="">-- Belum ditentukan / Batalkan Penempatan --</option>
                                @foreach($allMitras as $mitra)
                                    @php
                                        $mitraPembimbing = $mitra->pembimbings->first();
                                    @endphp
                                    <option value="{{ $mitra->id }}">
                                        {{ $mitra->nama_perusahaan }} 
                                        @if($mitraPembimbing)
                                            (Pembimbing: {{ $mitraPembimbing->name }} [{{ $mitraPembimbing->id_pembimbing }}])
                                        @else
                                            (Belum memiliki pembimbing)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-1.5 block">
                                Pembimbing akan disesuaikan secara otomatis berdasarkan pendamping Mitra DU/DI yang terpilih.
                            </span>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-end gap-3">
                    <button type="button" id="btn-batal-edit" class="px-4 py-2 text-sm font-semibold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2 text-sm font-semibold rounded-xl bg-orange-600 hover:bg-orange-500 text-white shadow-md shadow-orange-100 dark:shadow-none transition-colors cursor-pointer">Simpan Penempatan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript to Handle Modals -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modalEdit = document.getElementById('modal-edit');
            const backdropEdit = document.getElementById('backdrop-edit');
            const btnTutupEdit = document.getElementById('btn-tutup-edit');
            const btnBatalEdit = document.getElementById('btn-batal-edit');
            const modalContentEdit = modalEdit.querySelector('.relative.z-10');

            // Open Edit Modal via globally accessible function
            window.bukaEditModal = (id, namaSiswa, mitraDudiId) => {
                const formEdit = document.getElementById('form-edit');
                const editNama = document.getElementById('edit-nama-siswa');
                const editMitraSelect = document.getElementById('edit-mitra_dudi_id');

                formEdit.action = `/porosdata/portal-pkl/admin/siswa-pkl/${id}`;
                editNama.value = namaSiswa;
                editMitraSelect.value = mitraDudiId || '';

                modalEdit.classList.remove('hidden');
                modalEdit.classList.add('flex');
                setTimeout(() => {
                    modalContentEdit.classList.remove('scale-95', 'opacity-0');
                    modalContentEdit.classList.add('scale-100', 'opacity-100');
                }, 10);
            };

            // Close Edit Modal
            const closeEditModal = () => {
                modalEdit.classList.add('modal-closing');
                modalContentEdit.classList.remove('scale-100', 'opacity-100');
                modalContentEdit.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modalEdit.classList.remove('modal-closing');
                    modalEdit.classList.remove('flex');
                    modalEdit.classList.add('hidden');
                }, 300);
            };

            if (btnTutupEdit) btnTutupEdit.addEventListener('click', closeEditModal);
            if (btnBatalEdit) btnBatalEdit.addEventListener('click', closeEditModal);
            if (backdropEdit) backdropEdit.addEventListener('click', closeEditModal);
        });
    </script>
    @endpush
@endsection
