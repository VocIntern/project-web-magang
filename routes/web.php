<?php

use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\Mahasiswa\MahasiswaMagangController;
use App\Http\Controllers\Mahasiswa\MahasiswaProfileController;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PerusahaanProfileController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return view('welcome');
});

// untuk refresh role
Route::get('/refresh-session', [SessionController::class, 'refresh'])->name('session.refresh');

// routes/web.php
Route::get('/', [MagangController::class, 'index'])->name('welcome');
Route::get('/search', [MagangController::class, 'search'])->name('search');
// Atau jika ingin tetap menggunakan POST untuk pencarian
Route::post('/search', [MagangController::class, 'search'])->name('search');
/*
|--------------------------------------------------------------------------
| Mahasiswa Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    
     // TAMBAHAN ROUTE baru
    Route::get('/profile/create', [MahasiswaProfileController::class, 'create'])->name('profile.create');
    // Route::post('/profile', [MahasiswaProfileController::class, 'store'])->name('profile.store');
    
    
    // Profile management untuk mahasiswa - menggunakan controller yang spesifik
    Route::get('/profile/edit', [MahasiswaProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [MahasiswaProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [MahasiswaProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::delete('/profile', [MahasiswaProfileController::class, 'destroy'])->name('profile.destroy');

    // Magang search and details
    Route::get('/magang/search', [MahasiswaMagangController::class, 'search'])->name('magang.search');
    Route::get('/magang/{id}', [MahasiswaMagangController::class, 'show'])->name('magang.show');

    // Magang application
    Route::get('/magang/{id}/apply', [MahasiswaMagangController::class, 'showApplyForm'])->name('magang.apply.form');
    Route::post('/magang/{id}/apply', [MahasiswaMagangController::class, 'apply'])->name('magang.apply.submit');
});

/*
|--------------------------------------------------------------------------
| Perusahaan Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:perusahaan'])->prefix('perusahaan')->name('perusahaan.')->group(function () {
    // Profile completion for perusahaan
    Route::get('/profile/create', [PerusahaanProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [PerusahaanProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/edit', [PerusahaanProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [PerusahaanProfileController::class, 'update'])->name('profile.update');

    // // Dashboard
    // Route::get('/dashboard', function () {
    //     return view('perusahaan.dashboard');
    // })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Mahasiswa management
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('admin.mahasiswa.index');
    Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('admin.mahasiswa.create');
    Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('admin.mahasiswa.store');
    Route::get('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'show'])->name('admin.mahasiswa.show');
    Route::get('/mahasiswa/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit');
    Route::put('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
    Route::delete('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('admin.mahasiswa.destroy');

    // Perusahaan management
    Route::get('/perusahaan', [PerusahaanController::class, 'index'])->name('admin.perusahaan.index');
    Route::get('/perusahaan/create', [PerusahaanController::class, 'create'])->name('admin.perusahaan.create');
    Route::post('/perusahaan', [PerusahaanController::class, 'store'])->name('admin.perusahaan.store');
    Route::get('/perusahaan/{perusahaan}', [PerusahaanController::class, 'show'])->name('admin.perusahaan.show');
    Route::get('/perusahaan/{perusahaan}/edit', [PerusahaanController::class, 'edit'])->name('admin.perusahaan.edit');
    Route::put('/perusahaan/{perusahaan}', [PerusahaanController::class, 'update'])->name('admin.perusahaan.update');
    Route::delete('/perusahaan/{perusahaan}', [PerusahaanController::class, 'destroy'])->name('admin.perusahaan.destroy');

    // Magang management
    Route::get('/magang', [MagangController::class, 'index'])->name('admin.magang.index');
    Route::get('/magang/create', [MagangController::class, 'create'])->name('admin.magang.create');
    Route::post('/magang', [MagangController::class, 'store'])->name('admin.magang.store');
    Route::get('/magang/{magang}', [MagangController::class, 'show'])->name('admin.magang.show');
    Route::get('/magang/{magang}/edit', [MagangController::class, 'edit'])->name('admin.magang.edit');
    Route::put('/magang/{magang}', [MagangController::class, 'update'])->name('admin.magang.update');
    Route::delete('/magang/{magang}', [MagangController::class, 'destroy'])->name('admin.magang.destroy');
});




require __DIR__ . '/auth.php';
