<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//  USER PAGE
$routes->get('/', 'HomeController::index');
$routes->get('jadwal', 'HomeController::jadwal');
$routes->get('lapangan/detail/(:num)', 'HomeController::detail/$1');
$routes->get('sport/(:num)', 'HomeController::show/$1');
$routes->post('booking/filter', 'HomeController::filterJadwal');
$routes->post('check-jam', 'BookingController::checkJamTerbooking');


$routes->post('user/payment/notification', 'MidtransController::callback');

$routes->group('user', ['filter' => 'auth'], function ($routes) {
    $routes->get('booking', 'HomeController::booking');
    $routes->get('profil', 'HomeController::profil');
    $routes->post('payment/get_snap_token', 'MidtransController::get_snap_token');
    $routes->post('booking/store', 'BookingController::store');
    $routes->get('download-tiket/(:segment)', 'BookingController::download_tiket/$1');
});




# AUTH PAGE
$routes->get('/register', 'AuthController::register');
$routes->post('register/process', 'AuthController::processRegister');
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::getLogin');
$routes->post('/logout', 'AuthController::logout');


// ADMIN PAGE
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('users', 'UserController::index');
    $routes->get('users/create', 'UserController::create');
    $routes->post('users/store', 'UserController::store');
    $routes->get('users/edit/(:num)', 'UserController::edit/$1');
    $routes->post('users/update/(:num)', 'UserController::update/$1');
    $routes->get('users/delete/(:num)', 'UserController::delete/$1');

    $routes->get('lapangan', 'LapanganController::index');
    $routes->get('lapangan/create', 'LapanganController::create');
    $routes->post('lapangan/store', 'LapanganController::store');
    $routes->get('lapangan/edit/(:num)', 'LapanganController::edit/$1');
    $routes->post('lapangan/update/(:num)', 'LapanganController::update/$1');
    $routes->get('lapangan/delete/(:num)', 'LapanganController::delete/$1');


    $routes->get('booking', 'BookingController::index');
    $routes->get('booking/create', 'BookingController::create');
    $routes->post('booking/filter', 'BookingController::filter');
    $routes->get('booking/konfirmasi_kedatangan/(:num)', 'BookingController::konfirmasi_kedatangan/$1');
    $routes->get('booking/konfirmasi_lunas/(:num)', 'BookingController::konfirmasi_lunas/$1');
    $routes->get('booking/download_excel', 'BookingController::download_excel');


    $routes->get('aktivitas', 'AktivitasController::index');
});
