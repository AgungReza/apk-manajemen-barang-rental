<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table = 'tb_transaksi'; 
    protected $primaryKey = 'transaksi_id'; 
    protected $allowedFields = [
        'barang_id', 'customer_id', 'user_id', 'tanggal_keluar', 'tanggal_kembali', 'status_transaksi', 'catatan'
    ]; 

    public function getAllPeminjaman()
    {
        return $this->select('tb_transaksi.transaksi_id, tb_transaksi.barang_id, tb_transaksi.catatan, 
                              customer.nama_customer as nama_peminjam, tb_barang.nama_barang')
                    ->join('customer', 'customer.customer_id = tb_transaksi.customer_id')
                    ->join('tb_barang', 'tb_barang.barang_id = tb_transaksi.barang_id')
                    ->findAll();
    }
    public function getBookingToday()
    {
        // Mengambil barang yang dipesan hari ini (status_transaksi = 2 -> dipesan)
        return $this->select('tb_transaksi.transaksi_id, tb_barang.nama_barang, customer.nama_customer as nama_peminjam')
                    ->join('customer', 'customer.customer_id = tb_transaksi.customer_id')
                    ->join('tb_barang', 'tb_barang.barang_id = tb_transaksi.barang_id')
                    ->where('tb_transaksi.status_transaksi', 2) // Status "dipesan"
                    ->where('DATE(tb_transaksi.tanggal_keluar)', date('Y-m-d'))
                    ->findAll();
    }

public function getReturningToday()
    {
        // Mengambil barang yang akan dikembalikan hari ini
        return $this->select('tb_transaksi.transaksi_id, tb_barang.nama_barang, customer.nama_customer as nama_peminjam, tb_transaksi.tanggal_kembali')
                    ->join('customer', 'customer.customer_id = tb_transaksi.customer_id')
                    ->join('tb_barang', 'tb_barang.barang_id = tb_transaksi.barang_id')
                    ->where('DATE(tb_transaksi.tanggal_kembali)', date('Y-m-d'))
                    ->findAll();
    }

}
