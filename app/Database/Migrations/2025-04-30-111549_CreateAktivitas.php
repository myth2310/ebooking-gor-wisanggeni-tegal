<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAktivitas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'auto_increment' => true],
            'aktivitas'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'device'    => ['type' => 'VARCHAR', 'constraint' => 100,],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('aktivitas');
    }

    public function down()
    {
        $this->forge->dropTable('aktivitas');
    }
}
