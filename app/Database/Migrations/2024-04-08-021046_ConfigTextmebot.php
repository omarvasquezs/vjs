<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ConfigTextmebot extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'api_key' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('config_textmebot');
    }

    public function down()
    {
        $this->forge->dropTable('config_textmebot');
    }
}