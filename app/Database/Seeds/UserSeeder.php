<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $adminData = [
            'image_profil' => 'default_profile.jpg',
            'nama'         => 'Administrator',
            'email'        => 'admingor@gmail.com',
            'no_hp'        => '081234567890',
            'alamat'       => 'Jl. Admin No.1, Jakarta',
            'password'     => password_hash('password123', PASSWORD_DEFAULT),
            'role'         => 'admin', 
            'created_at'   => date('Y-m-d H:i:s'),
        ];

        $this->db->table('users')->insert($adminData);

        $userData = [
            'image_profil' => 'default_profile.jpg', 
            'nama'         => 'User Test',
            'email'        => 'usertest@gmail.com',
            'no_hp'        => '081234567891',
            'alamat'       => 'Jl. User No.2, Jakarta',
            'password'     => password_hash('password456', PASSWORD_DEFAULT),
            'role'         => 'user', 
            'created_at'   => date('Y-m-d H:i:s'),
        ];
        $this->db->table('users')->insert($userData);
    
    }
}
