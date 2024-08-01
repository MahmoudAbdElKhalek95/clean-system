<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewfieldToCompainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compains', function (Blueprint $table) {
            $table->string('targets')->nullable(); // المستهدفين
             // project_donor -  donor_type - متبرعي مشاريع - اقسام متبرعين 
            $table->string('target_category_id')->nullable(); // فسم المشروع الحالي 
            $table->string('target_doner_type_id')->nullable(); // فئات المتبرعين - اقسام المتبرعين 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compains', function (Blueprint $table) {
            //
        });
    }
}
