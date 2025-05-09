<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\LapanganModel;
use CodeIgniter\HTTP\ResponseInterface;

class BookingController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');
    
        $builder = $db->table('booking');
        $builder->select('booking.*, users.nama as nama_user, lapangan.nama_lapangan ');
        $builder->join('users', 'users.id = booking.id_user');
        $builder->join('lapangan', 'lapangan.id = booking.id_lapangan');
        $builder->where('tanggal_booking', $today);
    
        $query = $builder->get();
        $data['bookings'] = $query->getResultArray();
    
        return view('admin/booking/booking-page', $data);
    }
    
    public function filter()
{
    $bookingModel = new BookingModel();

    $startDate = $this->request->getGet('start_date');
    $endDate = $this->request->getGet('end_date');

    $builder = $bookingModel->select('booking.*, users.nama AS nama_user, lapangan.nama_lapangan')
        ->join('users', 'users.id = booking.id_user')
        ->join('lapangan', 'lapangan.id = booking.lapangan_id');

    if (!empty($startDate) && !empty($endDate)) {
        $builder->where('tanggal_booking >=', $startDate)
                ->where('tanggal_booking <=', $endDate);
    }

    $data['bookings'] = $builder->orderBy('tanggal_booking', 'DESC')->findAll();
    $data['tanggal'] = $startDate . ' s/d ' . $endDate;

    return view('admin/booking/booking-page', $data);
}


    public function create()
    {
        return view('admin/booking/create');
    }

    public function store()
    {
        $bookingModel = new BookingModel();
        $lapanganModel = new LapanganModel();

        $tanggalBooking = $this->request->getPost('tanggal');
        $jamMulai = $this->request->getPost('jam');
        $durasi = $this->request->getPost('durasi');
        $lapanganId = $this->request->getPost('lapangan');
        $pembayaran = $this->request->getPost('pembayaran');
        $bayar = $this->request->getPost('bayar');

        $bayar = str_replace(',', '', $bayar);
        $bayar = (int)$bayar;

        $lapangan = $lapanganModel->find($lapanganId);
        $biayaPerJam = $lapangan['harga_per_jam'];

        $jamMulaiArray = explode('.', $jamMulai);
        $jamMulaiJam = intval($jamMulaiArray[0]);
        $jamMulaiMenit = isset($jamMulaiArray[1]) ? intval($jamMulaiArray[1]) : 0;

        $jamSelesai = $jamMulaiJam + intval($durasi);

        if ($jamSelesai >= 24) {
            $jamSelesai -= 24;
        }

        $jamSelesaiFormatted = str_pad($jamSelesai, 2, '0', STR_PAD_LEFT) . ':' . str_pad($jamMulaiMenit, 2, '0', STR_PAD_LEFT);

        $jamMulaiFormatted = str_pad($jamMulaiJam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($jamMulaiMenit, 2, '0', STR_PAD_LEFT);

        $totalBayar = $biayaPerJam * $durasi;

        $tanggalKode = date('Ymd', strtotime($tanggalBooking));
        $jumlahBookingHariIni = $bookingModel
            ->where('tanggal_booking', $tanggalBooking)
            ->countAllResults();
        $urutan = str_pad($jumlahBookingHariIni + 1, 3, '0', STR_PAD_LEFT);
        $kodeBooking = 'GWT' . $tanggalKode . $urutan;

        $idUser = session()->get('id');

        $bookingModel->insert([
            'id_user'           => $idUser,
            'kode_booking'      => $kodeBooking,
            'tanggal_booking'   => $tanggalBooking,
            'jam_mulai'         => $jamMulaiFormatted,
            'jam_selesai'       => $jamSelesaiFormatted,
            'durasi'            => $durasi,
            'id_lapangan'       => $lapanganId,
            'jenis_pembayaran'  => $pembayaran,
            'bayar'             => $bayar,
            'total_bayar'       => $totalBayar,
            'created_at'        => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata([
            'swal_icon'  => 'success',
            'swal_title' => 'Berhasil!',
            'swal_text'  => 'Booking berhasil disimpan dengan kode ' . $kodeBooking,
        ]);

        return redirect()->to('/user/profil');
    }
    public function checkJamTerbooking()
    {
        $lapanganId = $this->request->getPost('lapangan');
        $tanggal = $this->request->getPost('tanggal');

        $bookingModel = new BookingModel();

        $bookedJams = $bookingModel
            ->select('jam_mulai')
            ->where('id_lapangan', $lapanganId)
            ->where('tanggal_booking', $tanggal)
            ->where('status_pembayaran', 'dibayar')
            ->findAll();

        $bookedJamArray = array_map(function ($row) {
            return $row['jam_mulai'];
        }, $bookedJams);

        return $this->response->setJSON($bookedJamArray);
    }
}
