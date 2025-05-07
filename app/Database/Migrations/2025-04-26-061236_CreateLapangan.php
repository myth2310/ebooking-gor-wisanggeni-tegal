<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLapangan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'auto_increment' => true],
            'nama_lapangan' => ['type' => 'VARCHAR', 'constraint' => 100],
            'image'         => ['type' => 'VARCHAR', 'constraint' =>200],
            'jenis'         => ['type' => 'VARCHAR', 'constraint' => 50],
            'harga_per_jam' => ['type' => 'INT'],
            'deskripsi'     => ['type' => 'TEXT', 'null' => true],
            'status'        => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('lapangan');
    }

    public function down()
    {
        $this->forge->dropTable('lapangan');
    }
}
