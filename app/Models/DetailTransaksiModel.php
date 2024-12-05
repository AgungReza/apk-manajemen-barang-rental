<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['transaksi_id', 'barang_id', 'jumlah', 'spesifikasi'];

    public function isBarangAvailable($barangId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('detail_transaksi');
        $builder->select('barang_id');
        $builder->join('transaksi', 'transaksi.transaksi_id = detail_transaksi.transaksi_id');
        $builder->where('detail_transaksi.barang_id', $barangId);
        $builder->whereIn('transaksi.status_transaksi', [1, 2]); // Status "diambil" (1) dan "dipesan" (2)
        $result = $builder->get()->getRow();

        return $result ? false : true; // Jika ada, berarti barang sedang digunakan
    }
}
