<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCodigoPaisToClientes extends Migration
{
    public function up()
    {
        // Add column codigo_pais VARCHAR(10) DEFAULT '+51' after dni
        $this->db->query("ALTER TABLE `clientes` ADD COLUMN `codigo_pais` VARCHAR(10) DEFAULT '+51' AFTER `dni`;");
    }

    public function down()
    {
        // Remove the column when rolling back
        $this->db->query("ALTER TABLE `clientes` DROP COLUMN `codigo_pais`;");
    }
}