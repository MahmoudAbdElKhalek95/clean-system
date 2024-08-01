<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrdersToSendingTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sending_templates', function (Blueprint $table) { 
        
            $table->tinyInteger('project_name_order')->nullable() ;
            $table->tinyInteger('project_link_order')->nullable() ;
            $table->tinyInteger('project_percent_order')->nullable() ;

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
