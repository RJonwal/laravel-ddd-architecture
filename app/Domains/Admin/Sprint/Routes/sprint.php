<?php

use App\Domains\Admin\Sprint\Controllers\SprintController;
use Illuminate\Support\Facades\Route;

Route::post('/sprints/reorder', [SprintController::class, 'reorder'])->name('sprints.reorder');
Route::resource('sprints', SprintController::class);