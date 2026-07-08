<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Panel Protected Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/porosdata', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD resource routes
    Route::resource('/porosdata/guru', GuruController::class)->names('guru');
    Route::get('/porosdata/walikelas/export', [WaliKelasController::class, 'exportCsv'])->name('walikelas.export');
    Route::post('/porosdata/walikelas/import', [WaliKelasController::class, 'importCsv'])->name('walikelas.import');
    Route::resource('/porosdata/walikelas', WaliKelasController::class)->names('walikelas');
    Route::resource('/porosdata/kelas', KelasController::class)->names('kelas');
    Route::resource('/porosdata/siswa', SiswaController::class)->names('siswa');
    
    // Mapel and Category Routes
    Route::resource('/porosdata/mapel', App\Http\Controllers\MapelController::class)->names('mapel');
    Route::post('/porosdata/mapel/kategori', [App\Http\Controllers\MapelController::class, 'storeKategori'])->name('mapel.kategori.store');
    Route::put('/porosdata/mapel/kategori/{id}', [App\Http\Controllers\MapelController::class, 'updateKategori'])->name('mapel.kategori.update');
    Route::delete('/porosdata/mapel/kategori/{id}', [App\Http\Controllers\MapelController::class, 'destroyKategori'])->name('mapel.kategori.destroy');
});

// Standalone Shortcut entry points (accessible directly)
Route::get('/datasiswa', function () {
    return view('PorosDataHome.SubMenuApplication.DataSiswa.index');
})->name('datasiswa.index');

Route::get('/portalnilai', function () {
    return redirect()->route('portalnilai.dashboard');
})->name('portalnilai.index');

Route::get('/portalsiswa', function () {
    return view('PorosDataHome.SubMenuApplication.PortalSiswa.index');
})->name('portalsiswa.index');

Route::get('/portalpkl', function () {
    return redirect()->route('portalpkl.dashboard');
})->name('portalpkl.index');

Route::get('/ejournal', function () {
    return redirect()->route('ejournal.index');
})->name('ejournal.index.shortcut');

// Standalone E-Journal Routes (independent login/session)
Route::prefix('/porosdata/e-journal')->group(function () {
    Route::get('/login', [App\Http\Controllers\ControllerSubMenuApps\EJournal\LoginController::class, 'showLoginForm'])->name('ejournal.login');
    Route::post('/login', [App\Http\Controllers\ControllerSubMenuApps\EJournal\LoginController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\ControllerSubMenuApps\EJournal\LoginController::class, 'logout'])->name('ejournal.logout');

    Route::middleware(['auth.ejournal'])->group(function () {
        Route::get('/', [App\Http\Controllers\ControllerSubMenuApps\EJournal\DashboardController::class, 'index'])->name('ejournal.index');
        
        // Guru journal routes
        Route::get('/isi', [App\Http\Controllers\ControllerSubMenuApps\EJournal\GuruJournalController::class, 'isi'])->name('ejournal.guru.isi');
        Route::post('/isi', [App\Http\Controllers\ControllerSubMenuApps\EJournal\GuruJournalController::class, 'store'])->name('ejournal.guru.store');
        Route::get('/riwayat', [App\Http\Controllers\ControllerSubMenuApps\EJournal\GuruJournalController::class, 'riwayat'])->name('ejournal.guru.riwayat');
        Route::get('/kelas/{kelas_id}/siswa', [App\Http\Controllers\ControllerSubMenuApps\EJournal\GuruJournalController::class, 'getSiswa'])->name('ejournal.guru.getSiswa');
        
        // Admin journal routes
        Route::get('/admin', [App\Http\Controllers\ControllerSubMenuApps\EJournal\AdminController::class, 'index'])->name('ejournal.admin.index');
        Route::get('/admin/guru', [App\Http\Controllers\ControllerSubMenuApps\EJournal\AdminController::class, 'kelolaGuru'])->name('ejournal.admin.guru');
        Route::get('/admin/siswa', [App\Http\Controllers\ControllerSubMenuApps\EJournal\AdminController::class, 'kelolaSiswa'])->name('ejournal.admin.siswa');
    });
});

