<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\StatusModel;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;

class TransaksiController extends BaseController
{
    public function index()
    {
        $statusModel = new StatusModel();
        $statusList = $statusModel->getAllStatus(); 
        return view('dashboard/formpinjam', ['statusList' => $statusList]);
    }

    public function searchCustomer()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getVar('keyword');
            $customerModel = new \App\Models\CustomerModel();
            $results = $customerModel->like('nama_customer', $keyword)->findAll(10);
            return $this->response->setJSON($results);
        }
        return $this->response->setStatusCode(404, 'Request bukan AJAX.');
    }

    public function searchBarang()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getVar('keyword');
            $barangModel = new BarangModel();
            $results = $barangModel->like('nama_barang', $keyword)->findAll(10);
            return $this->response->setJSON($results);
        }
        return $this->response->setStatusCode(404, 'Request bukan AJAX.');
    }

    public function save()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'customer_id' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required',
            'barang_id' => 'required',
            'status_id' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $barangIds = $this->request->getPost('barang_id');
        if (!is_array($barangIds)) {
            $barangIds = [$barangIds];
        }

        $barangModel = new BarangModel();
        foreach ($barangIds as $barangId) {
            if (!$barangModel->find($barangId)) {
                return redirect()->back()->with('error', 'Barang ID tidak valid.');
            }
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->back()->with('error', 'Anda harus login untuk melakukan transaksi.');
        }

        $transaksiModel = new TransaksiModel();
        $detailTransaksiModel = new DetailTransaksiModel(); // Gunakan model detail transaksi
        $db = \Config\Database::connect();

        try {
            $db->transBegin();

            // Simpan data transaksi utama
            $transaksiId = uniqid('TRX-');
            $transaksiData = [
                'transaksi_id' => $transaksiId,
                'customer_id' => $this->request->getPost('customer_id'),
                'user_id' => $userId,
                'tanggal_keluar' => date('Y-m-d', strtotime($this->request->getPost('tanggal_pinjam'))),
                'jam_keluar' => date('H:i:s', strtotime($this->request->getPost('tanggal_pinjam'))),
                'tanggal_kembali' => date('Y-m-d', strtotime($this->request->getPost('tanggal_kembali'))),
                'jam_kembali' => date('H:i:s', strtotime($this->request->getPost('tanggal_kembali'))),
                'status_transaksi' => $this->request->getPost('status_id'),
                'catatan' => $this->request->getPost('catatan'),
            ];
            $transaksiModel->insert($transaksiData);

            // Simpan data detail transaksi
            foreach ($barangIds as $barangId) {
                $detailData = [
                    'transaksi_id' => $transaksiId,
                    'barang_id' => $barangId,
                    'jumlah' => 1, // Default jumlah barang (sesuai kebutuhan)
                    'spesifikasi' => 'N/A', // Default spesifikasi jika tidak diisi
                ];
                $detailTransaksiModel->insert($detailData);
            }

            $db->transCommit();
            return redirect()->to('/transaksi')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi.');
        }
    }

    public function detail($transaksi_id)
    {
        $transaksiModel = new TransaksiModel();
        $detailTransaksiModel = new DetailTransaksiModel();
        $customerModel = new \App\Models\CustomerModel();

        // Ambil data transaksi utama
        $transaksi = $transaksiModel->where('transaksi_id', $transaksi_id)->first();

        if (!$transaksi) {
            return redirect()->to('/transaksi')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Ambil data detail transaksi
        $detailBarang = $detailTransaksiModel->where('transaksi_id', $transaksi_id)->findAll();

        // Gabungkan data dengan customer
        $customer = $customerModel->where('customer_id', $transaksi['customer_id'])->first();

        $detail = [
            'transaksi' => $transaksi,
            'detail_barang' => $detailBarang,
            'nama_customer' => $customer['nama_customer'],
        ];

        // Kirim data ke view
        return view('dashboard/detail_peminjaman', ['detail' => $detail]);
    }


}
