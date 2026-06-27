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

    // Sub Menu Application Routes (restricted to admin & superadmin)
    Route::get('/datasiswa', function () {
        return view('PorosDataHome.SubMenuApplication.DataSiswa.index');
    })->name('datasiswa.index');

    Route::get('/portalnilai', function () {
        return view('PorosDataHome.SubMenuApplication.PortalNilai.index');
    })->name('portalnilai.index');

    Route::get('/portalpkl', function () {
        return view('PorosDataHome.SubMenuApplication.PortalPKL.index');
    })->name('portalpkl.index');

    Route::get('/portalsiswa', function () {
        return view('PorosDataHome.SubMenuApplication.PortalSiswa.index');
    })->name('portalsiswa.index');
});

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
