<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Seeds\CategorySeeder;
use App\Models\BookingModel;
use App\Models\CategoryModel;
use App\Models\LapanganModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use Midtrans\Snap;
use Midtrans\Config;

class HomeController extends BaseController
{
    public function index()
    {
        helper('text');
        $lapanganModel = new LapanganModel();
        $category = new CategoryModel();



        $lapangans = $lapanganModel->findAll();
        $categorys = $category->select('category.*, COUNT(lapangan.id) as total_lapangan')
            ->join('lapangan', 'lapangan.jenis = category.id', 'left')
            ->groupBy('category.id')
            ->findAll();

        return view('user/landing-page', [
            'lapangans' => $lapangans,
            'categorys' => $categorys,
        ]);
    }

    public function show($id_kategori)
    {
        helper('text');
        $db = Database::connect();

        $venues = $db->table('lapangan')
            ->select('lapangan.*, category.nama_kategori')
            ->join('category', 'category.id = lapangan.jenis')
            ->where('lapangan.jenis', $id_kategori)
            ->get()
            ->getResultArray();

        $kategori = $db->table('category')
            ->where('id', $id_kategori)
            ->get()
            ->getRowArray();



        return view('user/detail-kategori-page', [
            'venues'   => $venues,
            'kategori' => $kategori
        ]);
    }


    public function booking()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $lapanganModel = new LapanganModel();
        $lapangans = $lapanganModel->findAll();

        return view('user/booking-page', ['lapangans' => $lapangans]);
    }

    public function detail($id)
    {
        $lapanganModel = new LapanganModel();
        $bookingModel = new BookingModel();

        $today = date('Y-m-d');
        $lapangan = $lapanganModel->find($id);

        $jadwal = $bookingModel
            ->select('booking.*, lapangan.nama_lapangan')
            ->join('lapangan', 'lapangan.id = booking.id_lapangan')
            ->where('booking.tanggal_booking', $today)
            ->where('booking.id_lapangan', $id)
            ->findAll();

        return view('user/detail-lapangan-page', [
            'lapangan' => $lapangan,
            'jadwal' => $jadwal,
            'tanggal' => $today,
        ]);
    }

    public function jadwal()
    {
        $today = date('Y-m-d');
        $booking = new BookingModel();
        $lapanganModel = new LapanganModel();

        $data['jadwal'] = $booking
            ->select('booking.*, lapangan.nama_lapangan')
            ->join('lapangan', 'lapangan.id = booking.id_lapangan')
            ->where('tanggal_booking', $today)
            ->findAll();

        $data['lapangan'] = $lapanganModel->findAll();
        $data['tanggal'] = $today;
        $data['lapangan_selected'] = '';

        return view('user/jadwal-page', $data);
    }

    public function filterJadwal()
    {
        $booking = new BookingModel();
        $lapanganModel = new LapanganModel();

        $tanggal = $this->request->getPost('tanggal');
        $lapangan = $this->request->getPost('lapangan');

        $query = $booking
            ->select('booking.*, lapangan.nama_lapangan')
            ->join('lapangan', 'lapangan.id = booking.id_lapangan')
            ->where('tanggal_booking', $tanggal);

        if ($lapangan) {
            $query->where('booking.id_lapangan', $lapangan);
        }

        $data['jadwal'] = $query->findAll();

        $data['lapangan'] = $lapanganModel->findAll();
        $data['tanggal'] = $tanggal;
        $data['lapangan_selected'] = $lapangan;

        return view('user/jadwal-page', $data);
    }


    public function profil()
    {
        $bookingModel = new BookingModel();
        $userId = session('id');

        $page = $this->request->getGet('page') ?? 1;
        $perPage = 2;
        $offset = ($page - 1) * $perPage;

        $data['bookings'] = $bookingModel
            ->select('booking.*, lapangan.nama_lapangan')
            ->join('lapangan', 'lapangan.id = booking.id_lapangan')
            ->where('booking.id_user', $userId)
            ->orderBy('booking.id', 'DESC')
            ->findAll($perPage, $offset);

        $total = $bookingModel
            ->where('booking.id_user', $userId)
            ->countAllResults();

        $data['currentPage'] = $page;
        $data['perPage'] = $perPage;
        $data['total'] = $total;
        $data['totalPages'] = ceil($total / $perPage);

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $data['user'] = $user;

        return view('user/profil-page', $data);
    }

    public function updateProfil()
    {
        $userId = session()->get('id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'Data user tidak ditemukan.');
        }

        $nama    = $this->request->getPost('nama');
        $email   = $this->request->getPost('email');
        $no_hp   = $this->request->getPost('no_hp');
        $alamat  = $this->request->getPost('alamat');

        $data = [
            'nama'    => $nama,
            'email'   => $email,
            'no_hp'   => $no_hp,
            'alamat'  => $alamat,
        ];

        $image = $this->request->getFile('image');

        if ($image && $image->isValid() && !$image->hasMoved()) {
            if (!empty($user['image_profil']) && file_exists('uploads/foto_profil/' . $user['image_profil'])) {
                unlink('uploads/foto_profil/' . $user['image_profil']);
            }

            $imageName = $image->getRandomName();
            $image->move('uploads/foto_profil', $imageName);

            $data['image_profil'] = $imageName;
        }

        $userModel->update($userId, $data);

        session()->set([
            'nama'  => $nama,
            'email' => $email,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
