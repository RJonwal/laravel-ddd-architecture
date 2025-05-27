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
        Schema::create('daily_activity_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid();

            $table->foreignId('project_id')->nullable()->constrained('milestones');
            $table->foreignId('milestone_id')->nullable()->constrained('milestones');
            $table->date('report_date')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_activity_logs');
    }
};
