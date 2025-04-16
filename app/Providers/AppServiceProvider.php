<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
        Gate::define('akses-sales-index', function ($user) {
            return $user->role === 'admin' || $user->role === 'kasir';
        });

        Gate::define('akses-sales-create', function ($user) {
            return $user->role === 'kasir';
        });
    }
}
