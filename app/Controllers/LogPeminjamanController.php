<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\DetailTransaksiModel;

class LogPeminjamanController extends BaseController
{
    protected $peminjamanModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
    }

    public function logPeminjaman()
    {
        $search = $this->request->getGet('search');
        $tanggal = $this->request->getGet('tanggal');

        $model = new PeminjamanModel();

        $builder = $model->select('
                tb_transaksi.transaksi_id,
                tb_transaksi.customer_id,
                customer.nama_customer,
                CONCAT(tb_transaksi.tanggal_keluar, " ", tb_transaksi.jam_keluar) as tanggal_pinjam,
                CONCAT(tb_transaksi.tanggal_kembali, " ", tb_transaksi.jam_kembali) as tanggal_kembali,
                status.status_name as status_transaksi
            ')
            ->join('customer', 'customer.customer_id = tb_transaksi.customer_id')
            ->join('status', 'status.id = tb_transaksi.status_transaksi');

        if ($search) {
            $builder->like('customer.nama_customer', $search);
        }

        if ($tanggal) {
            $builder->where('DATE(tb_transaksi.tanggal_keluar)', $tanggal);
        }

        $data['peminjaman'] = $builder->findAll();
        $data['search'] = $search;
        $data['tanggal'] = $tanggal;

        return view('dashboard/log_peminjaman', $data);
    }

    public function detail($id)
    {
        $model = new PeminjamanModel();

        $transaksi = $model->select('
                tb_transaksi.transaksi_id,
                tb_transaksi.customer_id,
                customer.nama_customer,
                CONCAT(tb_transaksi.tanggal_keluar, " ", tb_transaksi.jam_keluar) as tanggal_pinjam,
                CONCAT(tb_transaksi.tanggal_kembali, " ", tb_transaksi.jam_kembali) as tanggal_kembali,
                tb_transaksi.catatan,
                status.status_name as status_transaksi
            ')
            ->join('customer', 'customer.customer_id = tb_transaksi.customer_id')
            ->join('status', 'status.id = tb_transaksi.status_transaksi')
            ->where('tb_transaksi.transaksi_id', $id)
            ->first();

        if (!$transaksi) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data transaksi tidak ditemukan');
        }

        $barangModel = new DetailTransaksiModel();
        $barang = $barangModel->select('tb_barang.barang_id, tb_barang.nama_barang, tb_detail_transaksi.jumlah, tb_detail_transaksi.spesifikasi')
            ->join('tb_barang', 'tb_barang.barang_id = tb_detail_transaksi.barang_id')
            ->where('tb_detail_transaksi.transaksi_id', $id)
            ->findAll();

        $data = [
            'transaksi' => $transaksi,
            'barang' => $barang,
        ];

        return view('dashboard/detail_transaksi', $data);
    }

    public function delete($id)
    {
        $this->peminjamanModel->delete($id);
        return redirect()->to('/peminjaman/log')->with('message', 'Log peminjaman berhasil dihapus!');
    }
}
