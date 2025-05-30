<?php

use App\Domains\Admin\Setting\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('get-site-data', [SettingController::class, 'getSettingData'])->name('get.site.setting');
Route::post('update-site-setting', [SettingController::class, 'UpdateSiteSetting'])->name('admin.update.setting');