<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        $data = [
            'totalUsers'      => 120, 
            'totalBookings'   => 80,
            'totalFields'     => 5,
            'pendingBookings' => 12,
            'bulan' => ["Januari", "Februari", "Maret", "April", "Mei", "Juni"], 
            'jumlahSewa' => [5, 8, 10, 7, 15, 12]
        ];

        return view('admin/dashboard-page', $data);
    }
}
