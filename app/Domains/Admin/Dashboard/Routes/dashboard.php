<?php

use App\Domains\Admin\Dashboard\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');