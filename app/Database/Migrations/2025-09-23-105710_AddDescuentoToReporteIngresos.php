<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDescuentoToReporteIngresos extends Migration
{
    public function up()
    {
        // Add column descuento DECIMAL(10,2) NULL after monto_abonado
        $this->db->query("ALTER TABLE `reporte_ingresos` ADD COLUMN `descuento` DECIMAL(10,2) NULL AFTER `monto_abonado`;");
    }

    public function down()
    {
        // Remove the column when rolling back
        $this->db->query("ALTER TABLE `reporte_ingresos` DROP COLUMN `descuento`;");
    }
}
