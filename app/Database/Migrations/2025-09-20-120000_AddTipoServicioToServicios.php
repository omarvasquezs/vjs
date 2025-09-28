<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTipoServicioToServicios extends Migration
{
    public function up()
    {
        // Add column tipo_servicio ENUM('k','s','p') NOT NULL after nom_servicio
        $this->db->query("ALTER TABLE `servicios` ADD COLUMN `tipo_servicio` ENUM('k','s','p') NOT NULL AFTER `nom_servicio`;");
    }

    public function down()
    {
        // Remove the column when rolling back
        $this->db->query("ALTER TABLE `servicios` DROP COLUMN `tipo_servicio`;");
    }
}
