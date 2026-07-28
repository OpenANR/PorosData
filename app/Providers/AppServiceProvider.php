<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

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
        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'id', 'indonesian');

        \Illuminate\Support\Facades\Hash::extend('plain', function () {
            return new \App\Services\PlainTextHasher();
        });

        if (\Illuminate\Support\Facades\Schema::hasTable('instansi')) {
            \Illuminate\Support\Facades\View::share('instansi_app', \App\Models\Instansi::first());
        }
    }
}

