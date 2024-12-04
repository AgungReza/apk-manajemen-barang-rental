<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute untuk autentikasi
$routes->group('auth', function ($routes) {
    $routes->get('register', 'AuthController::register'); // Halaman register
    $routes->post('register/submit', 'AuthController::submitRegister'); // Proses register
    $routes->get('login', 'AuthController::login'); // Halaman login
    $routes->post('login/submit', 'AuthController::submitLogin'); // Proses login
    $routes->get('logout', 'AuthController::logout'); // Logout
});

// Rute untuk dashboard
$routes->get('/dashboard', 'ViewsBarangController::views'); // Halaman utama dashboard setelah login

// Rute untuk barang
$routes->group('barang', function ($routes) {
    $routes->get('/', 'ViewsBarangController::views'); // Menampilkan daftar barang
    $routes->get('search', 'ViewsBarangController::search'); // Pencarian barang
    $routes->get('add', 'InputBarangController::add'); // Halaman form tambah barang
    $routes->post('save', 'InputBarangController::save'); // Proses menyimpan data barang
    $routes->get('edit/(:any)', 'InputBarangController::edit/$1'); // Halaman edit barang dengan kode barang
    $routes->post('update/(:any)', 'InputBarangController::update/$1'); // Proses update data barang
    $routes->get('delete/(:any)', 'InputBarangController::delete/$1'); // Proses menghapus barang
    $routes->get('detail/(:any)', 'ViewsBarangController::detail/$1'); // Menampilkan detail barang
});

// Rute untuk transaksi
$routes->group('transaksi', function ($routes) {
    $routes->get('/', 'TransaksiController::index'); // Halaman Form Transaksi
    $routes->post('/barang/search', 'TransaksiController::searchBarang'); // Proses pencarian barang
    $routes->post('save', 'TransaksiController::save'); // Proses penyimpanan transaksi
    $routes->get('detail/(:any)', 'TransaksiController::detail/$1'); // Menampilkan detail transaksi
});

// Rute untuk pendaftaran customer
$routes->get('/formcustomer', 'FormCustomerController::index'); // Halaman Form Customer
$routes->post('/formcustomer/save', 'FormCustomerController::save'); // Proses menyimpan data customer
$routes->post('/customer/search', 'TransaksiController::searchCustomer'); // Pencarian customer
$routes->post('/customer/add', 'TransaksiController::addCustomer'); // Proses menambahkan customer baru
$routes->post('/alat/search', 'TransaksiController::searchAlat');


// Rute untuk alat
$routes->post('/alat/search', 'TransaksiController::searchAlat'); // Pencarian alat

// Rute untuk peminjaman
$routes->group('peminjaman', function ($routes) {
    $routes->get('log', 'LogPeminjamanController::logPeminjaman'); // Log Peminjaman
    $routes->get('detail/(:any)', 'LogPeminjamanController::detail/$1'); // Detail Peminjaman
    $routes->get('delete/(:any)', 'LogPeminjamanController::delete/$1'); // Hapus Peminjaman
});

// Rute untuk halaman depan
$routes->get('/home', 'FrontController::index'); // Halaman utama
