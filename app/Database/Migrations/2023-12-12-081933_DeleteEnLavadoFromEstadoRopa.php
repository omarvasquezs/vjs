<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DeleteEnLavadoFromEstadoRopa extends Migration
{
    public function up()
    {
        $this->db->table('estado_ropa')
            ->where('nom_estado_ropa', 'EN LAVADO')
            ->delete();
    }

    public function down()
    {
        $data = [
            'id' => 2,
            'nom_estado_ropa' => 'EN LAVADO',
        ];

        $this->db->table('estado_ropa')->insert($data);
    }
}
