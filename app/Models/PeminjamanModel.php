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
}
