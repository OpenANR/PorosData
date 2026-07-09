@extends('PorosDataHome.SubMenuApplication.PortalNilai.layouts.app')

@section('title', 'Pantau Nilai Wali Kelas - Portal Nilai')
@section('page_title', 'Pantau Nilai')

@section('content')
<div class="flex flex-col gap-6">
    <!-- PANEL PEMILIHAN DATA (DINAMIS) -->
    <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm flex flex-col md:flex-row gap-4 items-end shrink-0 animate-fade-in">
        <div class="w-full md:w-1/2 space-y-1.5">
            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400">Pilih Kelas</label>
            <div class="relative" style="position: relative;">
                <select id="select-kelas" class="block w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:border-blue-500 transition-all focus:outline-none focus:ring-4 focus:ring-blue-500/10 appearance-none cursor-pointer">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classes as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 flex items-center pointer-events-none text-slate-400" style="position: absolute; right: 16px;">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </div>
            </div>
        </div>
        
        <div class="w-full md:w-1/2 space-y-1.5">
            <label class="block text-xs font-bold text-transparent select-none">&nbsp;</label>
            <button onclick="loadWaliKelasData()" id="btn-load" class="w-full bg-emerald-600 hover:bg-emerald-500 dark:bg-emerald-700 dark:hover:bg-emerald-600 text-white font-bold py-2.5 px-4 rounded-xl flex justify-center items-center gap-2 shadow-md shadow-emerald-500/15 dark:shadow-none hover:shadow-xl active:scale-[0.98] transition-all cursor-pointer text-xs">
                <span>Tampilkan Data</span>
                <div id="load-loader" class="loader hidden"></div>
            </button>
        </div>
    </div>

    <!-- ======================= DATA TABLE CONTAINER ======================= -->
    <div id="table-container" class="hidden flex-col flex-grow bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm animate-fade-in">
        <!-- Wali Kelas Mode Banner -->
        <div id="walikelas-banner" class="bg-purple-50/50 dark:bg-purple-950/20 border-b border-slate-200/60 dark:border-slate-800/60 p-4 flex items-center gap-2.5 shrink-0">
            <div class="h-8 w-8 rounded-lg bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div>
                <h3 class="font-bold text-purple-800 dark:text-purple-400 text-xs">Dashboard Wali Kelas (Mode Pantau)</h3>
                <p class="text-[10px] text-purple-600 dark:text-purple-500">Menampilkan nilai akhir siswa. Apabila kosong (-), artinya guru mapel belum menginput nilai.</p>
            </div>
        </div>

        <!-- Scrollable Table -->
        <div class="overflow-auto max-h-[60vh] custom-scroll relative flex-grow">
            <table class="w-full text-xs text-left border-collapse">
                <thead class="text-slate-500 dark:text-slate-400 uppercase">
                    <tr id="tr-headers" class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                        <!-- Injected dynamically -->
                    </tr>
                </thead>
                <tbody id="table-body" class="divide-y divide-slate-100 dark:divide-slate-800/60 font-semibold text-slate-700 dark:text-slate-300">
                    <!-- Injected dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentClass = "";

    document.addEventListener('DOMContentLoaded', () => {
        // Auto select class if there is only one option
        const selectKelas = document.getElementById('select-kelas');
        if (selectKelas && selectKelas.options.length === 2) {
            selectKelas.selectedIndex = 1;
            loadWaliKelasData();
        }
    });

    function loadWaliKelasData() {
        currentClass = document.getElementById('select-kelas').value;
        if (!currentClass) return showToast("Pilih Kelas terlebih dahulu!", "warning");

        const btnLoad = document.getElementById('btn-load');
        const loader = document.getElementById('load-loader');
        btnLoad.disabled = true;
        loader.classList.remove('hidden');

        ajaxGet(`{{ route('portalnilai.walikelas.get') }}?kelas_id=${currentClass}`)
        .then(res => {
            btnLoad.disabled = false;
            loader.classList.add('hidden');

            if (res.status === "success") {
                renderTableWaliKelas(res.students, res.mapels);
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

    function renderTableWaliKelas(students, mapels) {
        document.getElementById('table-container').classList.remove('hidden');
        document.getElementById('table-container').classList.add('flex');

        // Build dynamic headers
        const trHeaders = document.getElementById('tr-headers');
        let headerHTML = `
            <th scope="col" class="px-4 py-4 text-center font-bold tracking-wider text-[11px] text-slate-800 dark:text-slate-200 border-r border-b dark:border-slate-800" style="width: 50px;">NO</th>
            <th scope="col" class="px-6 py-4 font-bold tracking-wider text-[11px] text-slate-800 dark:text-slate-200 border-r border-b dark:border-slate-800" style="min-width: 200px;">NAMA SISWA / NISN</th>
        `;

        mapels.forEach(mapel => {
            headerHTML += `
                <th scope="col" class="px-4 py-4 text-center font-bold tracking-wider text-[11px] text-slate-800 dark:text-slate-200 border-r border-b dark:border-slate-800" style="min-width: 120px;">${mapel.nama}</th>
            `;
        });
        trHeaders.innerHTML = headerHTML;

        // Build rows
        const tbody = document.getElementById('table-body');
        let rowsHTML = "";

        students.forEach((student, index) => {
            let cellsHTML = "";
            mapels.forEach(mapel => {
                const gradeVal = student.grades[mapel.id];
                let displayGrade = "-";
                let gradeClass = "text-slate-800 dark:text-slate-200 font-medium";

                if (gradeVal !== null && gradeVal !== undefined) {
                    displayGrade = gradeVal;
                    // Under 75 (Passing grade KKM) is highlighted red
                    if (parseFloat(gradeVal) < 75) {
                        gradeClass = "text-rose-600 dark:text-rose-400 font-bold";
                    }
                }

                cellsHTML += `
                    <td class="px-4 py-4 text-center border-r border-b border-slate-100 dark:border-slate-800/60 ${gradeClass}">
                        ${displayGrade}
                    </td>
                `;
            });

            rowsHTML += `
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors bg-white dark:bg-slate-900 border-b dark:border-slate-800/50">
                    <td class="px-4 py-4 text-center border-r border-b border-slate-100 dark:border-slate-800/60 font-medium text-slate-500">${index + 1}</td>
                    <td class="px-6 py-4 border-r border-b border-slate-100 dark:border-slate-800/60">
                        <span class="block font-bold text-slate-800 dark:text-slate-200 text-xs">${student.nama}</span>
                        <span class="block text-[10px] text-slate-400 font-medium mt-0.5">${student.nisn || '-'}</span>
                    </td>
                    ${cellsHTML}
                </tr>
            `;
        });

        tbody.innerHTML = rowsHTML;
    }
</script>
@endsection
