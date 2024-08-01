<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewReportOfRepeatDonners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        DB::statement("
            CREATE VIEW view_project_doners AS
            (
               SELECT COUNT(*) as number_of_operations,phone,SUM(total) as total,project_number FROM links  GROUP BY phone,project_number 
            )");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_project_doners");

    }
}

