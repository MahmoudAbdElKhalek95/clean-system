<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
           // $table->string('sending_channel')->nullable();
            $table->string('code')->nullable();
            $table->string('amount')->nullable();

           // $table->foreignId('category_id')->references('id')->on('categories');
           
           /*  $table->foreignId('project_id')->references('id')->on('projects');
               $table->foreignId('marketing_project_id')->references('id')->on('projects');
             */
            $table->string('category_id')->nullable();
            $table->string('project_id')->nullable();

            $table->string('marketing_project_id')->nullable();

            $table->string('sending_way')->nullable();
            $table->longText('whatsapp_template')->nullable() ;


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
        Schema::dropIfExists('compains');
    }
}
