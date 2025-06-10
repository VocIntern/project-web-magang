<?php

use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMagangController;
use App\Http\Controllers\Admin\AdminPerusahaanController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Auth\AuthController;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\EmailVerificationController;

use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\Mahasiswa\MahasiswaMagangController;
use App\Http\Controllers\Mahasiswa\MahasiswaProfileController;
use App\Http\Controllers\Perusahaan\DashboardPerusahaanController;
use App\Http\Controllers\Perusahaan\PerusahaanProfileController;
use App\Http\Controllers\Perusahaan\SeleksiMahasiswaController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return view('welcome');
});

// untuk refresh role
Route::get('/refresh-session', [SessionController::class, 'refresh'])->name('session.refresh');

// Route utama untuk halaman welcome
Route::get('/', [MagangController::class, 'index'])->name('welcome');

// Route untuk pencarian AJAX (tidak akan refresh halaman)
Route::post('/ajax-search', [MagangController::class, 'ajaxSearch'])->name('ajax.search');

// Route untuk AJAX pagination (tanpa search)
Route::get('/ajax/paginate', [MagangController::class, 'ajaxPaginate'])->name('ajax.paginate');

// Route untuk live search (pencarian real-time saat mengetik)
Route::get('/live-search', [MagangController::class, 'liveSearch'])->name('live.search');

// Route lainnya...
Route::get('/magang', function () {
    return view('magang.index');
});

Route::get('/perusahaan', function () {
    return view('perusahaan.index');
});

Route::get('/tentang', function () {
    return view('tentang');
});
/*
|--------------------------------------------------------------------------
| Mahasiswa Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {

    // TAMBAHAN ROUTE baru
    Route::get('/profile/create', [MahasiswaProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [MahasiswaProfileController::class, 'store'])->name('profile.store');


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

    // Dashboard utama
    Route::get('/dashboard', [DashboardPerusahaanController::class, 'index'])->name('dashboard');

    // Profile completion for perusahaan
    Route::get('/profile/create', [PerusahaanProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [PerusahaanProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/edit', [PerusahaanProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [PerusahaanProfileController::class, 'update'])->name('profile.update');

    // Halaman Seleksi Mahasiswa
    Route::get('/seleksi-mahasiswa', [SeleksiMahasiswaController::class, 'index'])->name('seleksi.index');

    // Update status mahasiswa (untuk AJAX)
    Route::put('/seleksi-mahasiswa/{id}/status', [SeleksiMahasiswaController::class, 'updateStatus'])->name('seleksi.update-status');

    // Detail mahasiswa
    Route::get('/seleksi-mahasiswa/{id}/detail', [SeleksiMahasiswaController::class, 'detail'])->name('seleksi.detail');
    // // Seleksi mahasiswa
    // Route::get('/seleksi-mahasiswa', [DashboardPerusahaanController::class, 'seleksiMahasiswa'])->name('seleksi-mahasiswa');
    // Update status pelamar (AJAX)
    Route::patch('/pelamar/{id}/status', [DashboardPerusahaanController::class, 'updateStatusPelamar'])->name('pelamar.update-status');
    // Route untuk detail pelamar
    Route::get('/pelamar/{id}', [DashboardPerusahaanController::class, 'detailPelamar'])->name('pelamar.detail');
    // Profil perusahaan
    Route::get('/profil', [DashboardPerusahaanController::class, 'profilPerusahaan'])->name('profil');
    Route::put('/profil', [DashboardPerusahaanController::class, 'updateProfil'])->name('profil.update');
    // Lowongan magang
    Route::get('/lowongan-magang', [DashboardPerusahaanController::class, 'lowonganMagang'])->name('lowongan');
    Route::get('/lowongan-magang/create', [DashboardPerusahaanController::class, 'createLowongan'])->name('lowongan.create');
    Route::post('/lowongan-magang', [DashboardPerusahaanController::class, 'storeLowongan'])->name('lowongan.store');

    // Route tambahan untuk manajemen lowongan
    Route::get('/lowongan-magang/{id}/edit', [DashboardPerusahaanController::class, 'editLowongan'])->name('lowongan.edit');
    Route::put('/lowongan-magang/{id}', [DashboardPerusahaanController::class, 'updateLowongan'])->name('lowongan.update');
    Route::delete('/lowongan-magang/{id}', [DashboardPerusahaanController::class, 'deleteLowongan'])->name('lowongan.delete');



    // Route untuk laporan magang
    Route::get('/laporan-magang', [DashboardPerusahaanController::class, 'laporanMagang'])->name('laporan');
    Route::get('/laporan-magang/{id}', [DashboardPerusahaanController::class, 'detailLaporan'])->name('laporan.detail');
    // Route untuk memberikan feedback laporan
    Route::post('/laporan/{id}/feedback', [DashboardPerusahaanController::class, 'feedbackLaporan'])->name('laporan.feedback');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');


    // Lebih Konsisten dan Sesuai dengan View
    Route::get('/dashboard/api/stats', [AdminDashboardController::class, 'getStats'])->name('admin.dashboard.stats');
    Route::get('/dashboard/api/recent', [AdminDashboardController::class, 'getRecentData'])->name('admin.dashboard.recent');

    // Mahasiswa management
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('admin.mahasiswa.index');
    Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('admin.mahasiswa.create');
    Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('admin.mahasiswa.store');
    Route::get('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'show'])->name('admin.mahasiswa.show');
    Route::get('/mahasiswa/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit');
    Route::put('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
    Route::delete('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('admin.mahasiswa.destroy');


    // Magang management
    Route::get('/magang', [AdminMagangController::class, 'index'])->name('admin.magang.index');
    Route::get('/magang/create', [AdminMagangController::class, 'create'])->name('admin.magang.create');
    Route::post('/magang', [AdminMagangController::class, 'store'])->name('admin.magang.store');
    Route::get('/magang/{magang}', [AdminMagangController::class, 'show'])->name('admin.magang.show');
    Route::get('/magang/{magang}/edit', [AdminMagangController::class, 'edit'])->name('admin.magang.edit');
    Route::put('/magang/{magang}', [AdminMagangController::class, 'update'])->name('admin.magang.update');
    Route::delete('/magang/{magang}', [AdminMagangController::class, 'destroy'])->name('admin.magang.destroy');

    //Perusahaan management
    Route::get('/admin/perusahaan', [AdminPerusahaanController::class, 'index'])->name('admin.perusahaan.index');
});




require __DIR__ . '/auth.php';
