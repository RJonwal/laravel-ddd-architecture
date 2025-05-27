<?php

use App\Domains\Admin\DailyActivityLog\Controllers\DailyActivityLogController;
use Illuminate\Support\Facades\Route;

Route::get('/daily-activity-logs/get-milestones', [DailyActivityLogController::class, 'getMilestones'])->name('daily-activity-logs.get-milestones');
Route::get('/daily-activity-logs/get-subTasks', [DailyActivityLogController::class, 'getSubTasks'])->name('daily-activity-logs.get-subTasks');
Route::get('/daily-activity-logs/get-task-html', [DailyActivityLogController::class, 'getTaskHtml'])->name('daily-activity-logs.get-task-html');

Route::resource('daily-activity-logs', DailyActivityLogController::class, ['parameters' => ['daily-activity-logs' => 'dailyActivityLog']]);