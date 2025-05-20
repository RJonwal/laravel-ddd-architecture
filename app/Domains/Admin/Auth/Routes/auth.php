<?php

use App\Domains\Admin\Auth\Controllers\ForgotPasswordController;
use App\Domains\Admin\Auth\Controllers\LoginController;
use App\Domains\Admin\Auth\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'PreventBackHistory', 'guest']], function () {
    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::post('login', [LoginController::class, 'submitLogin'])->name('login.submit');

    Route::get('forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot.password');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forgot.password.submit');

    Route::get('password/reset-password', [ResetPasswordController::class, 'index'])->name('reset.password');
    Route::post('password/reset-password', [ResetPasswordController::class, 'reset'])->name('reset-new-password');
});


Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout')->middleware(['web', 'auth', 'PreventBackHistory']);