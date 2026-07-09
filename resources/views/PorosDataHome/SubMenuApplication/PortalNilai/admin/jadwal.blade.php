@extends('PorosDataHome.SubMenuApplication.PortalNilai.layouts.app')

@section('title', 'Pengaturan Jadwal - Portal Nilai')
@section('page_title', 'Pengaturan Jadwal')

@section('content')
<div class="flex flex-col gap-6">
    <!-- PANEL PENGATURAN AKSES JADWAL -->
    <div id="admin-panel" class="glass-panel border border-slate-200/80 dark:border-slate-800/80 rounded-2xl p-6 shadow-sm flex flex-col gap-6 shrink-0 animate-fade-in">
        <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100 dark:border-slate-800/60">
            <div class="h-9 w-9 rounded-lg bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-sm shadow-sm">
                <i class="fa-solid fa-gears"></i>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 dark:text-slate-200 text-xs">Pengaturan Jadwal Pengisian</h4>
                <p class="text-[10px] text-slate-400">Atur masa tenggang akses input nilai akhir guru mapel.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs font-semibold">
            <!-- Tugas & ASTS Column -->
            <div class="space-y-4">
                <h5 class="text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Jadwal Tugas & ASTS</h5>
                <div class="space-y-3">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-slate-500">Waktu Buka</label>
                        <input type="datetime-local" id="admin-tugas-buka" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 outline-none focus:border-blue-500 font-bold text-slate-700 dark:text-slate-200 select-hide-arrow text-center cursor-pointer">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-slate-500">Waktu Tutup</label>
                        <input type="datetime-local" id="admin-tugas-tutup" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 outline-none focus:border-blue-500 font-bold text-slate-700 dark:text-slate-200 select-hide-arrow text-center cursor-pointer">
                    </div>
                </div>
            </div>

            <!-- ASAS Genap Column -->
            <div class="space-y-4">
                <h5 class="text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Jadwal ASAS GENAP</h5>
                <div class="space-y-3">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-slate-500">Waktu Buka</label>
                        <input type="datetime-local" id="admin-waktu-buka" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 outline-none focus:border-blue-500 font-bold text-slate-700 dark:text-slate-200 select-hide-arrow text-center cursor-pointer">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-slate-500">Waktu Tutup</label>
                        <input type="datetime-local" id="admin-waktu-tutup" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 outline-none focus:border-blue-500 font-bold text-slate-700 dark:text-slate-200 select-hide-arrow text-center cursor-pointer">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-2 border-t border-slate-100 dark:border-slate-800/60">
            <button onclick="saveAdminSettings()" id="btn-save-settings" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white font-bold text-xs shadow-md shadow-indigo-500/15 dark:shadow-none hover:shadow-xl active:scale-[0.98] transition-all flex items-center justify-center gap-2 cursor-pointer">
                <i class="fa-regular fa-floppy-disk"></i>
                <span>Simpan Pengaturan Jadwal</span>
                <div id="settings-loader" class="loader hidden"></div>
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetchAdminSettings();
    });

    function fetchAdminSettings() {
        ajaxGet("{{ route('portalnilai.settings.get') }}")
        .then(res => {
            if (res.status === "success" && res.data) {
                document.getElementById('admin-tugas-buka').value = res.data.tugas_buka || '';
                document.getElementById('admin-tugas-tutup').value = res.data.tugas_tutup || '';
                document.getElementById('admin-waktu-buka').value = res.data.asas_buka || '';
                document.getElementById('admin-waktu-tutup').value = res.data.asas_tutup || '';
            }
        });
    }

    function saveAdminSettings() {
        const adminBuka = document.getElementById('admin-waktu-buka').value;
        const adminTutup = document.getElementById('admin-waktu-tutup').value;
        const tugasBuka = document.getElementById('admin-tugas-buka').value;
        const tugasTutup = document.getElementById('admin-tugas-tutup').value;

        const btnSaveSettings = document.getElementById('btn-save-settings');
        const loader = document.getElementById('settings-loader');
        btnSaveSettings.disabled = true;
        loader.classList.remove('hidden');

        ajaxPost("{{ route('portalnilai.settings.save') }}", {
            asas_buka: adminBuka,
            asas_tutup: adminTutup,
            tugas_buka: tugasBuka,
            tugas_tutup: tugasTutup
        }).then(res => {
            btnSaveSettings.disabled = false;
            loader.classList.add('hidden');
            if (res.status === "success") {
                showToast(res.message, "success");
            } else {
                showToast(res.message, "error");
            }
        }).catch(() => {
            btnSaveSettings.disabled = false;
            loader.classList.add('hidden');
            showToast("Terjadi kesalahan koneksi.", "error");
        });
    }
</script>
@endsection
