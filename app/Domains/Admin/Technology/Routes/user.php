<?php

use App\Domains\Admin\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('users/change-status', [UserController::class, "changeStatus"])->name('user.status');
Route::resource('users', UserController::class);