<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMagangController;
use App\Http\Controllers\Admin\AdminPerusahaanController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Auth\AdminLoginController;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\Mahasiswa\MahasiswaMagangController;
use App\Http\Controllers\Mahasiswa\MahasiswaProfileController;
use App\Http\Controllers\Perusahaan\DashboardPerusahaanController;
use App\Http\Controllers\Perusahaan\PerusahaanLowonganController;
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

    // Profile management
    Route::get('/profile/create', [PerusahaanProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile/store', [PerusahaanProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/edit', [PerusahaanProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [PerusahaanProfileController::class, 'update'])->name('profile.update');

    // Halaman Seleksi Mahasiswa
    Route::get('/seleksi', [SeleksiMahasiswaController::class, 'index'])->name('perusahaan.seleksi.index');
    Route::get('/seleksi-mahasiswa', [SeleksiMahasiswaController::class, 'index'])->name('seleksi.index');
    Route::put('/seleksi-mahasiswa/{id}/status', [SeleksiMahasiswaController::class, 'updateStatus'])->name('seleksi.update-status');
    Route::get('/seleksi-mahasiswa/{id}/detail', [SeleksiMahasiswaController::class, 'detail'])->name('seleksi.detail');

    // Manajemen Lowongan menggunakan Route::resource
    // Menggantikan 6 baris route manual menjadi 1 baris.
    // Pastikan method di DashboardPerusahaanController namanya sesuai standar resource (index, create, store, edit, update, destroy)
    // Route::resource('lowongan-magang', DashboardPerusahaanController::class)->names('lowongan');
    Route::get('/perusahaan/lowongan', [PerusahaanLowonganController::class, 'index'])->name('lowongan.index');
    Route::get('/lowongan/create', [PerusahaanLowonganController::class, 'create'])->name('lowongan.create');
    Route::post('/lowongan', [PerusahaanLowonganController::class, 'store'])->name('lowongan.store');
    Route::get('/lowongan/{magang}/edit', [PerusahaanLowonganController::class, 'edit'])->name('lowongan.edit');
    Route::put('/lowongan/{magang}', [PerusahaanLowonganController::class, 'update'])->name('lowongan.update');
    Route::delete('/lowongan/{magang}', [PerusahaanLowonganController::class, 'destroy'])->name('lowongan.destroy');

    // Manajemen Laporan Magang
    Route::get('/laporan-magang', [DashboardPerusahaanController::class, 'laporanMagang'])->name('laporan');
    Route::get('/laporan-magang/{id}', [DashboardPerusahaanController::class, 'detailLaporan'])->name('laporan.detail');
    Route::post('/laporan/{id}/feedback', [DashboardPerusahaanController::class, 'feedbackLaporan'])->name('laporan.feedback');

    // Hapus route-route lama yang sudah di-cover oleh resource atau yang sudah tidak terpakai
    // untuk menghindari duplikasi.
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
// Grup untuk login admin (hanya untuk tamu/belum login)
Route::prefix('admin')->middleware('guest')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    // === DASHBOARD ===
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // API endpoints untuk update real-time di dashboard
    Route::get('/dashboard/api/stats', [AdminDashboardController::class, 'getStats'])->name('dashboard.stats');
    Route::get('/dashboard/api/recent', [AdminDashboardController::class, 'getRecentData'])->name('dashboard.recent');


    // === MANAJEMEN DATA (menggunakan Route::resource) ===
    // Definisikan route resource untuk mahasiswa
    // Routes untuk manajemen mahasiswa

    Route::post('/export', [MahasiswaController::class, 'export'])->name('mahasiswa.export');
    Route::resource('mahasiswa', MahasiswaController::class);


    // Manajemen Magang
    Route::post('magang/export', [AdminMagangController::class, 'export'])->name('magang.export');
    Route::resource('magang', AdminMagangController::class);

    // Definisikan route resource untuk perusahaan
    Route::post('perusahaan/export', [AdminPerusahaanController::class, 'export'])->name('perusahaan.export');
    Route::resource('perusahaan', AdminPerusahaanController::class);
});




require __DIR__ . '/auth.php';
