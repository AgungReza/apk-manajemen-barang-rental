<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'tb_barang';
    protected $primaryKey = 'barang_id';
    protected $allowedFields = [
        'barang_id',
        'nama_barang',
        'kategori_alat',
        'merek',
        'spesifikasi',
        'lokasi_penyimpanan',
        'kondisi',
        'harga',
        'catatan',
        'user_id',
        'created_at',
        'updated_at',
        'status'
    ];
}
