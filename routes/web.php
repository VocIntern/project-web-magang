<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\MahasiswaProfileController;
use App\Http\Controllers\PerusahaanProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return view('welcome');
});

// untuk refresh role
Route::get('/refresh-session', [SessionController::class, 'refresh'])->name('session.refresh');

Route::get('/', [MagangController::class, 'index'])->name('welcome');
/*
|--------------------------------------------------------------------------
| Mahasiswa Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    // Profile completion for mahasiswa
    Route::get('/profile/create', [MahasiswaProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [MahasiswaProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/edit', [MahasiswaProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [MahasiswaProfileController::class, 'update'])->name('profile.update');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('dashboard');
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

    // Dashboard
    Route::get('/dashboard', function () {
        return view('perusahaan.dashboard');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});
/*
|--------------------------------------------------------------------------
| Mahasiswa Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    // Profile completion for mahasiswa
    Route::get('/profile/create', [MahasiswaProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [MahasiswaProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/edit', [MahasiswaProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [MahasiswaProfileController::class, 'update'])->name('profile.update');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('dashboard');
});



require __DIR__ . '/auth.php';
