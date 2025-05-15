<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AktivitasModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();

        return view('admin/users/users-page', ['users' => $users]);
    }
    public function create()
    {
        return view('admin/users/create');
    }

    public function store()
    {
        $data = $this->request->getPost();
        $userModel = new UserModel();

        $emailExists = $userModel->where('email', $data['email'])->first();
        if ($emailExists) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar.');
        }

        $phoneExists = $userModel->where('no_hp', $data['no_hp'])->first();
        if ($phoneExists) {
            return redirect()->back()->withInput()->with('error', 'Nomor telepon sudah terdaftar.');
        }

        $userModel->save([
            'nama'     => $data['nama'],
            'email'    => $data['email'],
            'no_hp'    => $data['no_hp'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => $data['role'],
            'alamat'   => $data['alamat'],
        ]);

        session()->setFlashdata([
            'swal_icon'  => 'success',
            'swal_title' => 'Berhasil!',
            'swal_text'  => 'User berhasil ditambahkan.',
        ]);
        return redirect()->to(base_url('admin/users'));
    }


    public function edit($id)
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User tidak ditemukan.');
        }

        return view('admin/users/edit', ['user' => $user]);
    }


    public function update($id)
    {
        $data = $this->request->getPost();

        $userModel = new UserModel();
        $userLama = $userModel->find($id);
        $password = $data['password']
            ? password_hash($data['password'], PASSWORD_DEFAULT)
            : $userLama['password'];

        $userModel->update($id, [
            'nama'    => $data['nama'],
            'email'   => $data['email'],
            'no_hp'   => $data['no_hp'],
            'password' => $password,
            'role'    => $data['role'],
            'alamat'  => $data['alamat'],
        ]);

        return redirect()->to(base_url('admin/users'))->with('success', 'User berhasil diupdate.');
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('admin/users')->with('error', 'User tidak ditemukan.');
        }

        $userModel->delete($id);
        $aktivitasModel = new AktivitasModel();
        $aktivitasModel->insert([
            'aktivitas'  => session()->get('nama') . ' Menghapus user ' . $user['nama'],
            'device'     => $this->request->getUserAgent()->getAgentString(),
            'ip_address' => $this->request->getIPAddress(),
        ]);
        return redirect()->to('admin/users')->with('success', 'User berhasil dihapus.');
    }
}
