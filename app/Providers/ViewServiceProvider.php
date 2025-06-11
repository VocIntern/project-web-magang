<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check() && Auth::user()->isMahasiswa()) { // Hanya jalankan jika rolenya mahasiswa
                $user = Auth::user();
                // Gunakan nama variabel yang lebih spesifik
                $authMahasiswaProfile = Mahasiswa::where('user_id', $user->id)->first();
                // Bagikan dengan nama yang spesifik
                $view->with('authMahasiswaProfile', $authMahasiswaProfile);
            }
        });
    }

    public function register() {}
}
