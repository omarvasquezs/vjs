<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateEstadoComprobantes extends Migration
{
    public function up()
    {
        $this->db->table('estado_comprobantes')
            ->where('nom_estado', 'PENDIENTE DE PAGO')
            ->update(['nom_estado' => 'DEBE']);

        $this->db->table('estado_comprobantes')
            ->where('nom_estado', 'PARCIALMENTE PAGADO')
            ->update(['nom_estado' => 'ABONO']);

        $this->db->table('estado_comprobantes')
            ->where('nom_estado', 'PAGADO')
            ->update(['nom_estado' => 'CANCELADO']);
    }

    public function down()
    {
        $this->db->table('estado_comprobantes')
            ->where('nom_estado', 'DEBE')
            ->update(['nom_estado' => 'PENDIENTE DE PAGO']);

        $this->db->table('estado_comprobantes')
            ->where('nom_estado', 'ABONO')
            ->update(['nom_estado' => 'PARCIALMENTE PAGADO']);

        $this->db->table('estado_comprobantes')
            ->where('nom_estado', 'CANCELADO')
            ->update(['nom_estado' => 'PAGADO']);
    }
}