<?php

use App\Domains\Admin\DailyTask\Controllers\DailyTaskController;
use Illuminate\Support\Facades\Route;

Route::get('/daily-tasks/by-milestone', [DailyTaskController::class, 'getTaskByMilestone'])
->name('daily.tasks.byMilestones');
Route::get('/daily-tasks/milestones/by-project', [DailyTaskController::class, 'getMilestonesByProject'])
    ->name('daily.tasks.milestones.byProject');
Route::resource('daily-tasks', DailyTaskController::class);