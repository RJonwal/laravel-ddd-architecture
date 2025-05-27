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
        Schema::create('daily_activity_task_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid();

            $table->foreignId('daily_activity_log_id')->nullable()->constrained('daily_activity_logs');            
            $table->foreignId('task_id')->nullable()->constrained('tasks');
            $table->unsignedBigInteger('sub_task_id')->nullable();

            $table->text('description')->nullable();
            $table->decimal('work_time')->nullable()->comment('in hours');

            $table->enum('status',  array_keys(config('constant.activity_status')))->nullable();
            $table->enum('task_type',  array_keys(config('constant.task_types')))->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_activity_task_logs');
    }
};
