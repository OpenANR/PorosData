<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureIsAdminOrSuperadmin::class,
            'auth.ejournal' => \App\Http\Middleware\EnsureEJournalAuthenticated::class,
            'auth.portalpkl' => \App\Http\Middleware\EnsurePortalPKLAuthenticated::class,
            'auth.portalnilai' => \App\Http\Middleware\EnsurePortalNilaiAuthenticated::class,
            'auth.datasiswa' => \App\Http\Middleware\EnsureDataSiswaAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
