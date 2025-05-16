<?php

use App\Domains\Admin\Task\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/tasks/by-milestone', [TaskController::class, 'getTaskByMilestone'])
->name('tasks.byMilestones');
Route::get('/tasks/milestones/by-project', [TaskController::class, 'getMilestonesByProject'])
    ->name('tasks.milestones.byProject');
Route::resource('tasks', TaskController::class);