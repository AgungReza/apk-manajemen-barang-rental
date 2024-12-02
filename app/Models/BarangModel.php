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
        'tahun_pengadaan',
        'sumber_anggaran',
        'lokasi_penyimpanan',
        'kondisi',
        'catatan',
        'jumlah_stok',
        'user_id',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = false;

    /**
     * Validasi barang_id
     *
     * @param array $barangIds
     * @return bool
     */
    public function validateBarangIds(array $barangIds): bool
    {
        foreach ($barangIds as $barangId) {
            if (!$this->find($barangId)) {
                return false; 
            }
        }
        return true; // Semua barang valid
    }
}
