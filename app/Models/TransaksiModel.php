<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'tb_transaksi';
    protected $primaryKey = 'transaksi_id';
    protected $allowedFields = [
        'transaksi_id',
        'customer_id',
        'user_id',
        'tanggal_keluar',
        'tanggal_kembali',
        'barang_id',
        'status_transaksi',
        'catatan',
    ];
}