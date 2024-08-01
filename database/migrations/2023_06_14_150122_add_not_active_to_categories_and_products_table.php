<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotActiveToCategoriesAndProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->tinyInteger('not_active')->default(1);
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->tinyInteger('not_active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('not_active');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('not_active');
        });
    }
}
