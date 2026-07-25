@extends('PorosDataHome.layouts.app')

@section('title', 'Migrasi Siswa')

@section('content')
<!-- Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between md:items-end gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Migrasi / Kenaikan Kelas</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Pindahkan siswa secara massal dari satu kelas ke kelas lain, atau set status kelulusan.</p>
    </div>
</div>

@if(session('success'))
<div class="mb-4 p-4 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 dark:bg-emerald-900/30 dark:border-emerald-800 dark:text-emerald-400 flex items-start gap-3">
    <!-- icon -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mt-0.5 shrink-0">
        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
    </svg>
    <p class="text-sm font-medium">{{ session('success') }}</p>
</div>
@endif

@if ($errors->any())
<div class="mb-4 p-4 rounded-xl bg-red-50 text-red-600 border border-red-100 dark:bg-red-900/30 dark:border-red-800 dark:text-red-400">
    <ul class="list-disc pl-5 text-sm font-medium">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('siswa.migrasi.proses') }}" method="POST" id="form-migrasi">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Tabel Siswa -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100">Daftar Siswa</h3>
                    
                    <div class="w-64">
                        <select id="kelas_asal" class="w-full text-sm border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="">-- Pilih Kelas Asal --</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->nama_kelas }} {{ $c->jurusan ? ' - ' . $c->jurusan->nama_jurusan : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="table-siswa">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider border-b border-slate-200 dark:border-slate-800">
                                <th class="p-4 w-12 text-center">
                                    <input type="checkbox" id="check-all" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500 disabled:opacity-50" disabled>
                                </th>
                                <th class="p-4 font-semibold">NISN</th>
                                <th class="p-4 font-semibold">Nama Siswa</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-siswa" class="divide-y divide-slate-200 dark:divide-slate-800 bg-white dark:bg-slate-900 text-sm">
                            <tr>
                                <td colspan="3" class="p-8 text-center text-slate-500 dark:text-slate-400">
                                    Pilih Kelas Asal terlebih dahulu untuk melihat daftar siswa.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Aksi & Tujuan -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden p-5">
                <h3 class="font-bold text-slate-800 dark:text-slate-100 mb-4 border-b border-slate-200 dark:border-slate-800 pb-3">Tindakan Migrasi</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Jenis Migrasi <span class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="jenis_migrasi" value="naik_kelas" checked class="text-indigo-600 focus:ring-indigo-500" onchange="toggleTujuan()">
                                <span class="text-sm text-slate-700 dark:text-slate-300">Naik / Pindah Kelas</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="jenis_migrasi" value="lulus" class="text-indigo-600 focus:ring-indigo-500" onchange="toggleTujuan()">
                                <span class="text-sm text-slate-700 dark:text-slate-300">Kelulusan</span>
                            </label>
                        </div>
                    </div>

                    <div id="container-tujuan">
                        <label for="kelas_tujuan" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kelas Tujuan <span class="text-red-500">*</span></label>
                        <select name="kelas_tujuan" id="kelas_tujuan" class="w-full text-sm border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Pilih Kelas Tujuan --</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->nama_kelas }} {{ $c->jurusan ? ' - ' . $c->jurusan->nama_jurusan : '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                        <button type="button" id="btn-submit" onclick="confirmMigrasi()" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-xl transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            Proses Migrasi
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Panduan -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-2xl p-5">
                <h4 class="font-bold text-blue-800 dark:text-blue-300 mb-2 text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    Panduan Penggunaan
                </h4>
                <ul class="list-disc pl-4 text-xs text-blue-700 dark:text-blue-400 space-y-1.5">
                    <li>Pilih <strong>Kelas Asal</strong> untuk memunculkan daftar siswa.</li>
                    <li>Centang siswa yang ingin diproses (yang tidak dicentang tidak akan ikut berubah).</li>
                    <li>Pilih <strong>Naik/Pindah Kelas</strong> jika ingin memindah mereka ke kelas baru, atau <strong>Kelulusan</strong> untuk mengubah status mereka menjadi 'Lulus'.</li>
                </ul>
            </div>
        </div>
    </div>
</form>

