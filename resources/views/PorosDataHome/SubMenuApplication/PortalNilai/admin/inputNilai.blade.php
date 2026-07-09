@extends('PorosDataHome.SubMenuApplication.PortalNilai.layouts.app')

@section('title', 'Input Nilai Admin - Portal Nilai')
@section('page_title', 'Input Nilai')

@section('content')
<div class="flex flex-col gap-6">
    <!-- PANEL PEMILIHAN DATA (DINAMIS) -->
    <div class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm flex flex-col md:flex-row gap-4 items-end shrink-0">
        <div class="w-full md:w-1/3 space-y-1.5">
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
        
        <div class="w-full md:w-1/3 space-y-1.5" id="mapel-container">
            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400">Pilih Mata Pelajaran</label>
            <div class="relative" style="position: relative;">
                <select id="select-mapel" class="block w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:border-blue-500 transition-all focus:outline-none focus:ring-4 focus:ring-blue-500/10 appearance-none cursor-pointer">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 flex items-center pointer-events-none text-slate-400" style="position: absolute; right: 16px;">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/3 space-y-1.5">
            <label class="block text-xs font-bold text-transparent select-none">&nbsp;</label>
            <button onclick="loadStudents()" id="btn-load" class="w-full bg-emerald-600 hover:bg-emerald-500 dark:bg-emerald-700 dark:hover:bg-emerald-600 text-white font-bold py-2.5 px-4 rounded-xl flex justify-center items-center gap-2 shadow-md shadow-emerald-500/15 dark:shadow-none hover:shadow-xl active:scale-[0.98] transition-all cursor-pointer text-xs">
                <span>Tampilkan Data</span>
                <div id="load-loader" class="loader hidden"></div>
            </button>
        </div>
    </div>

    <!-- ACCESS CLOSED ALERT -->
    <div id="alert-akses-tutup" class="hidden bg-rose-50 dark:bg-rose-950/20 border-l-4 border-rose-500 text-rose-800 dark:text-rose-400 p-4 rounded-r-xl shadow-sm border border-slate-200/40 dark:border-slate-800/40" role="alert">
        <p class="font-bold text-sm flex items-center gap-1.5"><i class="fa-solid fa-circle-xmark text-rose-500"></i> Akses Penilaian Ditutup!</p>
        <p class="text-xs mt-1">Waktu pengisian nilai telah berakhir atau belum dimulai. Anda hanya dapat melihat data (Read Only).</p>
    </div>

    <!-- PETUNJUK PENILAIAN CARD -->
    <div id="info-card-container" class="hidden glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm flex flex-col gap-3 shrink-0">
        <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100 dark:border-slate-800/60" style="padding-bottom: 14px; margin-bottom: 16px;">
            <div class="h-9 w-9 rounded-lg bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm shadow-sm">
                <i class="fa-solid fa-circle-question"></i>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 dark:text-slate-200 text-xs">Petunjuk Penilaian</h4>
                <p class="text-[10px] text-slate-400">Cara penginputan nilai PG, Essai, dan Nilai Akhir.</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
            <div id="info-pg-detail" class="space-y-2">
                <h5 class="font-bold text-slate-700 dark:text-slate-300 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Input PG ASAS GENAP</h5>
                <ul class="list-disc list-inside pl-3.5 space-y-1 text-[10px] text-slate-500 dark:text-slate-400">
                    <li>Ketik nomor soal yang <strong class="text-blue-600 dark:text-blue-400">Benar</strong> atau <strong class="text-blue-600 dark:text-blue-400">Salah</strong> dipisahkan dengan koma (contoh: <code>1,2,5,7</code>).</li>
                    <li>Ketik <strong class="text-blue-600 dark:text-blue-400">benar semua</strong> atau <strong class="text-blue-600 dark:text-blue-400">salah semua</strong> untuk mengisi otomatis seluruh soal.</li>
                    <li>Gunakan mode <strong class="text-blue-600 dark:text-blue-400">Fast Track</strong> untuk langsung mengetik jumlah soal yang benar (contoh: ketik <code>20</code>).</li>
                </ul>
            </div>
            <div id="info-essai-detail" class="space-y-2">
                <h5 class="font-bold text-slate-700 dark:text-slate-300 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Input Essai (Per Soal)</h5>
                <ul class="list-disc list-inside pl-3.5 space-y-1 text-[10px] text-slate-500 dark:text-slate-400">
                    <li>Input nilai per-soal (N1 s.d N5) menggunakan dropdown yang tersedia (skala <code>0 s.d 8</code>).</li>
                    <li>Sistem otomatis menjumlahkan nilai essai dan menyimpannya ke database.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ======================= DATA TABLE CONTAINER ======================= -->
    <div id="table-container" class="hidden flex-col flex-grow bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm animate-fade-in">
        <!-- PG Analysis Mode Picker (Hide for Praktik) -->
        <div id="asas-mode-container" class="bg-blue-50/50 dark:bg-blue-950/20 border-b border-slate-200/60 dark:border-slate-800/60 p-4 flex flex-col sm:flex-row justify-between items-center gap-4 shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="h-8 w-8 rounded-lg bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div>
                    <h3 class="font-bold text-blue-800 dark:text-blue-400 text-xs">Mode Analisis Pilihan Ganda (PG)</h3>
                    <p class="text-[10px] text-blue-600 dark:text-blue-500">Pilih mode pengerjaan PG untuk seluruh siswa di kelas ini.</p>
                </div>
            </div>
            <div class="relative" style="position: relative;">
                <select id="global-asas-mode" onchange="recalculateAll()" class="pl-4 pr-10 py-2 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 font-bold text-xs text-blue-800 dark:text-blue-400 outline-none focus:ring-4 focus:ring-blue-500/10 cursor-pointer appearance-none">
                    <option value="Benar">Tulis Benar</option>
                    <option value="Salah">Tulis Salah</option>
                    <option value="FastTrack">Fast Track (Ketik Jumlah Benar)</option>
                </select>
                <div class="absolute inset-y-0 flex items-center pointer-events-none text-blue-600 dark:text-blue-400" style="position: absolute; right: 14px;">
                    <i class="fa-solid fa-chevron-down text-[9px]"></i>
                </div>
            </div>
        </div>

        <!-- Scrollable Table -->
        <div class="overflow-auto max-h-[55vh] custom-scroll relative flex-grow">
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

        <!-- Table Footer Control -->
        <div class="bg-slate-50 dark:bg-slate-900 border-t border-slate-200/60 dark:border-slate-800/60 p-4 flex justify-end sticky left-0 bottom-0 z-30 shadow-inner shrink-0">
            <button onclick="saveGrades()" id="btn-save" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 dark:bg-blue-700 dark:hover:bg-blue-600 text-white font-bold text-xs shadow-md shadow-blue-500/15 dark:shadow-none hover:shadow-xl active:scale-[0.98] transition-all flex items-center justify-center gap-2 cursor-pointer">
                <i class="fa-regular fa-floppy-disk"></i>
                <span>Simpan Seluruh Nilai</span>
                <div id="save-loader" class="loader hidden"></div>
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentClass = "";
    let currentMapel = "";
    let currentMapelType = "Reguler";
    let studentsData = [];
    let isAksesBuka = true;
    let isAksesTugasBuka = true;

    function handleEnter(event, type, index) {
        if (event.key === "Enter") {
            event.preventDefault();
            const nextInput = document.getElementById(`${type}_${studentsData[index + 1]?.siswa_id}`);
            if (nextInput) nextInput.focus();
        }
    }

    function loadStudents() {
        currentClass = document.getElementById('select-kelas').value;
        currentMapel = document.getElementById('select-mapel').value;

        if (!currentClass) return showToast("Pilih Kelas terlebih dahulu!", "warning");
        if (!currentMapel) return showToast("Pilih Mata Pelajaran!", "warning");

        const btnLoad = document.getElementById('btn-load');
        const loader = document.getElementById('load-loader');
        btnLoad.disabled = true;
        loader.classList.remove('hidden');

        ajaxGet(`{{ route('portalnilai.students.get') }}?kelas_id=${currentClass}&mapel_id=${currentMapel}`)
        .then(res => {
            btnLoad.disabled = false;
            loader.classList.add('hidden');

            if (res.status === "success") {
                // Check access alert
                const alertTutup = document.getElementById('alert-akses-tutup');
                const btnSave = document.getElementById('btn-save');
                if (res.isAksesBuka === false) {
                    alertTutup.classList.remove('hidden');
                    btnSave.classList.add('hidden');
                } else {
                    alertTutup.classList.add('hidden');
                    btnSave.classList.remove('hidden');
                }

                isAksesBuka = res.isAksesBuka;
                isAksesTugasBuka = res.isAksesTugasBuka;
                currentMapelType = res.tipeMapel || "Reguler";
                studentsData = res.data;

                if (studentsData.length > 0 && studentsData[0].mode_asas) {
                    const globalMode = document.getElementById('global-asas-mode');
                    if (globalMode) {
                        globalMode.value = studentsData[0].mode_asas;
                    }
                }

                renderTableGuru();
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

    function updateEsString(siswaId) {
        let vals = [];
        for (let i = 1; i <= 5; i++) {
            vals.push(document.getElementById(`es${i}_${siswaId}`).value);
        }
        document.getElementById(`es_${siswaId}`).value = vals.join(',');
        calculateMurni(siswaId);
    }

    function renderTableGuru() {
        document.getElementById('table-container').classList.remove('hidden');
        document.getElementById('table-container').classList.add('flex');

        const isProduktif = currentMapelType.toLowerCase() === "praktik" || currentMapelType.toLowerCase() === "produktif";
        let modeGlobalInit = document.getElementById('global-asas-mode') ? document.getElementById('global-asas-mode').value.toLowerCase() : "benar";

        // Hide PG/Essai controls for Praktik
        const modeContainer = document.getElementById('asas-mode-container');
        if (isProduktif) {
            modeContainer.classList.add('hidden');
        } else {
            modeContainer.classList.remove('hidden');
        }

        // Show/hide info card and toggle its children depending on mapel type
        const infoCard = document.getElementById('info-card-container');
        if (infoCard) {
            infoCard.classList.remove('hidden');
            const infoPg = document.getElementById('info-pg-detail');
            const infoEssai = document.getElementById('info-essai-detail');
            if (isProduktif) {
                if (infoPg) infoPg.classList.add('hidden');
                if (infoEssai) infoEssai.classList.add('hidden');
            } else {
                if (infoPg) infoPg.classList.remove('hidden');
                if (infoEssai) infoEssai.classList.remove('hidden');
            }
        }

        // Headers Setup
        const isAsasEditable = (currentRole.toLowerCase() === "admin" || currentRole.toLowerCase() === "superadmin" || isAksesBuka);
        const isTugasEditable = (currentRole.toLowerCase() === "admin" || currentRole.toLowerCase() === "superadmin" || (isAksesBuka && isAksesTugasBuka));

        const globalMode = document.getElementById('global-asas-mode');
        if (globalMode) {
            globalMode.disabled = !isAsasEditable;
        }

        let pgHeaderText = isAsasEditable ? 'Input PG ASAS GENAP' : 'Input PG ASAS GENAP 🔒';
        let pgWidthClass = modeGlobalInit === 'fasttrack' ? 'w-32 min-w-[128px]' : 'w-[280px] min-w-[280px]';
        let thPG = isProduktif ? '' : `<th id="th-pg" class="px-4 py-4 ${pgWidthClass} text-center border-r border-b dark:border-slate-800 bg-blue-100/60 dark:bg-slate-800/80 text-blue-900 dark:text-blue-400 font-bold sticky top-0 z-40 transition-all duration-300" title="Ketik: salah semua / benar semua / Fast Track">${pgHeaderText}</th>`;
        
        let essaiHeaderText = isAsasEditable ? 'Input Essai (Per Soal)' : 'Input Essai (Per Soal) 🔒';
        let thES = isProduktif ? '' : `
            <th class="px-2 py-4 min-w-[280px] text-center border-r border-b dark:border-slate-800 bg-blue-100/60 dark:bg-slate-800/80 text-blue-900 dark:text-blue-400 font-bold sticky top-0 z-40">
                <div>${essaiHeaderText}</div>
            </th>
        `;
        let thMurniText = isProduktif ? (isAsasEditable ? 'Nilai ASAS' : 'Nilai ASAS 🔒') : (isAsasEditable ? 'Murni ASAS GENAP' : 'Murni ASAS GENAP 🔒');
        let thMurni = `<th class="px-3 py-4 w-24 text-center border-r border-b dark:border-slate-800 bg-blue-200/60 dark:bg-slate-800 font-bold sticky top-0 z-40 text-blue-950 dark:text-blue-300">${thMurniText}</th>`;
        let perbaikanHeaderText = isAsasEditable ? 'Perbaikan' : 'Perbaikan 🔒';
        let thPerbaikan = isProduktif ? '' : `<th class="px-3 py-4 w-24 text-center border-r border-b dark:border-slate-800 bg-rose-100/50 dark:bg-rose-950/20 text-rose-800 dark:text-rose-400 sticky top-0 z-40 font-bold">${perbaikanHeaderText}</th>`;

        document.getElementById('tr-headers').innerHTML = `
            <th class="px-4 py-4 text-center w-12 sticky left-0 top-0 bg-slate-200 dark:bg-slate-800 border-r border-b dark:border-slate-800 z-50 text-slate-600 dark:text-slate-300">No</th>
            <th class="px-4 py-4 w-[280px] min-w-[280px] sticky left-[48px] top-0 bg-slate-200 dark:bg-slate-800 border-r border-b dark:border-slate-800 z-50 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] text-slate-600 dark:text-slate-300">Nama Siswa / NISN</th>
            <th class="px-3 py-4 w-20 text-center border-r border-b dark:border-slate-800 bg-slate-200/60 dark:bg-slate-800/60 sticky top-0 z-40 text-slate-600 dark:text-slate-300 font-bold">${isTugasEditable ? 'Tugas 1' : 'Tugas 1 🔒'}</th>
            <th class="px-3 py-4 w-20 text-center border-r border-b dark:border-slate-800 bg-slate-200/60 dark:bg-slate-800/60 sticky top-0 z-40 text-slate-600 dark:text-slate-300 font-bold">${isTugasEditable ? 'Tugas 2' : 'Tugas 2 🔒'}</th>
            <th class="px-3 py-4 w-20 text-center border-r border-b dark:border-slate-800 bg-slate-200/60 dark:bg-slate-800/60 sticky top-0 z-40 text-slate-600 dark:text-slate-300 font-bold">${isTugasEditable ? 'ASTS' : 'ASTS 🔒'}</th>
            <th class="px-3 py-4 w-20 text-center border-r border-b dark:border-slate-800 bg-amber-50/50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300 font-bold sticky top-0 z-40">${isAsasEditable ? 'Tugas 4' : 'Tugas 4 🔒'}</th>
            <th class="px-3 py-4 w-20 text-center border-r border-b dark:border-slate-800 bg-amber-50/50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300 font-bold sticky top-0 z-40">${isAsasEditable ? 'Tugas 5' : 'Tugas 5 🔒'}</th>
            ${thPG}
            ${thES}
            ${thMurni}
            ${thPerbaikan}
            <th class="px-3 py-4 w-24 text-center border-r border-b dark:border-slate-800 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold sticky top-0 z-40">Ketuntasan</th>
            <th class="px-3 py-4 w-24 text-center bg-emerald-100/60 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 border-b dark:border-slate-800 font-bold sticky top-0 z-40">Nilai Akhir</th>
        `;

        const tbody = document.getElementById('table-body');
        tbody.innerHTML = '';

        let tugasClass = isTugasEditable ? "bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-blue-500 cursor-text" : "admin-readonly cursor-not-allowed border border-transparent";
        let tugasReadonly = isTugasEditable ? "" : "readonly disabled";
        let tdTugasClass = isTugasEditable ? "bg-amber-50/10" : "bg-slate-100/50 dark:bg-slate-900/30";

        let asasClass = isAsasEditable ? "bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-blue-500 cursor-text" : "admin-readonly cursor-not-allowed border border-transparent";
        let asasReadonly = isAsasEditable ? "" : "readonly disabled";

        let tdMurniClass = (isProduktif && isAsasEditable) ? "bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-blue-500 cursor-text" : "admin-readonly cursor-not-allowed border border-transparent";
        let tdMurniReadonly = (isProduktif && isAsasEditable) ? "" : "readonly disabled";

        let pgPlaceholder = modeGlobalInit === 'fasttrack' ? "Cth: 24" : "Cth: 1,2.. / 25 / benar semua";

        studentsData.forEach((siswa, index) => {
            const sId = siswa.siswa_id;
            const tr = document.createElement('tr');
            tr.className = "bg-white dark:bg-slate-900 hover:bg-blue-50/30 dark:hover:bg-slate-800/30 transition border-b dark:border-slate-800/50";

            let pgAsasVal = siswa.pg_asas ?? '';
            let esAsasVal = siswa.essai_asas ?? '';

            let esVals = ["0","0","0","0","0"];
            let esStr = esAsasVal.toString().toLowerCase().trim();

            if (esStr === "benar semua") {
                esVals = ["8","8","8","8","8"];
                esAsasVal = "8,8,8,8,8";
            } else if (esStr === "salah semua") {
                esVals = ["0","0","0","0","0"];
                esAsasVal = "0,0,0,0,0";
            } else if (esStr !== "") {
                let splitted = esStr.split(',');
                for (let i = 0; i < 5; i++) {
                    if (splitted[i] !== undefined && splitted[i] !== "") {
                        esVals[i] = splitted[i];
                    }
                }
            }

            let tdPG = isProduktif ? '' : `<td class="px-2 py-3 border-r dark:border-slate-800/80 bg-blue-50/10"><input type="text" id="pg_${sId}" class="w-full p-2 rounded-lg outline-none text-xs font-semibold text-center ${asasClass}" value="${pgAsasVal}" placeholder="${pgPlaceholder}" oninput="calculateMurni('${sId}')" onkeydown="handleEnter(event, 'pg', ${index})" ${asasReadonly}></td>`;
            
            // Generate essai select boxes
            let optionsHTML = "";
            for (let v = 0; v <= 8; v++) {
                optionsHTML += `<option value="${v}">${v}</option>`;
            }

            let selectBoxes = "";
            for (let i = 1; i <= 5; i++) {
                selectBoxes += `
                    <div class="flex flex-col items-center gap-1">
                        <span class="text-[9px] text-slate-400 font-bold">N${i}</span>
                        <div class="relative inline-block w-12" style="position: relative;">
                            <select id="es${i}_${sId}" onchange="updateEsString('${sId}')" class="block w-full text-center pl-2 pr-5 py-1.5 rounded-lg text-xs font-bold focus:outline-none appearance-none cursor-pointer ${asasClass}" ${asasReadonly}>
                                ${optionsHTML}
                            </select>
                            <div class="absolute inset-y-0 right-1.5 flex items-center pointer-events-none text-slate-400" style="position: absolute; right: 6px;">
                                <i class="fa-solid fa-chevron-down text-[8px]"></i>
                            </div>
                        </div>
                    </div>
                `;
            }

            let tdES = isProduktif ? '' : `
                <td class="px-3 py-3 border-r dark:border-slate-800/80 bg-blue-50/10">
                    <div class="flex items-center gap-2 justify-center">
                        ${selectBoxes}
                    </div>
                    <input type="hidden" id="es_${sId}" value="${esAsasVal}">
                </td>
            `;

            let tdMurni = `<td class="px-2 py-3 border-r dark:border-slate-800/80 bg-blue-100/10"><input type="number" id="murni_${sId}" class="w-full text-center p-2 rounded-lg outline-none text-xs font-bold ${tdMurniClass}" value="${siswa.murni_asas ?? ''}" oninput="calculateAkhir('${sId}')" onkeydown="handleEnter(event, 'murni', ${index})" ${tdMurniReadonly}></td>`;
            let tdPerbaikan = isProduktif ? '' : `<td class="px-2 py-3 border-r dark:border-slate-800/80 bg-rose-50/10"><input type="number" id="perbaikan_${sId}" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full text-center p-2 rounded-lg outline-none text-rose-600 dark:text-rose-400 font-bold text-xs ${asasClass}" value="${siswa.perbaikan ?? ''}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAkhir('${sId}')" onkeydown="handleEnter(event, 'perbaikan', ${index})" ${asasReadonly}></td>`;

            tr.innerHTML = `
                <td class="px-4 py-3 text-center border-r dark:border-slate-800/80 font-medium sticky left-0 bg-white dark:bg-slate-900 z-10 text-slate-400">${index + 1}</td>
                <td class="px-4 py-3 border-r dark:border-slate-800/80 sticky left-[48px] bg-white dark:bg-slate-900 z-10 font-bold shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] truncate max-w-[280px]" title="${siswa.nama}">${siswa.nama}<div class="text-[10px] font-semibold text-slate-400 mt-0.5">${siswa.nisn || '-'}</div></td>
                
                <td class="px-2 py-3 border-r dark:border-slate-800/80 ${tdTugasClass}"><input type="number" id="t1_${sId}" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full text-center p-2 rounded-lg outline-none text-xs font-semibold ${tugasClass}" value="${siswa.tugas_1 ?? ''}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAkhir('${sId}')" onkeydown="handleEnter(event, 't1', ${index})" ${tugasReadonly}></td>
                <td class="px-2 py-3 border-r dark:border-slate-800/80 ${tdTugasClass}"><input type="number" id="t2_${sId}" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full text-center p-2 rounded-lg outline-none text-xs font-semibold ${tugasClass}" value="${siswa.tugas_2 ?? ''}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAkhir('${sId}')" onkeydown="handleEnter(event, 't2', ${index})" ${tugasReadonly}></td>
                <td class="px-2 py-3 border-r dark:border-slate-800/80 ${tdTugasClass}"><input type="number" id="asts_${sId}" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full text-center p-2 rounded-lg outline-none text-xs font-bold ${tugasClass}" value="${siswa.asts ?? ''}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAkhir('${sId}')" onkeydown="handleEnter(event, 'asts', ${index})" ${tugasReadonly}></td>
                
                <td class="px-2 py-3 border-r dark:border-slate-800/80 bg-amber-50/5 dark:bg-slate-900/5"><input type="number" id="t4_${sId}" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full text-center p-2 rounded-lg outline-none text-xs font-semibold ${asasClass}" value="${siswa.tugas_4 ?? ''}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAkhir('${sId}')" onkeydown="handleEnter(event, 't4', ${index})" ${asasReadonly}></td>
                <td class="px-2 py-3 border-r dark:border-slate-800/80 bg-amber-50/5 dark:bg-slate-900/5"><input type="number" id="t5_${sId}" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full text-center p-2 rounded-lg outline-none text-xs font-semibold ${asasClass}" value="${siswa.tugas_5 ?? ''}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAkhir('${sId}')" onkeydown="handleEnter(event, 't5', ${index})" ${asasReadonly}></td>
                
                ${tdPG}
                ${tdES}
                ${tdMurni}
                ${tdPerbaikan}
                
                <td class="px-2 py-3 border-r dark:border-slate-800/80 bg-slate-50 dark:bg-slate-900/40 font-bold text-center" id="ketuntasan_${sId}">${siswa.ketuntasan || '-'}</td>
                <td class="px-2 py-3 bg-emerald-50/30 dark:bg-emerald-950/20 font-bold text-center text-base text-emerald-700 dark:text-emerald-400" id="akhir_${sId}">${siswa.nilai_akhir ?? '0'}</td>
            `;
            tbody.appendChild(tr);

            // Set dynamic essai dropdown values
            if (!isProduktif) {
                for (let i = 1; i <= 5; i++) {
                    const elSel = document.getElementById(`es${i}_${sId}`);
                    if (elSel) elSel.value = esVals[i-1];
                }
            }

            if (siswa.murni_asas !== null || siswa.tugas_1 !== null || siswa.asts !== null) {
                calculateAkhir(sId);
            }
        });
    }

    function recalculateAll() {
        const modeSelect = document.getElementById('global-asas-mode');
        const mode = modeSelect ? modeSelect.value.toLowerCase() : "benar";
        const thPg = document.getElementById('th-pg');

        if (thPg) {
            if (mode === 'fasttrack') {
                thPg.className = "px-4 py-4 w-32 min-w-[128px] text-center border-r border-b dark:border-slate-800 bg-blue-100/60 dark:bg-slate-800/80 text-blue-900 dark:text-blue-400 font-bold sticky top-0 z-40 transition-all duration-300";
            } else {
                thPg.className = "px-4 py-4 w-[280px] min-w-[280px] text-center border-r border-b dark:border-slate-800 bg-blue-100/60 dark:bg-slate-800/80 text-blue-900 dark:text-blue-400 font-bold sticky top-0 z-40 transition-all duration-300";
            }
        }

        studentsData.forEach(siswa => {
            const pgInput = document.getElementById(`pg_${siswa.siswa_id}`);
            if (pgInput) {
                pgInput.placeholder = (mode === 'fasttrack') ? "Cth: 24" : "Cth: 1,2.. / 25 / benar semua";
            }
            calculateMurni(siswa.siswa_id);
        });
    }

    function calculateMurni(siswaId) {
        const isProduktif = currentMapelType.toLowerCase() === "praktik" || currentMapelType.toLowerCase() === "produktif";
        if (isProduktif) {
            calculateAkhir(siswaId);
            return;
        }

        const modeSelect = document.getElementById('global-asas-mode');
        const mode = modeSelect ? modeSelect.value.toLowerCase() : "benar";
        const pgInput = document.getElementById(`pg_${siswaId}`).value.trim().toLowerCase();
        const esInput = document.getElementById(`es_${siswaId}`).value.trim();

        const selectMapelEl = document.getElementById('select-mapel');
        const mapelText = (selectMapelEl && selectMapelEl.selectedIndex >= 0) 
            ? selectMapelEl.options[selectMapelEl.selectedIndex].text.toLowerCase() 
            : "";
        
        const isMath = currentMapelType.toLowerCase().includes("matematika") || 
                       mapelText.includes("matematika") || 
                       mapelText.includes("mtk");

        const maxPG = isMath ? 25 : 30;
        const bobotPG = isMath ? 2.4 : 2;
        const maxES = 5;

        let finalPG = 0;
        let finalES = 0;

        // PG Calculation
        if (pgInput === "benar semua") {
            finalPG = maxPG * bobotPG;
        } else if (pgInput === "salah semua") {
            finalPG = 0;
        } else if (mode === "fasttrack") {
            let countPG = parseInt(pgInput);
            if (isNaN(countPG)) countPG = 0;
            if (countPG > maxPG) countPG = maxPG;
            if (countPG < 0) countPG = 0;
            finalPG = countPG * bobotPG;
        } else {
            let countPG = pgInput ? pgInput.split(',').filter(i => i.trim() !== "").length : 0;
            if (countPG > maxPG) countPG = maxPG;
            if (mode === "benar") finalPG = countPG * bobotPG;
            else if (mode === "salah") finalPG = (maxPG - countPG) * bobotPG;
        }

        // Essai Calculation
        let scores = esInput.split(',').map(s => parseFloat(s.trim())).filter(n => !isNaN(n));
        scores = scores.slice(0, maxES);
        finalES = scores.reduce((total, num) => total + num, 0);
        if (finalES > 40) finalES = 40;

        let nilaiMurni = Math.round(finalPG + finalES);
        if (nilaiMurni > 100) nilaiMurni = 100;
        if (nilaiMurni < 0) nilaiMurni = 0;

        document.getElementById(`murni_${siswaId}`).value = nilaiMurni;
        calculateAkhir(siswaId);
    }

    function calculateAkhir(siswaId) {
        const getVal = (id) => {
            const el = document.getElementById(id);
            return el ? parseFloat(el.value) || 0 : 0;
        };

        const isProduktif = currentMapelType.toLowerCase() === "praktik" || currentMapelType.toLowerCase() === "produktif";
        let asas = 0;

        if (isProduktif) {
            asas = getVal(`murni_${siswaId}`);
        } else {
            let perbaikanEl = document.getElementById(`perbaikan_${siswaId}`);
            let perbaikan = perbaikanEl ? perbaikanEl.value : "";
            asas = perbaikan !== "" ? parseFloat(perbaikan) : getVal(`murni_${siswaId}`);
        }

        let rataRata = Math.round((getVal(`t1_${siswaId}`) + getVal(`t2_${siswaId}`) + getVal(`asts_${siswaId}`) + getVal(`t4_${siswaId}`) + getVal(`t5_${siswaId}`) + asas) / 6);
        document.getElementById(`akhir_${siswaId}`).innerText = rataRata;

        const elKetuntasan = document.getElementById(`ketuntasan_${siswaId}`);
        if (rataRata >= 75) {
            elKetuntasan.innerText = "TUNTAS";
            elKetuntasan.className = "px-2 py-3 border-r dark:border-slate-800/80 bg-emerald-50 dark:bg-emerald-950/20 font-bold text-center text-emerald-600 dark:text-emerald-400";
        } else {
            elKetuntasan.innerText = "TIDAK TUNTAS";
            elKetuntasan.className = "px-2 py-3 border-r dark:border-slate-800/80 bg-rose-50 dark:bg-rose-950/20 font-bold text-center text-rose-600 dark:text-rose-400";
        }
    }

    function saveGrades() {
        const modeGlobal = document.getElementById('global-asas-mode') ? document.getElementById('global-asas-mode').value : "Benar";

        const getValStr = (id) => { const el = document.getElementById(id); return el ? el.value : ""; };
        const getInnerStr = (id) => { const el = document.getElementById(id); return el ? el.innerText : ""; };

        const payloadData = studentsData.map(siswa => ({
            siswa_id: siswa.siswa_id,
            tugas_1: getValStr(`t1_${siswa.siswa_id}`),
            tugas_2: getValStr(`t2_${siswa.siswa_id}`),
            asts: getValStr(`asts_${siswa.siswa_id}`),
            tugas_4: getValStr(`t4_${siswa.siswa_id}`),
            tugas_5: getValStr(`t5_${siswa.siswa_id}`),
            mode_asas: modeGlobal,
            pg_asas: getValStr(`pg_${siswa.siswa_id}`),
            essai_asas: getValStr(`es_${siswa.siswa_id}`),
            murni_asas: getValStr(`murni_${siswa.id ?? siswa.siswa_id}`),
            perbaikan: getValStr(`perbaikan_${siswa.siswa_id}`),
            ketuntasan: getInnerStr(`ketuntasan_${siswa.siswa_id}`),
            nilai_akhir: getInnerStr(`akhir_${siswa.siswa_id}`)
        }));

        const btnSave = document.getElementById('btn-save');
        const loader = document.getElementById('save-loader');
        btnSave.disabled = true;
        loader.classList.remove('hidden');

        ajaxPost("{{ route('portalnilai.grades.save') }}", {
            kelas_id: currentClass,
            mapel_id: currentMapel,
            payload: payloadData
        }).then(res => {
            btnSave.disabled = false;
            loader.classList.add('hidden');
            if (res.status === "success") {
                showToast(res.message, "success");
            } else {
                showToast(res.message, "error");
            }
        }).catch(() => {
            btnSave.disabled = false;
            loader.classList.add('hidden');
            showToast("Gagal menyimpan data.", "error");
        });
    }
</script>
@endsection
