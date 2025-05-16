<?php

use App\Domains\Admin\Milestone\Controllers\MilestoneController;
use Illuminate\Support\Facades\Route;

Route::resource('milestones', MilestoneController::class);