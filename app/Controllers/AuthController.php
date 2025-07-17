<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AktivitasModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function index()
    {
        return view('auth/login-page');
    }

    public function getLogin()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {

                session()->set([
                    'id'         => $user['id'],
                    'nama'       => $user['nama'],
                    'email'      => $user['email'],
                    'role'       => $user['role'],
                    'isLoggedIn' => true,
                ]);

                $aktivitasModel = new AktivitasModel();

                $agent = $this->request->getUserAgent();
                if ($agent->isBrowser()) {
                    $device = $agent->getBrowser() . ' ' . $agent->getVersion();
                } elseif ($agent->isRobot()) {
                    $device = $agent->getRobot();
                } elseif ($agent->isMobile()) {
                    $device = $agent->getMobile();
                } else {
                    $device = 'Unknown Device';
                }
                
                $ip = $this->request->getServer('HTTP_X_FORWARDED_FOR') ?? $this->request->getIPAddress();
                
                $aktivitasModel->insert([
                    'aktivitas'  => $user['nama'] . ' berhasil Masuk',
                    'device'     => $device,
                    'ip_address' => $ip,
                ]);
                

                if ($user['role'] === 'admin') {
                    return redirect()->to('/admin/dashboard');
                } else if ($user['role'] === 'user') {
                    return redirect()->to('/user/profil');
                } else {
                    return redirect()->to('/')->with('error', 'Role tidak dikenali.');
                }
            } else {
                return redirect()->back()->with('error', 'Password salah.');
            }
        } else {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah logout.');
    }

    public function register()
    {
        return view('auth/register-page');
    }

    public function processRegister()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama'              => 'required|min_length[3]',
            'email'             => 'required|valid_email|is_unique[users.email]',
            'no_hp'             => 'required|min_length[10]',
            'alamat'            => 'required',
            'password'          => 'required|min_length[6]',
            'confirm_password'  => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
            $firstError = reset($errors);

            session()->setFlashdata([
                'swal_icon'  => 'error',
                'swal_title' => 'Gagal!',
                'swal_text'  => $firstError,
            ]);

            return redirect()->back()->withInput();
        }

        $userModel = new UserModel();

        $userModel->save([
            'nama'         => $this->request->getPost('nama'),
            'email'        => $this->request->getPost('email'),
            'no_hp'        => $this->request->getPost('no_hp'),
            'alamat'       => $this->request->getPost('alamat'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'         => 'user',
            'created_at'   => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata([
            'swal_icon'  => 'success',
            'swal_title' => 'Berhasil!',
            'swal_text'  => 'Registrasi berhasil. Silakan login!',
        ]);

        return redirect()->to('/login');
    }
}
