<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFechaActualizacion extends Migration
{
    public function up()
    {
        // Add new field to comprobantes table
        $this->forge->addColumn('comprobantes', [
            'fecha_actualizacion' => [
                'type' => 'DATETIME',
                'null' => TRUE,
                'default' => NULL,
                'after' => 'fecha', // assuming it's added after fecha field
            ],
        ]);

        // Get database connection
        $db = \Config\Database::connect();

        // Update fecha_actualizacion field to current timestamp
        $db->query("
            ALTER TABLE comprobantes 
            MODIFY fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ");
    }
    public function down()
    {
        // Remove fecha_actualizacion field from comprobantes table
        $this->forge->dropColumn('comprobantes', 'fecha_actualizacion');
    }
}
