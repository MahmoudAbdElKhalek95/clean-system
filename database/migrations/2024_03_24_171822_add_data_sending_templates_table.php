<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataSendingTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sending_templates', function (Blueprint $table) {
            $table->string('current_project_percent')->nullable() ;
            $table->string('remain_project_percent')->nullable() ;
            $table->string('button')->nullable() ;   // yes-no 
            $table->string('param1')->nullable() ;   
            $table->string('param2')->nullable() ;    
            $table->string('param3')->nullable() ;    



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sending_templates', function (Blueprint $table) {
            //
        });
    }
}
