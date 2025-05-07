<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function index()
    {
        return view('admin/users/users-page');
    }
    public function create()
    {
        return view('admin/users/create');
    }
}
