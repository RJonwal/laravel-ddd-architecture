<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});


/* Route::middleware(['PreventBackHistory', 'guest'])->group(function () {
    require base_path('app/Domains/Admin/Auth/Routes/auth.php');
}); */

// Auth Routes
require base_path('app/Domains/Admin/Auth/Routes/auth.php');

Route::middleware(['auth', 'PreventBackHistory'])
->group(function () {
    // Add more route files as needed
    require base_path('app/Domains/Admin/Dashboard/Routes/dashboard.php');
    require base_path('app/Domains/Admin/User/Routes/user.php');
    require base_path('app/Domains/Admin/Technology/Routes/technology.php');
    require base_path('app/Domains/Admin/Project/Routes/project.php');
    require base_path('app/Domains/Admin/Milestone/Routes/milestone.php');
    require base_path('app/Domains/Admin/Sprint/Routes/sprint.php');
    require base_path('app/Domains/Admin/Task/Routes/task.php');
    require base_path('app/Domains/Admin/DailyActivityLog/Routes/daily_activity_log.php');
    require base_path('app/Domains/Admin/Setting/Routes/setting.php');
});