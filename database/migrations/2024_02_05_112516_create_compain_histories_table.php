<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompainHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compain_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compain_id')->references('id')->on('compains');
            $table->foreignId('marketing_project_id')->references('id')->on('projects');
            $table->string('amount_before_compain_start')->nullable();
            $table->string('project_id')->nullable();
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
        Schema::dropIfExists('compain_histories');
    }
}
