<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table = 'tb_detail_transaksi';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = [
        'id_detail',
        'transaksi_id',
        'barang_id',
        'jumlah',
        'spesifikasi',
    ];
}
