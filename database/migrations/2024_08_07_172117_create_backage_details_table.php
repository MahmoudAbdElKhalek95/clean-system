<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backage_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('backage_id')->nullable()->references('id')->on('backages');
            $table->foreignId('school_id')->nullable()->references('id')->on('schools');
            $table->string('month');
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
        Schema::dropIfExists('backage_details');
    }
}
