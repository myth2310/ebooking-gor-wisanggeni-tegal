<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\LapanganModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        $bookingModel  = new BookingModel();
        $lapanganModel = new LapanganModel();
        $userModel     = new UserModel(); 
        $db            = \Config\Database::connect();
        
        $year = date('Y'); 
    
        $totalUsers = $userModel->countAll();
    
        $totalBookings = $bookingModel->countAll();
    
        $totalFields = $lapanganModel->countAll();
    
        $pendingBookings = $bookingModel
        ->where('status_bayar', 'menunggu')
        ->where('status_booking', 'menunggu')
        ->countAllResults();
    
        // Omset Harian
        $today = date('Y-m-d');
        $omsetHarian = $bookingModel->selectSum('total_bayar')
            ->where('DATE(tanggal_booking)', $today)
            ->where('status_bayar', 'selesai')
            ->get()->getRow()->total_bayar ?? 0;
    
    
        // Omset Bulanan
        $month = date('m');
        $omsetBulanan = $bookingModel->selectSum('total_bayar')
            ->where('MONTH(tanggal_booking)', $month)
            ->where('YEAR(tanggal_booking)', $year)
            ->where('status_bayar', 'selesai')
            ->get()->getRow()->total_bayar ?? 0;
  
        // Omset Tahunan
        $omsetTahunan = $bookingModel->selectSum('total_bayar')
            ->where('YEAR(tanggal_booking)', $year)
            ->where('status_bayar', 'selesai')
            ->get()->getRow()->total_bayar ?? 0;
    
        // Grafik Bulanan
        $namaBulan = [1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                      "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    
        $bulanQuery = $bookingModel->select('MONTH(tanggal_booking) as bulan')
            ->where('YEAR(tanggal_booking)', $year)
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->get()->getResult();
    
        $bulan = [];
        $jumlahSewa = [];
    
        $bulan = [];
        $jumlahSewa = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $bulan[] = $namaBulan[$i];
        
            $jumlah = $bookingModel
                ->where('MONTH(tanggal_booking)', $i)
                ->where('YEAR(tanggal_booking)', $year)
                ->countAllResults();
        
            $jumlahSewa[] = $jumlah;
        }

        $tahunQuery = $bookingModel->select('YEAR(tanggal_booking) as tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'ASC')
            ->get()->getResult();
    
        $tahun = [];
        $sewaTahunan = [];
    
        foreach ($tahunQuery as $row) {
            $tahun[] = $row->tahun;
            $jumlah = $bookingModel
                ->where('YEAR(tanggal_booking)', $row->tahun)
                ->countAllResults();
            $sewaTahunan[] = $jumlah;
        }

        $data = [
            'totalUsers'      => $totalUsers,
            'totalBookings'   => $totalBookings,
            'totalFields'     => $totalFields,
            'pendingBookings' => $pendingBookings,
            'omsetHarian'     => $omsetHarian,
            'omsetBulanan'    => $omsetBulanan,
            'omsetTahunan'    => $omsetTahunan,
            'bulan'           => $bulan,
            'jumlahSewa'      => $jumlahSewa,
            'tahun'           => $tahun,
            'sewaTahunan'     => $sewaTahunan
        ];
    
        return view('admin/dashboard-page', $data);
    }
    
    
}
