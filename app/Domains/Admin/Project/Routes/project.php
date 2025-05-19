<?php

use App\Domains\Admin\Project\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('projects/attachments/{id}', [ProjectController::class, 'projectAttachmentZip'])->name('projects.projectAttachmentZip');
Route::get('projects/milestone/{id}',[ProjectController::class,'projectMilestoneTask'])->name('projects.milestones.tasks');
Route::resource('projects', ProjectController::class);