<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendingTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sending_templates', function (Blueprint $table) {
            $table->id();
            $table->longText('template_name') ;
            $table->integer('var_number') ; // عدد المتغيرات 
            $table->text('project_name')->nullable() ;
            $table->text('project_link')->nullable() ;
            $table->text('project_percent')->nullable() ;
            $table->longText('photo')->nullable() ;
            $table->longText('video')->nullable() ;
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
        Schema::dropIfExists('sending_templates');
    }
}
