<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AktivitasModel;
use App\Models\CategoryModel;
use App\Models\LapanganModel;
use CodeIgniter\HTTP\ResponseInterface;

class LapanganController extends BaseController
{
    public function index()
    {
        $lapanganModel = new LapanganModel();
        $lapangans = $lapanganModel->select('lapangan.*, category.nama_kategori as category_name')
            ->join('category', 'category.id = lapangan.jenis', 'inner')
            ->findAll();
        return view('admin/lapangan/lapangan-page', [
            'lapangans' => $lapangans
        ]);
    }

    public function create()
    {
        $category = new CategoryModel();
        $categorys = $category->findAll();
        return view('admin/lapangan/create', [
            'categorys' => $categorys
        ]);
    }

    public function store()
    {
        $lapanganModel = new LapanganModel();

        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move('uploads/lapangan', $imageName);
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal upload gambar.');
        }

        $data = [
            'nama_lapangan' => $this->request->getPost('nama_lapangan'),
            'jenis'         => $this->request->getPost('jenis'),
            'harga_per_jam' => $this->request->getPost('harga_per_jam'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'status'        => $this->request->getPost('status'),
            'image'         => $imageName,
        ];

        if (!$lapanganModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $lapanganModel->errors());
        }

        $aktivitasModel = new AktivitasModel();
        $aktivitasModel->insert([
            'aktivitas'  => session()->get('nama') . ' menambahkan ' . $data['nama_lapangan'],
            'device'     => $this->request->getUserAgent()->getAgentString(),
            'ip_address' => $this->request->getIPAddress(),
        ]);

        session()->setFlashdata([
            'swal_icon'  => 'success',
            'swal_title' => 'Berhasil!',
            'swal_text'  => 'Data Lapangan Berhasil ditambahkan ',
        ]);

        return redirect()->to(base_url('admin/lapangan'))->with('success', 'Lapangan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $lapanganModel = new LapanganModel();
        $lapangan = $lapanganModel->find($id);

        $category = new CategoryModel();
        $categorys = $category->findAll();

        if (!$lapangan) {
            return redirect()->to('admin/lapangan')->with('error', 'Data lapangan tidak ditemukan.');
        }

        return view('admin/lapangan/edit', [
            'lapangan' => $lapangan,
            'categorys' => $categorys
        ]);
    }

    public function update($id)
    {
        $lapanganModel = new LapanganModel();
        $lapangan = $lapanganModel->find($id);

        if (!$lapangan) {
            return redirect()->to('admin/lapangan')->with('error', 'Data lapangan tidak ditemukan.');
        }

        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            if (is_file('uploads/lapangan/' . $lapangan['image'])) {
                unlink('uploads/lapangan/' . $lapangan['image']);
            }

            $imageName = $image->getRandomName();
            $image->move('uploads/lapangan', $imageName);
        } else {
            $imageName = $lapangan['image'];
        }

        $data = [
            'nama_lapangan' => $this->request->getPost('nama_lapangan'),
            'jenis'         => $this->request->getPost('jenis'),
            'harga_per_jam' => $this->request->getPost('harga_per_jam'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'status'        => $this->request->getPost('status'),
            'image'         => $imageName,
        ];

        if (!$lapanganModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $lapanganModel->errors());
        }

        $aktivitasModel = new AktivitasModel();
        $aktivitasModel->insert([
            'aktivitas'  => session()->get('nama') . ' mengubah ' . $data['nama_lapangan'],
            'device'     => $this->request->getUserAgent()->getAgentString(),
            'ip_address' => $this->request->getIPAddress(),
        ]);

        session()->setFlashdata([
            'swal_icon'  => 'success',
            'swal_title' => 'Berhasil!',
            'swal_text'  => 'Data Lapangan Berhasil diubah ',
        ]);
        return redirect()->to(base_url('admin/lapangan'))->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $lapanganModel = new LapanganModel();
        $lapangan = $lapanganModel->find($id);

        if (!$lapangan) {
            return redirect()->to('admin/lapangan')->with('error', 'Data lapangan tidak ditemukan.');
        }

        if (is_file('uploads/lapangan/' . $lapangan['image'])) {
            unlink('uploads/lapangan/' . $lapangan['image']);
        }

        $lapanganModel->delete($id);

        $aktivitasModel = new AktivitasModel();
        $aktivitasModel->insert([
            'aktivitas'  => session()->get('nama') . ' Menghapus ' . $lapangan['nama_lapangan'],
            'device'     => $this->request->getUserAgent()->getAgentString(),
            'ip_address' => $this->request->getIPAddress(),
        ]);

        session()->setFlashdata([
            'swal_icon'  => 'success',
            'swal_title' => 'Berhasil!',
            'swal_text'  => 'Data Lapangan Berhasil dihapus ',
        ]);

        return redirect()->to('admin/lapangan')->with('success', 'Lapangan berhasil dihapus.');
    }
}
