<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDescuentoToComprobantes extends Migration
{
    public function up()
    {
        // Add column descuento DECIMAL(10,2) NULL after cod_comprobante
        $this->db->query("ALTER TABLE `comprobantes` ADD COLUMN `descuento` DECIMAL(10,2) NULL AFTER `cod_comprobante`;");
    }

    public function down()
    {
        // Remove the column when rolling back
        $this->db->query("ALTER TABLE `comprobantes` DROP COLUMN `descuento`;");
    }
}
