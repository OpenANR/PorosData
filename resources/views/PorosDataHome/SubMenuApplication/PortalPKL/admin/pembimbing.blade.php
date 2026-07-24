@extends('PorosDataHome.SubMenuApplication.PortalPKL.layouts.app')

@section('title', 'Kelola Data Pembimbing')

@section('content')
    <!-- Page Heading -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Kelola Data Pembimbing</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar Pembimbing PKL sekolah dan Mitra DUDI yang dipegang</p>
        </div>
        <div>
            <button id="btn-buka-create" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-orange-600 hover:bg-orange-500 text-white font-semibold text-sm shadow-md shadow-orange-100 dark:shadow-none transition-colors flex items-center justify-center gap-2 cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i>
                Tambah Pembimbing
            </button>
        </div>
    </div>

    <!-- Actions Bar & Search -->
    <div class="mb-6">
        <form method="GET" action="{{ route('portalpkl.admin.pembimbing.index') }}" class="w-full sm:w-80 relative">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, username, atau ID..."
                class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </div>
            @if($search)
                <a href="{{ route('portalpkl.admin.pembimbing.index') }}" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Table of Pembimbing -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-16 text-center">No</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">ID Pembimbing</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Pembimbing</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Username</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400">Mitra DU/DI yang Dipegang</th>
                        <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-slate-400 w-36 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($pembimbings as $index => $pembimbing)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                            <td class="py-4 px-6 text-sm text-slate-500 text-center font-medium">
                                {{ $pembimbings->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-6 text-sm font-mono font-bold text-slate-700 dark:text-slate-300">
                                {{ $pembimbing->id_pembimbing }}
                            </td>
                            <td class="py-4 px-6 text-sm font-bold text-slate-900 dark:text-white">
                                {{ $pembimbing->name }}
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-300">
                                {{ $pembimbing->username }}
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-300">
                                <div class="flex flex-wrap gap-1.5 max-w-sm">
                                    @forelse($pembimbing->mitras as $mitra)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-xs font-medium bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200/30 dark:border-orange-900/30" title="{{ $mitra->alamat }}">
                                            <i class="fa-solid fa-building text-[10px]"></i>
                                            {{ $mitra->nama_perusahaan }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400 italic">Belum memilih Mitra DU/DI</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <!-- Edit Button -->
                                    <button onclick="bukaEditModal('{{ $pembimbing->id }}', '{{ addslashes($pembimbing->id_pembimbing) }}', '{{ addslashes($pembimbing->name) }}', '{{ addslashes($pembimbing->username) }}', '{{ addslashes($pembimbing->password_plain ?? '') }}', [{{ $pembimbing->mitras->pluck('id')->implode(',') }}])"
                                        class="p-2 rounded-lg text-slate-500 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-950/30 transition-colors cursor-pointer" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </button>

                                    <!-- Delete Form -->
                                    <form action="{{ route('portalpkl.admin.pembimbing.destroy', $pembimbing->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus data pembimbing ini? Akun user dan hubungannya dengan Mitra DUDI juga akan dihapus.')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors cursor-pointer" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center text-slate-400">
                                <i class="fa-solid fa-user-tie text-3xl mb-3 text-slate-300 dark:text-slate-700"></i>
                                <p class="text-sm font-semibold">Belum ada data Pembimbing</p>
                                <p class="text-xs text-slate-400 mt-1">Silakan tambahkan data pembimbing melalui tombol di atas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pembimbings->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">{{ $pembimbings->links() }}</div>
        @endif
    </div>

    <!-- ===================== MODALS ===================== -->
    @push('modals')
    <!-- ===================== MODAL TAMBAH ===================== -->
    <div id="modal-create" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-create" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-lg bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
            <form action="{{ route('portalpkl.admin.pembimbing.store') }}" method="POST">
                @csrf
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Tambah Pembimbing Baru</h3>
                        <button type="button" id="btn-tutup-create" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 cursor-pointer">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">ID Pembimbing</label>
                                <input type="text" name="id_pembimbing" required placeholder="Contoh: P001"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Nama Pembimbing</label>
                                <input type="text" name="name" required placeholder="Contoh: Budi Santoso, S.Pd."
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Username</label>
                                <input type="text" name="username" required placeholder="Contoh: budi_pembimbing"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Password</label>
                                <input type="password" name="password" required placeholder="Minimal 6 karakter..."
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Pilih Mitra DU/DI (Industri)</label>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 mb-2">Pilih industri yang akan didampingi oleh pembimbing ini:</p>
                            
                            <div class="border border-slate-200 dark:border-slate-700/80 rounded-xl p-3 max-h-48 overflow-y-auto bg-slate-50 dark:bg-slate-800/50 space-y-2">
                                @php
                                    $unassignedMitrasCount = $allMitras->filter(fn($m) => $m->pembimbings->isEmpty())->count();
                                @endphp
                                @if($unassignedMitrasCount > 0)
                                    @foreach($allMitras as $mitra)
                                        @if($mitra->pembimbings->isEmpty())
                                            <label class="flex items-start gap-2.5 py-1 px-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-800/80 cursor-pointer transition-colors">
                                                <input type="checkbox" name="mitra_ids[]" value="{{ $mitra->id }}"
                                                    class="mt-1 rounded text-orange-600 focus:ring-orange-500 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800">
                                                <div class="text-xs">
                                                    <span class="font-bold text-slate-800 dark:text-slate-200 block">{{ $mitra->nama_perusahaan }}</span>
                                                    <span class="text-slate-400 dark:text-slate-500 block truncate max-w-[360px]">{{ $mitra->alamat }}</span>
                                                </div>
                                            </label>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-xs text-slate-400 italic text-center py-4">Semua Mitra DUDI sudah ditugaskan ke pembimbing lain atau belum ada data Mitra.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-end gap-3">
                    <button type="button" id="btn-batal-create" class="px-4 py-2 text-sm font-semibold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2 text-sm font-semibold rounded-xl bg-orange-600 hover:bg-orange-500 text-white shadow-md shadow-orange-100 dark:shadow-none transition-colors cursor-pointer">Simpan Pembimbing</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===================== MODAL EDIT ===================== -->
    <div id="modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="backdrop-edit" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-lg bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
            <form id="form-edit" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Ubah Data Pembimbing</h3>
                        <button type="button" id="btn-tutup-edit" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 cursor-pointer">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">ID Pembimbing</label>
                                <input type="text" name="id_pembimbing" id="edit-id_pembimbing" required placeholder="Contoh: P001"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Nama Pembimbing</label>
                                <input type="text" name="name" id="edit-name" required placeholder="Contoh: Budi Santoso, S.Pd."
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Username</label>
                                <input type="text" name="username" id="edit-username" required placeholder="Contoh: budi_pembimbing"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Password Baru</label>
                                <input type="text" name="password" id="edit-password" placeholder="Kosongkan jika tidak diubah..."
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-950 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Pilih Mitra DU/DI (Industri)</label>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 mb-2">Pilih industri yang akan didampingi oleh pembimbing ini:</p>
                            
                            <div class="border border-slate-200 dark:border-slate-700/80 rounded-xl p-3 max-h-48 overflow-y-auto bg-slate-50 dark:bg-slate-800/50 space-y-2">
                                @forelse($allMitras as $mitra)
                                    <label class="mitra-checkbox-item flex items-start gap-2.5 py-1 px-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-800/80 cursor-pointer transition-colors"
                                        data-pembimbing-id="{{ $mitra->pembimbings->first()->id ?? '' }}">
                                        <input type="checkbox" name="mitra_ids[]" value="{{ $mitra->id }}" id="edit-mitra-{{ $mitra->id }}"
                                            class="mt-1 rounded text-orange-600 focus:ring-orange-500 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800">
                                        <div class="text-xs">
                                            <span class="font-bold text-slate-800 dark:text-slate-200 block">{{ $mitra->nama_perusahaan }}</span>
                                            <span class="text-slate-400 dark:text-slate-500 block truncate max-w-[360px]">{{ $mitra->alamat }}</span>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-xs text-slate-400 italic text-center py-4">Belum ada data Mitra DUDI di sistem.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-end gap-3">
                    <button type="button" id="btn-batal-edit" class="px-4 py-2 text-sm font-semibold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2 text-sm font-semibold rounded-xl bg-orange-600 hover:bg-orange-500 text-white shadow-md shadow-orange-100 dark:shadow-none transition-colors cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript to Handle Modals -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modalCreate = document.getElementById('modal-create');
            const backdropCreate = document.getElementById('backdrop-create');
            const btnBukaCreate = document.getElementById('btn-buka-create');
            const btnTutupCreate = document.getElementById('btn-tutup-create');
            const btnBatalCreate = document.getElementById('btn-batal-create');
            const modalContentCreate = modalCreate.querySelector('.relative.z-10');

            const modalEdit = document.getElementById('modal-edit');
            const backdropEdit = document.getElementById('backdrop-edit');
            const btnTutupEdit = document.getElementById('btn-tutup-edit');
            const btnBatalEdit = document.getElementById('btn-batal-edit');
            const modalContentEdit = modalEdit.querySelector('.relative.z-10');

            // Open Create Modal
            const openCreateModal = () => {
                // Clear any checked boxes in create modal
                modalCreate.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                
                modalCreate.classList.remove('hidden');
                modalCreate.classList.add('flex');
                setTimeout(() => {
                    modalContentCreate.classList.remove('scale-95', 'opacity-0');
                    modalContentCreate.classList.add('scale-100', 'opacity-100');
                }, 10);
            };

            // Close Create Modal
            const closeCreateModal = () => {
                modalCreate.classList.add('modal-closing');
                modalContentCreate.classList.remove('scale-100', 'opacity-100');
                modalContentCreate.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modalCreate.classList.remove('modal-closing');
                    modalCreate.classList.remove('flex');
                    modalCreate.classList.add('hidden');
                }, 300);
            };

            if (btnBukaCreate) btnBukaCreate.addEventListener('click', openCreateModal);
            if (btnTutupCreate) btnTutupCreate.addEventListener('click', closeCreateModal);
            if (btnBatalCreate) btnBatalCreate.addEventListener('click', closeCreateModal);
            if (backdropCreate) backdropCreate.addEventListener('click', closeCreateModal);

            // Open Edit Modal via globally accessible function
            window.bukaEditModal = (id, idPembimbing, name, username, password, checkedMitraIds) => {
                const formEdit = document.getElementById('form-edit');
                const editIdPembimbing = document.getElementById('edit-id_pembimbing');
                const editName = document.getElementById('edit-name');
                const editUsername = document.getElementById('edit-username');
                const editPassword = document.getElementById('edit-password');

                formEdit.action = `/porosdata/portal-pkl/admin/pembimbing/${id}`;
                editIdPembimbing.value = idPembimbing;
                editName.value = name;
                editUsername.value = username;
                if (editPassword) {
                    editPassword.value = password;
                }

                // Filter and check checkboxes in Edit Modal
                const checkboxItems = modalEdit.querySelectorAll('.mitra-checkbox-item');
                let visibleCount = 0;
                checkboxItems.forEach(item => {
                    const assignedPembimbingId = item.getAttribute('data-pembimbing-id');
                    const checkbox = item.querySelector('input');
                    const val = parseInt(checkbox.value);

                    if (assignedPembimbingId === '' || parseInt(assignedPembimbingId) === parseInt(id)) {
                        // Show item: either free or assigned to this pembimbing
                        item.style.display = 'flex';
                        checkbox.checked = checkedMitraIds.includes(val);
                        visibleCount++;
                    } else {
                        // Hide item: assigned to another pembimbing
                        item.style.display = 'none';
                        checkbox.checked = false;
                    }
                });

                // Check if we need to show empty placeholder
                let emptyPlaceholder = document.getElementById('edit-mitra-empty-placeholder');
                if (!emptyPlaceholder) {
                    emptyPlaceholder = document.createElement('p');
                    emptyPlaceholder.id = 'edit-mitra-empty-placeholder';
                    emptyPlaceholder.className = 'text-xs text-slate-400 italic text-center py-4 hidden';
                    emptyPlaceholder.textContent = 'Semua Mitra DUDI sudah ditugaskan ke pembimbing lain.';
                    modalEdit.querySelector('.max-h-48').appendChild(emptyPlaceholder);
                }
                
                if (visibleCount === 0) {
                    emptyPlaceholder.classList.remove('hidden');
                } else {
                    emptyPlaceholder.classList.add('hidden');
                }

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