<script>
    const selectKelasAsal = document.getElementById('kelas_asal');
    const tbodySiswa = document.getElementById('tbody-siswa');
    const checkAll = document.getElementById('check-all');
    const btnSubmit = document.getElementById('btn-submit');
    const containerTujuan = document.getElementById('container-tujuan');
    const selectKelasTujuan = document.getElementById('kelas_tujuan');

    function toggleTujuan() {
        const jenis = document.querySelector('input[name="jenis_migrasi"]:checked').value;
        if (jenis === 'lulus') {
            containerTujuan.style.display = 'none';
            selectKelasTujuan.required = false;
            selectKelasTujuan.value = '';
        } else {
            containerTujuan.style.display = 'block';
            selectKelasTujuan.required = true;
        }
    }

    selectKelasAsal.addEventListener('change', async function() {
        const kelasId = this.value;
        if (!kelasId) {
            tbodySiswa.innerHTML = `<tr><td colspan="3" class="p-8 text-center text-slate-500 dark:text-slate-400">Pilih Kelas Asal terlebih dahulu untuk melihat daftar siswa.</td></tr>`;
            checkAll.disabled = true;
            checkAll.checked = false;
            updateBtnState();
            return;
        }

        tbodySiswa.innerHTML = `<tr><td colspan="3" class="p-8 text-center text-slate-500 dark:text-slate-400">Memuat data...</td></tr>`;
        checkAll.disabled = true;
        
        try {
            const response = await fetch(`{{ route('siswa.migrasi.get_siswa') }}?kelas_id=${kelasId}`);
            const data = await response.json();
            
            if (data.length === 0) {
                tbodySiswa.innerHTML = `<tr><td colspan="3" class="p-8 text-center text-slate-500 dark:text-slate-400">Tidak ada siswa berstatus aktif di kelas ini.</td></tr>`;
                checkAll.checked = false;
                updateBtnState();
                return;
            }

            let html = '';
            data.forEach(siswa => {
                html += `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                        <td class="p-4 text-center">
                            <input type="checkbox" name="siswa_ids[]" value="${siswa.id}" class="siswa-checkbox rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        </td>
                        <td class="p-4 font-medium text-slate-700 dark:text-slate-300">
                            ${siswa.nisn || '-'}
                        </td>
                        <td class="p-4 font-medium text-slate-800 dark:text-slate-200">
                            ${siswa.user ? siswa.user.name : '-'}
                        </td>
                    </tr>
                `;
            });

            tbodySiswa.innerHTML = html;
            checkAll.disabled = false;
            checkAll.checked = false;
            
            // Add listeners to new checkboxes
            document.querySelectorAll('.siswa-checkbox').forEach(cb => {
                cb.addEventListener('change', updateBtnState);
            });
            updateBtnState();

        } catch (error) {
            console.error('Error fetching students:', error);
            tbodySiswa.innerHTML = `<tr><td colspan="3" class="p-8 text-center text-red-500 dark:text-red-400">Terjadi kesalahan saat memuat data.</td></tr>`;
        }
    });

    checkAll.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.siswa-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateBtnState();
    });

    function updateBtnState() {
        const checkboxes = document.querySelectorAll('.siswa-checkbox:checked');
        const checkedCount = checkboxes.length;
        
        if (checkedCount > 0) {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = `Proses Migrasi (${checkedCount} Siswa)`;
        } else {
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = `Proses Migrasi`;
        }
        
        // Update checkAll state based on individual checkboxes
        const allCheckboxes = document.querySelectorAll('.siswa-checkbox');
        if (allCheckboxes.length > 0) {
            checkAll.checked = allCheckboxes.length === checkedCount;
        }
    }

    function confirmMigrasi() {
        const jenis = document.querySelector('input[name="jenis_migrasi"]:checked').value;
        const kelasTujuanId = selectKelasTujuan.value;
        
        if (jenis === 'naik_kelas' && !kelasTujuanId) {
            alert('Silakan pilih Kelas Tujuan terlebih dahulu!');
            selectKelasTujuan.focus();
            return;
        }
        
        const count = document.querySelectorAll('.siswa-checkbox:checked').length;
        const msg = jenis === 'lulus' 
            ? `Apakah Anda yakin ingin MELULUSKAN ${count} siswa terpilih?` 
            : `Apakah Anda yakin ingin MEMINDAHKAN ${count} siswa terpilih ke kelas tujuan?`;
            
        if (confirm(msg)) {
            document.getElementById('form-migrasi').submit();
        }
    }
</script>
@endsection
