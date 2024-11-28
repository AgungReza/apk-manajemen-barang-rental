<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute untuk autentikasi
$routes->get('/register', 'AuthController::register'); // Halaman register
$routes->post('/register/submit', 'AuthController::submitRegister'); // Proses register
$routes->get('/login', 'AuthController::login'); // Halaman login
$routes->post('/login/submit', 'AuthController::submitLogin'); // Proses login
$routes->get('/logout', 'AuthController::logout'); // Logout

// Rute untuk dashboard
$routes->get('/dashboard', 'ViewsBarangController::views'); // Halaman utama dashboard setelah login

// Rute untuk halaman barang
$routes->get('/barang', 'ViewsBarangController::views'); // Menampilkan daftar barang
$routes->get('/barang/search', 'ViewsBarangController::search'); // Pencarian barang

// Rute untuk penambahan barang
$routes->get('/barang/add', 'InputBarangController::add'); // Halaman form tambah barang
$routes->post('/barang/save', 'InputBarangController::save'); // Proses menyimpan data barang

// Rute untuk pembaruan barang
$routes->get('/barang/edit/(:any)', 'InputBarangController::edit/$1'); // Halaman edit barang dengan kode barang
$routes->post('/barang/update/(:any)', 'InputBarangController::update/$1'); // Proses update data barang

// Rute untuk penghapusan barang
$routes->get('/barang/delete/(:any)', 'InputBarangController::delete/$1'); // Proses menghapus barang

// Rute untuk detail barang
$routes->get('/barang/detail/(:any)', 'ViewsBarangController::detail/$1'); // Menampilkan detail barang

// Rute untuk halaman transaksi
$routes->get('/transaksi', 'TransaksiController::index'); // Halaman Form Transaksi
$routes->post('/barang/search', 'TransaksiController::searchBarang'); // Proses pencarian barang
$routes->post('/transaksi/save', 'TransaksiController::save'); // Proses penyimpanan transaksi

// Rute untuk pendaftaran customer
$routes->get('/formcustomer', 'FormCustomerController::index'); // Halaman Form Customer
$routes->post('/formcustomer/save', 'FormCustomerController::save'); // Proses menyimpan data customer
$routes->post('/customer/search', 'TransaksiController::searchCustomer'); // Pencarian customer
$routes->post('/customer/add', 'TransaksiController::addCustomer'); // Proses menambahkan customer baru
$routes->post('/alat/search', 'TransaksiController::searchAlat');
