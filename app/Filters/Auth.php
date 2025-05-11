<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $role = session()->get('role');
        $currentURI = current_url();
    
        if ($role == 'admin' && strpos($currentURI, '/admin') === false) {
            return redirect()->to('/admin/dashboard');
        } elseif ($role == 'user' && strpos($currentURI, '/user') === false) {
            return redirect()->to('/user/profil');
        }
    
    }
    

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
