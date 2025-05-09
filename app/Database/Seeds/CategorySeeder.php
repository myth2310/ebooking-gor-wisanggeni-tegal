<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_kategori' => 'Sepak Bola',
                'image' => 'https://reservation.gbk.id/assets/frontend/img/venuecategory/venuecategory6.jpg',
            ],
            [
                'nama_kategori' => 'Bola Basket',
                'image' => 'https://reservation.gbk.id/assets/frontend/img/venuecategory/venuecategory7.jpg',
            ],
            [
                'nama_kategori' => 'Tenis',
                'image' => 'https://reservation.gbk.id/assets/frontend/img/venuecategory/venuecategory8.jpg',
            ],
            [
                'nama_kategori' => 'Bulu Tangkis',
                'image' => 'https://reservation.gbk.id/assets/frontend/img/venuecategory/venuecategory10.jpg',
            ],
            [
                'nama_kategori' => 'Bola Voli',
                'image' => 'https://reservation.gbk.id/assets/frontend/img/venuecategory/venuecategory11.jpg',
            ],
            [
                'nama_kategori' => 'Booxing',
                'image' => 'https://media.newyorker.com/photos/64c2c66669af7f86491421f7/master/pass/Sanneh-Boxing-Virtuosos.jpg',
            ],
        ];

        $this->db->table('category')->insertBatch($data);
    }
}
