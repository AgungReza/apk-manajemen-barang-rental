<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table = 'tb_detail_transaksi';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'transaksi_id',
        'barang_id',
        'jumlah',
        'spesifikasi',
        'harga'  // ✅ ditambahkan untuk simpan harga per barang
    ];

    public function isBarangAvailable($barangId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_detail_transaksi'); // ✅ perbaikan nama tabel
        $builder->select('barang_id');
        $builder->join('tb_transaksi', 'tb_transaksi.transaksi_id = tb_detail_transaksi.transaksi_id'); // ✅ perbaikan
        $builder->where('tb_detail_transaksi.barang_id', $barangId);
        $builder->whereIn('tb_transaksi.status_transaksi', [1, 2]); // Status aktif/pinjam/dipesan

        $result = $builder->get()->getRow();

        return $result ? false : true; // Jika ada berarti tidak tersedia
    }
}
