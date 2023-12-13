<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCostoTotal extends Migration
{
    public function up()
    {
        // Add new field to comprobantes table
        $this->forge->addColumn('comprobantes', [
            'costo_total' => [
                'type' => 'FLOAT',
                'null' => TRUE,
            ],
        ]);

        // Get database connection
        $db = \Config\Database::connect();

        // Update costo_total field
        $db->query("
            UPDATE comprobantes 
            SET costo_total = (
                SELECT SUM(peso_kg * costo_kilo) 
                FROM comprobantes_detalles 
                WHERE comprobantes.id = comprobantes_detalles.comprobante_id
            )
        ");
    }
    public function down()
    {
        // Remove costo_total field from comprobantes table
        $this->forge->dropColumn('comprobantes', 'costo_total');
    }
}
