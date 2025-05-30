<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreignId('milestone_id')->nullable()->constrained('milestones');
            $table->foreignId('sprint_id')->nullable()->constrained('sprints');
            $table->unsignedBigInteger('parent_task_id')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->decimal('estimated_time')->nullable()->comment('in hours');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->enum('priority', array_keys(config('constant.task_priority')));
            $table->enum('status',  array_keys(config('constant.task_status')))->default('initial');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
