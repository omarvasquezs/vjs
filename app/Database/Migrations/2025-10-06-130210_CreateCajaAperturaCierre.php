<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCajaAperturaCierre extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'datetime_apertura' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'monto_apertura' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'id_usuario_apertura' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'datetime_cierre' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'monto_cierre' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'id_usuario_cierre' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('caja_apertura_cierre');
    }

    public function down()
    {
        $this->forge->dropTable('caja_apertura_cierre');
    }
}
