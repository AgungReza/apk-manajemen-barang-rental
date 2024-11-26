<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'tb_transaksi';
    protected $primaryKey = 'transaksi_id';
    protected $allowedFields = ['customer_name', 'tanggal_pinjam', 'tanggal_kembali'];

    public function insertBarangDetail($transaksiId, $barangId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_transaksi_detail');
        $builder->insert([
            'transaksi_id' => $transaksiId,
            'barang_id' => $barangId,
        ]);
    }
}
