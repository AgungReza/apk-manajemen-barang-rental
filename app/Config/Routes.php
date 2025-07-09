<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route (halaman awal)
$routes->get('/', 'AuthController::login'); // Mengarahkan ke halaman login jika root diakses

// Rute untuk autentikasi
$routes->get('/register', 'AuthController::register'); // Halaman register
$routes->post('/register/submit', 'AuthController::submitRegister'); // Proses register
$routes->get('/login', 'AuthController::login'); // Halaman login
$routes->post('/login/submit', 'AuthController::submitLogin'); // Proses login
$routes->get('/logout', 'AuthController::logout'); // Logout

// Rute untuk dashboard
$routes->get('/dashboard', 'FrontController::index'); // Halaman utama dashboard setelah login

// Rute untuk barang
$routes->get('/barang', 'ViewsBarangController::views'); // Daftar barang
$routes->get('/barang/search', 'ViewsBarangController::search'); // Pencarian barang
$routes->get('/barang/detail/(:any)', 'ViewsBarangController::detail/$1'); // Detail barang
$routes->get('/barang/add', 'InputBarangController::add'); // Form tambah barang
$routes->post('/barang/save', 'InputBarangController::save'); // Simpan barang
$routes->get('/barang/edit/(:any)', 'InputBarangController::edit/$1');
$routes->post('/barang/update', 'InputBarangController::update');
$routes->get('/barang/delete/(:any)', 'InputBarangController::delete/$1');

// Rute untuk transaksi
$routes->get('/transaksi', 'TransaksiController::index'); // Form transaksi
$routes->get('/transaksi/form/(:segment)', 'TransaksiController::edit/$1'); // Form edit transaksi
$routes->post('/transaksi/save', 'TransaksiController::save'); // Simpan transaksi
$routes->post('/transaksi/update', 'TransaksiController::update'); // Update transaksi
$routes->get('/transaksi/detail/(:segment)', 'TransaksiController::detail/$1'); // Detail transaksi
$routes->post('/barang/search', 'TransaksiController::searchBarang'); // Pencarian barang
$routes->post('/customer/search', 'TransaksiController::searchCustomer'); // Pencarian customer



// Rute untuk peminjaman
$routes->get('/peminjaman/log', 'LogPeminjamanController::logPeminjaman'); // Log peminjaman
$routes->get('/peminjaman/detail/(:any)', 'LogPeminjamanController::detail/$1'); // Detail peminjaman
$routes->get('/peminjaman/delete/(:any)', 'LogPeminjamanController::delete/$1'); // Hapus peminjaman

// Rute untuk halaman depan
$routes->get('/home', 'FrontController::index'); // Halaman utama
$routes->get('/barang/edit/(:any)', 'InputBarangController::edit/$1');
$routes->post('/barang/update', 'InputBarangController::update');
$routes->get('/barang/delete/(:any)', 'InputBarangController::delete/$1');

$routes->get('/formcustomer', 'FormCustomerController::index');
$routes->post('/formcustomer/save', 'FormCustomerController::save');
$routes->get('/listcustomer', 'FormCustomerController::list');
$routes->get('/customer/search', 'FormCustomerController::search');
$routes->get('/editcustomer/(:segment)', 'FormCustomerController::edit/$1');
$routes->post('/updatecustomer/(:segment)', 'FormCustomerController::update/$1');
$routes->get('/deletecustomer/(:segment)', 'FormCustomerController::delete/$1');
$routes->get('/barang/export', 'ViewsBarangController::exportExcel');
$routes->get('/peminjaman/export', 'LogPeminjamanController::export');


$routes->post('/transaksi/save', 'TransaksiController::save');

$routes->get('/jadwal', 'JadwalController::jadwal');

