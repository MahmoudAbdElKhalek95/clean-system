<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPercentToWhatsappSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('whatsapp_settings', function (Blueprint $table) {
            $table->integer('percent2')->nullable();
            $table->longText('message2')->nullable();
            $table->tinyInteger('status2')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('whatsapp_settings', function (Blueprint $table) {
            $table->dropColumn('percent2');
            $table->dropColumn('message2');
            $table->dropColumn('status2');
        });
    }
}
