<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;

class PeminjamanController extends BaseController
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
    
        $builder = $model->select('tb_transaksi.transaksi_id, tb_transaksi.barang_id, tb_transaksi.tanggal_keluar as tanggal_pinjam, tb_transaksi.tanggal_kembali, status.status_name as status, tb_barang.nama_barang, customer.nama_customer as nama_peminjam')
                     ->join('customer', 'customer.customer_id = tb_transaksi.customer_id')
                     ->join('tb_barang', 'tb_barang.barang_id = tb_transaksi.barang_id')
                     ->join('status', 'status.id = tb_transaksi.status_transaksi'); // Join tabel status


    if ($search) {
        $builder->groupStart()
                ->like('customer.nama_customer', $search)
                ->orLike('tb_barang.nama_barang', $search)
                ->groupEnd();
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
        $data['detail'] = $this->peminjamanModel
            ->select('tb_transaksi.*, tb_barang.nama_barang, customer.nama_customer')
            ->join('tb_barang', 'tb_barang.barang_id = tb_transaksi.barang_id')
            ->join('customer', 'customer.customer_id = tb_transaksi.customer_id')
            ->find($id);

        if (!$data['detail']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data peminjaman tidak ditemukan');
        }

        return view('detail_peminjaman', $data);
    }

    public function delete($id)
    {
        $this->peminjamanModel->delete($id);
        return redirect()->to('/peminjaman/log')->with('message', 'Log peminjaman berhasil dihapus!');
    }
}
