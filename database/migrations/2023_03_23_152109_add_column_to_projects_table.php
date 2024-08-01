<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('quantityInStock')->nullable()->default(0);
            $table->decimal('price')->nullable()->default(0);
            $table->decimal('totalSalesTarget')->nullable()->default(0);
            $table->decimal('totalSalesDone')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('quantityInStock');
            $table->dropColumn('price');
            $table->dropColumn('totalSalesTarget');
            $table->dropColumn('totalSalesDone');
        });
    }
}
