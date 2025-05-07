<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AktivitasController extends BaseController
{

    public function index()
    {
        $logs = [
            [
                'user' => 'Admin',
                'aktivitas' => 'Login',
                'device' => 'Windows 10',
                'ip_address' => '192.168.1.10',
                'created_at' => '2025-04-27 08:10:00'
            ],
            [
                'user' => 'User1',
                'aktivitas' => 'Membuat Booking',
                'device' => 'Android',
                'ip_address' => '192.168.1.11',
                'created_at' => '2025-04-27 08:30:00'
            ],
            [
                'user' => 'User2',
                'aktivitas' => 'Update Profil',
                'device' => 'iPhone',
                'ip_address' => '192.168.1.12',
                'created_at' => '2025-04-27 09:00:00'
            ]
        ];

        return view('admin/aktivitas-page', [
            'logs' => $logs
        ]);
    }
}
