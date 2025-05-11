<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\LapanganModel;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;

class BookingController extends BaseController
{
    protected $bookingModel;
    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

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

        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');

        $builder = $bookingModel->select('booking.*, users.nama AS nama_user, lapangan.nama_lapangan')
            ->join('users', 'users.id = booking.id_user')
            ->join('lapangan', 'lapangan.id = booking.id_lapangan');

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
        $waktuKode = date('His');
        $jumlahBookingHariIni = $bookingModel
            ->where('tanggal_booking', $tanggalBooking)
            ->countAllResults();
        $urutan = str_pad($jumlahBookingHariIni + 1, 3, '0', STR_PAD_LEFT);
        $kodeBooking = 'GWT' . $tanggalKode . $waktuKode . $urutan;


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

    public function download_tiket($kode)
    {
        $bookingModel = new BookingModel();

        $data = $bookingModel
            ->select('booking.*, lapangan.nama_lapangan, lapangan.jenis')
            ->join('lapangan', 'lapangan.id = booking.id_lapangan')
            ->first();

        $html = view('user/tiket-page', ['booking' => $data]);

        $pdf = new \Dompdf\Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="TiketBooking-' . $kode . '.pdf"')
            ->setBody($pdf->output());
    }

    public function konfirmasi_kedatangan($id)
    {
        $booking = $this->bookingModel->find($id);
        $kodeBooking = $booking['kode_booking'];

        if ($booking) {
            $data = [
                'status_booking' => 'selesai'
            ];

            $this->bookingModel->update($id, $data);

            session()->setFlashdata([
                'swal_icon'  => 'success',
                'swal_title' => 'Berhasil!',
                'swal_text'  => 'Status booking dengan kode ' . $kodeBooking . ' telah berhasil diubah menjadi selesai.',
            ]);

            return redirect()->to('/admin/booking');
        } else {
            session()->setFlashdata('error', 'Booking tidak ditemukan!');
            return redirect()->to('/admin/booking');
        }
    }


    public function konfirmasi_lunas($id)
    {

        $booking = $this->bookingModel->find($id);
        $kodeBooking = $booking['kode_booking'];
        $data = [
            'status_bayar' => 'selesai'
        ];

        $this->bookingModel->update($id, $data);
        session()->setFlashdata([
            'swal_icon'  => 'success',
            'swal_title' => 'Berhasil!',
            'swal_text'  => 'Pelunasan berhasil terkonfirmasi untuk booking dengan kode ' . $kodeBooking,
        ]);

        return redirect()->to('/admin/booking');
    }

    public function download_excel()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate   = $this->request->getGet('end_date');

        $builder = $this->bookingModel->builder();
        $builder->select('booking.*, lapangan.nama_lapangan');
        $builder->join('lapangan', 'lapangan.id = booking.id_lapangan', 'inner');

        if ($startDate && $endDate) {
            $builder->where('DATE(booking.tanggal_booking) >=', $startDate);
            $builder->where('DATE(booking.tanggal_booking) <=', $endDate);
        }

        $bookings = $builder->get()->getResultArray();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Booking');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Tanggal Booking');
        $sheet->setCellValue('E1', 'Jenis Pembayaran');
        $sheet->setCellValue('F1', 'Status Bayar');
        $sheet->setCellValue('G1', 'Status Booking');

        $row = 2;
        $no = 1;
        foreach ($bookings as $booking) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $booking['kode_booking']);
            $sheet->setCellValue('C' . $row, $booking['nama_lapangan']);
            $sheet->setCellValue('D' . $row, $booking['tanggal_booking']);
            $sheet->setCellValue('E' . $row, ucfirst($booking['jenis_pembayaran']));
            $sheet->setCellValue('F' . $row, ucfirst($booking['status_bayar']));
            $sheet->setCellValue('G' . $row, ucfirst($booking['status_booking']));
            $row++;
        }

        $filename = 'data_booking_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function cekJamTerbooking()
{
    $tanggal = $this->request->getPost('tanggal');
    $lapanganId = $this->request->getPost('lapangan');

 
    $bookings = $this->bookingModel
        ->where('tanggal_booking', $tanggal)
        ->where('id_lapangan', $lapanganId)
        ->findAll();

    $jamTerbooking = [];

    foreach ($bookings as $booking) {
        $jamMulai = (int) explode('.', $booking['jam_mulai'])[0];
        $durasi = (int) $booking['durasi'];
        for ($i = 0; $i < $durasi; $i++) {
            $jamTerbooking[] = $jamMulai + $i;
        }
    }

    return $this->response->setJSON($jamTerbooking);
}


}
