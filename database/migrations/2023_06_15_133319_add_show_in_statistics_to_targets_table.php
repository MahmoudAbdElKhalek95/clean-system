<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowInStatisticsToTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('targets', function (Blueprint $table) {
            $table->foreignId('archive_id')->nullable()->references('id')->on('archives');
            $table->tinyInteger('show_in_statistics')->default(1);
        });
        Schema::table('initiatives', function (Blueprint $table) {
            $table->foreignId('archive_id')->nullable()->references('id')->on('archives');
            $table->tinyInteger('show_in_statistics')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('targets', function (Blueprint $table) {
            $table->dropForeign('archive_id');
            $table->dropColumn('show_in_statistics');
        });
        Schema::table('initiatives', function (Blueprint $table) {
            $table->dropForeign('archive_id');
            $table->dropColumn('show_in_statistics');
        });
        Schema::enableForeignKeyConstraints();
    }
}
