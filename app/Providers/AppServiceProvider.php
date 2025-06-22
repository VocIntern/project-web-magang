<?php

namespace App\Providers;

use Carbon\Carbon;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        // URL::forceRootUrl(config('app.url'));
        // // Jika perlu, paksa skema URL
        // if (str_contains(config('app.url'), 'https://')) {
        //     URL::forceScheme('https');
        // }
    }
}
