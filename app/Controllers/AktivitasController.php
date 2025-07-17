<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AktivitasModel;
use CodeIgniter\HTTP\ResponseInterface;

class AktivitasController extends BaseController
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');

        $logModel = new AktivitasModel();

        $today = date('Y-m-d');

        $logs = $logModel
            ->where('DATE(created_at)', $today)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/aktivitas-page', [
            'logs' => $logs,
            'tanggal' => $today
        ]);
    }


    public function search()
    {
        date_default_timezone_set('Asia/Jakarta');

        $logModel = new AktivitasModel();
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');

        $logs = $logModel
            ->where('DATE(created_at)', $tanggal)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/aktivitas-page', [
            'logs' => $logs,
            'tanggal' => $tanggal
        ]);
    }
}
