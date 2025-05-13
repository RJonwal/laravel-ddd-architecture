<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Admin layout and partials blade files
        View::addNamespace('Layouts', base_path('app/Domains/Admin/Layouts'));
        View::addNamespace('Auth', base_path('app/Domains/Admin/Auth/Views'));

        View::addNamespace('Dashboard', base_path('app/Domains/Admin/Dashboard/Views'));
        View::addNamespace('User', base_path('app/Domains/Admin/User/Views'));
    }
}
