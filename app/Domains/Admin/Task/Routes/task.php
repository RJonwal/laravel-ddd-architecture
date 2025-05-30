<?php

use App\Domains\Admin\Task\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/tasks/milestones/by-project', [TaskController::class, 'getMilestonesByProject'])
->name('tasks.milestones.byProject');
Route::get('/tasks/sprint/by-milestones', [TaskController::class, 'getSprintsByMilestone'])
->name('tasks.sprint.byMilestones');
Route::get('/tasks/by-sprint', [TaskController::class, 'getTaskBySprint'])
->name('tasks.bySprint');
Route::post('/tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');
Route::post('/inline-update',[TaskController::class, 'updateMilestoneTaskSubtask'])->name('task.update.milestone.task.subtask');
Route::post('/inline-delete', [TaskController::class, 'deleteMilestoneSprintTaskSubtask'])->name('task.delete.milestone.sprint.task.subtask');
Route::resource('tasks', TaskController::class);