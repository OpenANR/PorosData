<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\Hash::extend('plain', function () {
            return new \App\Services\PlainTextHasher();
        });

        if (\Illuminate\Support\Facades\Schema::hasTable('instansi')) {
            \Illuminate\Support\Facades\View::share('instansi_app', \App\Models\Instansi::first());
        }
    }
}
