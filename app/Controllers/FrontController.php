<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\CustomerModel;
use App\Models\TransaksiModel;

class FrontController extends BaseController
{
    public function index()
    {
        // Inisialisasi model
        $barangModel = new BarangModel();
        $customerModel = new CustomerModel();
        $transaksiModel = new TransaksiModel();

        // Barang bookingan hari ini: Status "Dipesan"
        $bookingToday = $transaksiModel->select('
                tb_transaksi.transaksi_id,
                customer.nama_customer,
                tb_transaksi.tanggal_keluar,
                tb_transaksi.jam_keluar
            ')
            ->join('customer', 'customer.customer_id = tb_transaksi.customer_id')
            ->where('DATE(tb_transaksi.tanggal_keluar)', date('Y-m-d')) // Hari ini
            ->where('tb_transaksi.status_transaksi', 2) // Status "Dipesan"
            ->findAll();

        // Barang yang akan dikembalikan
        $returningToday = $transaksiModel->select('
                tb_transaksi.transaksi_id,
                customer.nama_customer,
                tb_transaksi.tanggal_kembali,
                tb_transaksi.jam_kembali
            ')
            ->join('customer', 'customer.customer_id = tb_transaksi.customer_id')
            ->where('tb_transaksi.status_transaksi', 1) // Status "Diambil"
            ->where('DATE(tb_transaksi.tanggal_kembali)', date('Y-m-d')) // Tanggal kembali hari ini
            ->where('TIMESTAMPDIFF(HOUR, NOW(), CONCAT(tb_transaksi.tanggal_kembali, " ", tb_transaksi.jam_kembali)) <=', 7) // Kurang dari 7 jam
            ->findAll();

        // Hitung jumlah total
        $totalBarang = $barangModel->countAllResults();
        $totalCustomer = $customerModel->countAllResults();
        $totalTransaksi = $transaksiModel->countAllResults();

        // Kirim data ke view
        return view('dashboard/home', [
            'bookingToday' => $bookingToday,
            'returningToday' => $returningToday,
            'totalBarang' => $totalBarang,
            'totalCustomer' => $totalCustomer,
            'totalTransaksi' => $totalTransaksi,
        ]);
    }
}
