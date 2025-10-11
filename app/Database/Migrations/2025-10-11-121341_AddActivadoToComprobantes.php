<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddActivadoToComprobantes extends Migration
{
    public function up()
    {
        // Add boolean 'activado' column at end of table
        $this->db->query("ALTER TABLE `comprobantes` ADD COLUMN `activado` TINYINT(1) NOT NULL DEFAULT 1;");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `comprobantes` DROP COLUMN `activado`;");
    }
}
