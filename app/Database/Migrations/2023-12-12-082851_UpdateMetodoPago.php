<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateMetodoPago extends Migration
{
    public function up()
    {
        $this->db->table('metodo_pago')
            ->where('id', 3)
            ->update(['habilitado' => 0]);
    }

    public function down()
    {
        $this->db->table('metodo_pago')
            ->where('id', 3)
            ->update(['habilitado' => 1]);
    }
}
