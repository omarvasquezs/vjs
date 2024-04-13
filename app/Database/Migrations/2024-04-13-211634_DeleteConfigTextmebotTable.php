<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DeleteConfigTextmebotTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable('config_textmebot');
    }

    public function down()
    {
        //
    }
}
