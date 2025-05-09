<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBooking extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'auto_increment' => true],
            'kode_booking' => ['type' => 'VARCHAR', 'constraint' => 20],
            'id_user'          => ['type' => 'INT'],
            'id_lapangan'      => ['type' => 'INT'],
            'tanggal_booking'  => ['type' => 'DATE'],
            'jam_mulai'        => ['type' => 'TIME'],
            'jam_selesai'      => ['type' => 'TIME'],
            'durasi'           => ['type' => 'INT'],
            'bayar'      => ['type' => 'INT'],
            'total_bayar'      => ['type' => 'INT'],
            'jenis_pembayaran' => ['type' => 'ENUM', 'constraint' => ['dp', 'lunas']],
            'status_booking' => ['type' => 'ENUM', 'constraint' => ['menunggu', 'dibooking','selesai', 'dibatalkan'], 'default' => 'menunggu'],
            'status_bayar'     => ['type' => 'ENUM', 'constraint' => ['menunggu', 'dibayar', 'selesai'], 'default' => 'menunggu'],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('booking');
    }

    public function down()
    {
        $this->forge->dropTable('booking');
    }
}