// Standalone Portal PKL Routes (independent login/session)
Route::prefix('/porosdata/portal-pkl')->group(function () {
    Route::get('/login', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\LoginController::class, 'showLoginForm'])->name('portalpkl.login');
    Route::post('/login', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\LoginController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\LoginController::class, 'logout'])->name('portalpkl.logout');

    Route::middleware(['auth.portalpkl'])->group(function () {
        Route::get('/', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\DashboardController::class, 'index'])->name('portalpkl.dashboard');
        
        Route::get('/superadmin', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\SuperAdminController::class, 'index'])->name('portalpkl.superadmin');
        Route::get('/admin', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\AdminController::class, 'index'])->name('portalpkl.admin');
        
        // Mitra DUDI CRUD Routes
        Route::get('/admin/mitra', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\MitraDudiController::class, 'index'])->name('portalpkl.admin.mitra.index');
        Route::post('/admin/mitra', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\MitraDudiController::class, 'store'])->name('portalpkl.admin.mitra.store');
        Route::put('/admin/mitra/{id}', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\MitraDudiController::class, 'update'])->name('portalpkl.admin.mitra.update');
        Route::delete('/admin/mitra/{id}', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\MitraDudiController::class, 'destroy'])->name('portalpkl.admin.mitra.destroy');

        // Pembimbing CRUD Routes
        Route::get('/admin/pembimbing', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\AdminPembimbingController::class, 'index'])->name('portalpkl.admin.pembimbing.index');
        Route::post('/admin/pembimbing', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\AdminPembimbingController::class, 'store'])->name('portalpkl.admin.pembimbing.store');
        Route::put('/admin/pembimbing/{id}', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\AdminPembimbingController::class, 'update'])->name('portalpkl.admin.pembimbing.update');
        Route::delete('/admin/pembimbing/{id}', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\AdminPembimbingController::class, 'destroy'])->name('portalpkl.admin.pembimbing.destroy');

        // Siswa PKL CRUD Routes
        Route::get('/admin/siswa-pkl', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\AdminSiswaController::class, 'index'])->name('portalpkl.admin.siswa.index');
        Route::put('/admin/siswa-pkl/{id}', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\AdminSiswaController::class, 'update'])->name('portalpkl.admin.siswa.update');
        Route::delete('/admin/siswa-pkl/{id}', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\AdminSiswaController::class, 'destroy'])->name('portalpkl.admin.siswa.destroy');

        Route::get('/pembimbing', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\PembimbingController::class, 'index'])->name('portalpkl.pembimbing');
        Route::get('/siswa', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\SiswaController::class, 'index'])->name('portalpkl.siswa');

        // Siswa Kehadiran Routes
        Route::get('/siswa/kehadiran', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\SiswaController::class, 'kehadiran'])->name('portalpkl.siswa.kehadiran');
        Route::post('/siswa/kehadiran', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\SiswaController::class, 'storeKehadiran'])->name('portalpkl.siswa.kehadiran.store');
        Route::get('/siswa/riwayat', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\SiswaController::class, 'riwayat'])->name('portalpkl.siswa.riwayat');

        // Admin Kehadiran Routes
        Route::get('/admin/kehadiran', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\AdminController::class, 'kehadiran'])->name('portalpkl.admin.kehadiran');
        Route::delete('/admin/kehadiran/{id}', [App\Http\Controllers\ControllerSubMenuApps\PortalPKL\AdminController::class, 'destroyKehadiran'])->name('portalpkl.admin.kehadiran.destroy');
    });
});

// Standalone Portal Nilai Routes (independent login/session)
Route::prefix('/porosdata/portalnilai')->group(function () {
    Route::get('/login', [App\Http\Controllers\ControllerSubMenuApps\PortalNilai\LoginController::class, 'showLoginForm'])->name('portalnilai.login');
    Route::post('/login', [App\Http\Controllers\ControllerSubMenuApps\PortalNilai\LoginController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\ControllerSubMenuApps\PortalNilai\LoginController::class, 'logout'])->name('portalnilai.logout');

    Route::middleware(['auth.portalnilai'])->group(function () {
        Route::get('/', [App\Http\Controllers\ControllerSubMenuApps\PortalNilai\DashboardController::class, 'index'])->name('portalnilai.dashboard');
        
        // AJAX Endpoints
        Route::get('/settings-data', [App\Http\Controllers\ControllerSubMenuApps\PortalNilai\DashboardController::class, 'getSettings'])->name('portalnilai.settings.get');
        Route::post('/settings-data', [App\Http\Controllers\ControllerSubMenuApps\PortalNilai\DashboardController::class, 'saveSettings'])->name('portalnilai.settings.save');
        Route::get('/students-data', [App\Http\Controllers\ControllerSubMenuApps\PortalNilai\DashboardController::class, 'getStudentsData'])->name('portalnilai.students.get');
        Route::post('/save-grades', [App\Http\Controllers\ControllerSubMenuApps\PortalNilai\DashboardController::class, 'saveGrades'])->name('portalnilai.grades.save');
    });
});
