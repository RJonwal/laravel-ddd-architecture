<?php

use App\Domains\Auth\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);
Route::post('forgot-password', [LoginController::class, 'forgotPassword']);
Route::post('password/reset-password', [LoginController::class, 'resetPassword']);