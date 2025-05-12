<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // require base_path('app/Domains/Auth/Routes/route.php');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         // For auth routes (e.g., login, register) — no auth middleware
        Route::middleware(['web', 'PreventBackHistory', 'guest'])->group(
            base_path('app/Domains/Admin/Auth/Routes/auth.php')
        );

        // For dashboard routes (protected by auth)
        Route::middleware(['web', 'auth', 'PreventBackHistory'])
        ->group(function () {
            // Add more route files as needed
            require base_path('app/Domains/Admin/Dashboard/Routes/dashboard.php');
        });

        
    }
}
