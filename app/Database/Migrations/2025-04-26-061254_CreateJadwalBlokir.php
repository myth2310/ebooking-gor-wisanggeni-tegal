<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalBlokir extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'id_lapangan' => ['type' => 'INT'],
            'tanggal'     => ['type' => 'DATE'],
            'jam_mulai'   => ['type' => 'TIME'],
            'jam_selesai' => ['type' => 'TIME'],
            'keterangan'  => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('jadwal_blokir');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal_blokir');
    }
}
