<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendedPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sended_phones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_code');
            $table->unsignedBigInteger('percent_id');
            $table->string('phone');
            $table->tinyInteger('status')->default(0);
            $table->string('date')->default(date('Y-m-d H:i'));
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
        Schema::dropIfExists('sended_phones');
    }
}
