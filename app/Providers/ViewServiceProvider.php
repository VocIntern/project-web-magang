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
            if (Auth::check()) {
                $user = Auth::user();
                $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
                $view->with('mahasiswa', $mahasiswa);
            }
        });
    }

    public function register() {}
}
