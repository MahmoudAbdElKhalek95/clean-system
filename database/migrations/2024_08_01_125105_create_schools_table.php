<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name') ;
            $table->string('school_number')->nullable() ;
            $table->string('region')->nullable() ;
            $table->string('city')->nullable() ;
            $table->string('state')->nullable() ;
            $table->string('spcilization')->nullable() ;
            $table->string('class_number')->nullable() ;
            $table->string('pathromm_number')->nullable() ;
            $table->longText('google_map_link')->nullable() ;
            $table->string('manager_name')->nullable() ;
            $table->string('school_phone')->nullable() ;
            $table->string('school_email')->nullable() ;
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
        Schema::dropIfExists('schools');
    }
}
