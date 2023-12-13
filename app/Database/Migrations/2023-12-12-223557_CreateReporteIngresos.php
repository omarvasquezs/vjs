<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReporteIngresos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'cod_comprobante' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
                'default' => NULL,
            ],
            'cliente_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
                'default' => NULL,
            ],
            'metodo_pago_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
                'default' => NULL,
            ],
            'fecha' => [
                'type' => 'DATETIME',
                'null' => TRUE,
                'default' => NULL,
            ],
            'monto_abonado' => [
                'type' => 'FLOAT',
                'null' => TRUE,
                'default' => NULL,
            ],
            'costo_total' => [
                'type' => 'FLOAT',
                'null' => TRUE,
                'default' => NULL,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('reporte_ingresos');
        // Get database connection
        $db = \Config\Database::connect();

        // Update fecha_actualizacion field to current timestamp
        $db->query("
            ALTER TABLE reporte_ingresos 
            MODIFY fecha DATETIME DEFAULT CURRENT_TIMESTAMP
        ");
    }

    public function down()
    {
        $this->forge->dropTable('reporte_ingresos');
    }
}
