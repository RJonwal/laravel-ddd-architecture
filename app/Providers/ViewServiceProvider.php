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
        View::addNamespace('Layouts', base_path('app/Domains/Admin/Master/Layouts'));
        View::addNamespace('Auth', base_path('app/Domains/Admin/Auth/Views'));

        View::addNamespace('Dashboard', base_path('app/Domains/Admin/Dashboard/Views'));
        View::addNamespace('User', base_path('app/Domains/Admin/User/Views'));
        View::addNamespace('Technology', base_path('app/Domains/Admin/Technology/Views'));
        View::addNamespace('Project', base_path('app/Domains/Admin/Project/Views'));
        View::addNamespace('Milestone', base_path('app/Domains/Admin/Milestone/Views'));
        View::addNamespace('Sprint', base_path('app/Domains/Admin/Sprint/Views'));
        View::addNamespace('Task', base_path('app/Domains/Admin/Task/Views'));
        View::addNamespace('DailyActivityLog', base_path('app/Domains/Admin/DailyActivityLog/Views'));
        View::addNamespace('Setting', base_path('app/Domains/Admin/Setting/Views'));
    }
}
