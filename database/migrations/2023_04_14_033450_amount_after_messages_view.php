<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AmountAfterMessagesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         DB::statement("
      CREATE VIEW amount_after_messages_view AS
      (
         SELECT sum(links.total) AS total_done,links.project_number
         from links
         JOIN projects ON projects.code=links.project_number
         JOIN project_messages  ON projects.id=project_messages.project_id
         WHERE projects.category_id in(14,12,21,18,19)
        AND links.created_at > project_messages.created_at
          GROUP BY links.project_number HAVING(total_done>0)
      )
    ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
                DB::statement("DROP VIEW amount_after_messages_view");

    }
}
