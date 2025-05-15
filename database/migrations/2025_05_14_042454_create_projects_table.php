<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('name',191);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('project_lead')->nullable();
            $table->longText('description')->nullable();
            $table->longText('refrence_details')->nullable();
            $table->string('live_url')->nullable();
            $table->longText('credentials')->nullable();
            $table->enum('project_status', array_keys(config('constant.project_status')))->nullable();

            $table->unsignedBigInteger('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(Null)->nullable();
            $table->softDeletes();

            $table->foreign('project_lead')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
