<?php

use App\Http\Controllers\Dekan\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenPa\BimbinganController;
use App\Http\Controllers\Kaprodi\MasterDataController;
use App\Http\Controllers\Kaprodi\RuleController;
use App\Http\Controllers\Mahasiswa\AcademicProfileController;
use App\Http\Controllers\Mahasiswa\RecommendationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard/mahasiswa', 'dashboard.mahasiswa')
        ->middleware('role:mahasiswa')
        ->name('dashboard.mahasiswa');

    Route::get('/mahasiswa/profil-akademik', [AcademicProfileController::class, 'index'])
        ->middleware('role:mahasiswa')
        ->name('mahasiswa.academic-profile.index');
    Route::post('/mahasiswa/profil-akademik', [AcademicProfileController::class, 'store'])
        ->middleware('role:mahasiswa')
        ->name('mahasiswa.academic-profile.store');
    Route::get('/mahasiswa/rekomendasi', [RecommendationController::class, 'index'])
        ->middleware('role:mahasiswa')
        ->name('mahasiswa.rekomendasi.index');
    Route::post('/mahasiswa/rekomendasi/regenerate', [RecommendationController::class, 'regenerate'])
        ->middleware('role:mahasiswa')
        ->name('mahasiswa.rekomendasi.regenerate');
    Route::post('/mahasiswa/rekomendasi/{rekomendasiMataKuliah}/choose', [RecommendationController::class, 'choose'])
        ->middleware('role:mahasiswa')
        ->name('mahasiswa.rekomendasi.choose');
    Route::delete('/mahasiswa/rekomendasi/{rekomendasiMataKuliah}/choose', [RecommendationController::class, 'unchoose'])
        ->middleware('role:mahasiswa')
        ->name('mahasiswa.rekomendasi.unchoose');

    Route::view('/dashboard/dosen-pa', 'dashboard.dosen-pa')
        ->middleware('role:dosen_pa')
        ->name('dashboard.dosen-pa');

    Route::get('/dosen-pa/bimbingan', [BimbinganController::class, 'index'])
        ->middleware('role:dosen_pa')
        ->name('dosen-pa.bimbingan.index');
    Route::post('/dosen-pa/bimbingan/override', [BimbinganController::class, 'override'])
        ->middleware('role:dosen_pa')
        ->name('dosen-pa.bimbingan.override');
    Route::patch('/dosen-pa/bimbingan/override/{rekomendasiMataKuliah}', [BimbinganController::class, 'updateOverride'])
        ->middleware('role:dosen_pa')
        ->name('dosen-pa.bimbingan.override.update');
    Route::delete('/dosen-pa/bimbingan/override/{rekomendasiMataKuliah}', [BimbinganController::class, 'deleteOverride'])
        ->middleware('role:dosen_pa')
        ->name('dosen-pa.bimbingan.override.delete');
    Route::patch('/dosen-pa/bimbingan/override-log/{rekomendasiOverrideLog}', [BimbinganController::class, 'updateOverrideLog'])
        ->middleware('role:dosen_pa')
        ->name('dosen-pa.bimbingan.override-log.update');
    Route::delete('/dosen-pa/bimbingan/override-log/{rekomendasiOverrideLog}', [BimbinganController::class, 'deleteOverrideLog'])
        ->middleware('role:dosen_pa')
        ->name('dosen-pa.bimbingan.override-log.delete');

    Route::view('/dashboard/kaprodi', 'dashboard.kaprodi')
        ->middleware('role:kaprodi')
        ->name('dashboard.kaprodi');

    Route::get('/kaprodi/master-data', [MasterDataController::class, 'index'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.master-data.index');
    Route::post('/kaprodi/master-data/minat-topik', [MasterDataController::class, 'storeMinat'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.master-data.minat.store');
    Route::get('/kaprodi/master-data/minat-topik/{minatTopik}/edit', [MasterDataController::class, 'editMinat'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.master-data.minat.edit');
    Route::put('/kaprodi/master-data/minat-topik/{minatTopik}', [MasterDataController::class, 'updateMinat'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.master-data.minat.update');
    Route::delete('/kaprodi/master-data/minat-topik/{minatTopik}', [MasterDataController::class, 'destroyMinat'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.master-data.minat.destroy');
    Route::post('/kaprodi/master-data/mata-kuliah', [MasterDataController::class, 'storeMataKuliah'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.master-data.mata-kuliah.store');
    Route::get('/kaprodi/master-data/mata-kuliah/{mataKuliah}/edit', [MasterDataController::class, 'editMataKuliah'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.master-data.mata-kuliah.edit');
    Route::put('/kaprodi/master-data/mata-kuliah/{mataKuliah}', [MasterDataController::class, 'updateMataKuliah'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.master-data.mata-kuliah.update');
    Route::delete('/kaprodi/master-data/mata-kuliah/{mataKuliah}', [MasterDataController::class, 'destroyMataKuliah'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.master-data.mata-kuliah.destroy');

    Route::get('/kaprodi/rules', [RuleController::class, 'index'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.rules.index');
    Route::post('/kaprodi/rules', [RuleController::class, 'store'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.rules.store');
    Route::get('/kaprodi/rules/{rule}/edit', [RuleController::class, 'edit'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.rules.edit');
    Route::put('/kaprodi/rules/{rule}', [RuleController::class, 'update'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.rules.update');
    Route::patch('/kaprodi/rules/{rule}/toggle', [RuleController::class, 'toggle'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.rules.toggle');
    Route::delete('/kaprodi/rules/{rule}', [RuleController::class, 'destroy'])
        ->middleware('role:kaprodi')
        ->name('kaprodi.rules.destroy');

    Route::view('/dashboard/dekan', 'dashboard.dekan')
        ->middleware('role:dekan')
        ->name('dashboard.dekan');

    Route::get('/dekan/laporan', [ReportController::class, 'index'])
        ->middleware('role:dekan')
        ->name('dekan.reports.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/test-db', function () {
    return [
        'minat' => \App\Models\MinatTopik::count(),
        'mk' => \App\Models\MataKuliah::count(),
    ];
});

require __DIR__.'/auth.php';
