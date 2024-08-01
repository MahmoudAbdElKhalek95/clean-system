<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('targets', function (Blueprint $table) {
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('date_type')->default(1);
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('targets', function (Blueprint $table) {
            $table->dropColumn('date_type');
            $table->dropColumn('type');
            $table->dropColumn('date_from');
            $table->dropColumn('date_to');
        });
    }
}
