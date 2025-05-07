<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//  USER PAGE
$routes->get('/', 'HomeController::index');
$routes->get('jadwal', 'HomeController::jadwal');
$routes->get('booking', 'HomeController::booking');
$routes->get('lapangan/detail/(:num)', 'HomeController::detail/$1');
$routes->get('user/profil', 'HomeController::profil');
$routes->post('booking/store', 'BookingController::store');
$routes->post('booking/filter', 'HomeController::filterJadwal');
$routes->post('check-jam', 'BookingController::checkJamTerbooking');


# AUTH PAGE
$routes->get('/register', 'AuthController::register');
$routes->post('register/process', 'AuthController::processRegister');
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::getLogin');
$routes->post('/logout', 'AuthController::logout');

$routes->get('/booking/bayar/(:segment)', 'MidtransController::bayar/$1');
$routes->post('/pembayaran/get_snap_token', 'MidtransController::get_snap_token');
$routes->post('midtrans/callback', 'MidtransController::callback');



// ADMIN PAGE
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('users', 'UserController::index');
    $routes->get('users/create', 'UserController::create');

    $routes->get('lapangan', 'LapanganController::index');
    $routes->get('lapangan/create', 'LapanganController::create');
    $routes->post('lapangan/store', 'LapanganController::store');
    $routes->get('lapangan/edit/(:num)', 'LapanganController::edit/$1');
    $routes->post('lapangan/update/(:num)', 'LapanganController::update/$1');
    $routes->get('lapangan/delete/(:num)', 'LapanganController::delete/$1');


    $routes->get('booking', 'BookingController::index');
    $routes->get('booking/create', 'BookingController::create');
    $routes->get('booking/filter', 'BookingController::filter');



    $routes->get('aktivitas', 'AktivitasController::index');
});
