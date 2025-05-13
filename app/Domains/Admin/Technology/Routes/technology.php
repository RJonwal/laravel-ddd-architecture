<?php

use App\Domains\Admin\Technology\Controllers\TechnologyController;
use Illuminate\Support\Facades\Route;

Route::resource('technologies', TechnologyController::class);