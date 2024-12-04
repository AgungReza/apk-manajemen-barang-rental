<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;

class FrontController extends BaseController
{
    public function index()
    {
        $peminjamanModel = new PeminjamanModel();

        // Barang bookingan hari ini
        $bookingToday = $peminjamanModel->select('
                tb_transaksi.transaksi_id,
                customer.nama_customer,
                tb_transaksi.tanggal_keluar,
                tb_transaksi.jam_keluar
            ')
            ->join('customer', 'customer.customer_id = tb_transaksi.customer_id')
            ->where('DATE(tb_transaksi.tanggal_keluar)', date('Y-m-d'))
            ->findAll();

        // Barang yang akan kembali hari ini
        $returningToday = $peminjamanModel->select('
                tb_transaksi.transaksi_id,
                customer.nama_customer,
                tb_transaksi.tanggal_kembali,
                tb_transaksi.jam_kembali
            ')
            ->join('customer', 'customer.customer_id = tb_transaksi.customer_id')
            ->where('DATE(tb_transaksi.tanggal_kembali)', date('Y-m-d'))
            ->findAll();

        return view('dashboard/home', [
            'bookingToday' => $bookingToday,
            'returningToday' => $returningToday,
        ]);
    }
}
