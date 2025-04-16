<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsAuthenticated;
use App\Http\Middleware\IsKasir;
use App\Http\Middleware\IsGuest;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => IsAuthenticated::class,
            'admin' => IsAdmin::class,
            'kasir' => IsKasir::class,
            'guest' => IsGuest::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
