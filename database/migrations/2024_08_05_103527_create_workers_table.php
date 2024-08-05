<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('national_id');
            $table->string('job')->nullable();
            $table->string('job_place')->nullable();
            $table->foreignId('school_id')->nullable()->references('id')->on('schools');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('company')->nullable();
            $table->string('status')->nullable();
            $table->string('salary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workers');
    }
}
