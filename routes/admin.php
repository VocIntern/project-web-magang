Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
Route::resource('mahasiswa', App\Http\Controllers\Admin\MahasiswaController::class);
Route::resource('perusahaan', App\Http\Controllers\Admin\PerusahaanController::class);
Route::resource('magang', App\Http\Controllers\Admin\MagangController::class);
});