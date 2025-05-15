<?php

use App\Domains\Admin\Project\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('projects/attachments/{id}', [ProjectController::class, 'projectAttachmentZip'])->name('projects.projectAttachmentZip');
Route::resource('projects', ProjectController::class);