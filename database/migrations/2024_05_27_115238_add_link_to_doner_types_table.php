<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkToDonerTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doner_types', function (Blueprint $table) {
            
            $table->string('link_from')->nullable()  ;  // عدد العمليات من 
            $table->string('link_to')->nullable()  ;  // الي 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doner_types', function (Blueprint $table) {
            //
        });
    }
}
