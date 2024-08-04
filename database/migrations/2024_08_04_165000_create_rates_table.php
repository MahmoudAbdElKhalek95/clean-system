<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('super_id')->references('id')->on('users')->nullable();
            $table->foreignId('manager_id')->references('id')->on('users')->nullable();
            $table->foreignId('visit_detail_id')->references('id')->on('visit_details')->nullable();
            $table->string('rate_employee_performance')->nullable();
            $table->string('rate_excuted_time')->nullable();
            $table->string('rate_contious_visit')->nullable();
            $table->string('rate_service')->nullable();
            $table->string('rate_company')->nullable();
            $table->string('rate_service_statisfied')->nullable();
            $table->string('rate_service_statisfied_range')->nullable();

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
        Schema::dropIfExists('rates');
    }
}
