<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('project_dep_name');
            $table->decimal('amount')->nullable();
            $table->decimal('price')->nullable();
            $table->date('date')->nullable();
            $table->unsignedBigInteger('project_number');
            $table->string('code');
            $table->foreignId('section_id')->nullable()->references('id')->on('sections')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('links');
    }
};
