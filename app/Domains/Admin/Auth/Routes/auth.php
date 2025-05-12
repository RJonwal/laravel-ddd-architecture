<?php

use App\Domains\Admin\Auth\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'submitLogin'])->name('login.submit');
// Route::post('forgot-password', [LoginController::class, 'forgotPassword']);
// Route::post('password/reset-password', [LoginController::class, 'resetPassword']);
