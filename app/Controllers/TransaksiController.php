<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\StatusModel;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use App\Models\CustomerModel;

class TransaksiController extends BaseController
{
    public function index()
    {
        $statusModel = new StatusModel();
        $statusList = $statusModel->findAll();

        return view('dashboard/formpinjam', ['statusList' => $statusList]);
    }

    public function show($id)
    {
        $transaksiModel = new TransaksiModel();
        $detailTransaksiModel = new DetailTransaksiModel();
        $customerModel = new CustomerModel();

        $transaksi = $transaksiModel->find($id);

        if (!$transaksi) {
            return redirect()->to('/transaksi')->with('error', 'Transaksi tidak ditemukan.');
        }

        $detailBarang = $detailTransaksiModel->where('transaksi_id', $id)->findAll();
        $customer = $customerModel->find($transaksi['customer_id']);

        return view('dashboard/detail_transaksiz', [
            'transaksi' => $transaksi,
            'detail_barang' => $detailBarang,
            'customer' => $customer,
        ]);
    }

    public function searchCustomer()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getVar('keyword');
            $customerModel = new CustomerModel();
            $results = $customerModel->like('nama_customer', $keyword)->findAll(10);
            return $this->response->setJSON($results);
        }
        return $this->response->setStatusCode(404, 'Request harus berupa AJAX.');
    }

    public function searchBarang()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getVar('keyword');
            $barangModel = new BarangModel();
            $results = $barangModel->like('nama_barang', $keyword)->findAll(10);
            return $this->response->setJSON($results);
        }
        return $this->response->setStatusCode(404, 'Request harus berupa AJAX.');
    }

    public function save()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'customer_id' => 'required',
            'tanggal_pinjam' => 'required|valid_date',
            'tanggal_kembali' => 'required|valid_date',
            'barang_id' => 'required',
            'status_id' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $barangIds = $this->request->getPost('barang_id');
        if (!is_array($barangIds)) {
            $barangIds = [$barangIds];
        }

        $barangModel = new BarangModel();
        foreach ($barangIds as $barangId) {
            if (!$barangModel->find($barangId)) {
                return redirect()->back()->withInput()->with('error', 'Barang ID tidak valid.');
            }
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melakukan transaksi.');
        }

        $transaksiModel = new TransaksiModel();
        $detailTransaksiModel = new DetailTransaksiModel();
        $db = \Config\Database::connect();

        try {
            $db->transBegin();

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

            foreach ($barangIds as $barangId) {
                $detailData = [
                    'transaksi_id' => $transaksiId,
                    'barang_id' => $barangId,
                    'jumlah' => 1,
                    'spesifikasi' => 'N/A',
                ];
                $detailTransaksiModel->insert($detailData);
            }

            $db->transCommit();
            return redirect()->to('/transaksi')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi.');
        }
    }

    public function detail($id)
    {
        $transaksiModel = new TransaksiModel();
        $detailTransaksiModel = new DetailTransaksiModel();
        $customerModel = new CustomerModel();

        $transaksi = $transaksiModel->find($id);

        if (!$transaksi) {
            return redirect()->to('/transaksi')->with('error', 'Transaksi tidak ditemukan.');
        }

        $detailBarang = $detailTransaksiModel->where('transaksi_id', $id)->findAll();
        $customer = $customerModel->find($transaksi['customer_id']);

        return view('dashboard/detail_peminjaman', [
            'transaksi' => $transaksi,
            'detail_barang' => $detailBarang,
            'customer' => $customer,
        ]);
    }
    public function edit($id)
{
    $transaksiModel = new TransaksiModel();
    $detailTransaksiModel = new DetailTransaksiModel();
    $customerModel = new CustomerModel();
    $statusModel = new StatusModel();

    // Ambil data transaksi berdasarkan ID
    $transaksi = $transaksiModel->find($id);

    if (!$transaksi) {
        return redirect()->to('/transaksi')->with('error', 'Transaksi tidak ditemukan.');
    }

    // Ambil data barang terkait transaksi
    $detailBarang = $detailTransaksiModel
        ->select('tb_detail_transaksi.*, tb_barang.nama_barang')  // Ambil nama_barang dari tb_barang
        ->join('tb_barang', 'tb_barang.barang_id = tb_detail_transaksi.barang_id', 'left')
        ->where('tb_detail_transaksi.transaksi_id', $id)
        ->findAll();

    // Ambil data customer terkait transaksi
    $customer = $customerModel->find($transaksi['customer_id']);

    // Ambil daftar status
    $statusList = $statusModel->findAll();

    return view('dashboard/formpinjamview', [
        'transaksi' => $transaksi,
        'detailBarang' => $detailBarang,
        'customer' => $customer,
        'statusList' => $statusList,
    ]);
}


    public function update()
    {
        $transaksiId = $this->request->getPost('transaksi_id');
        if (!$transaksiId) {
            return redirect()->back()->with('error', 'ID transaksi tidak ditemukan.');
        }

        // Validasi dan update transaksi
        $validation = \Config\Services::validation();
        $validation->setRules([
            'customer_id' => 'required',
            'tanggal_pinjam' => 'required|valid_date',
            'tanggal_kembali' => 'required|valid_date',
            'barang_id' => 'required',
            'status_id' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $transaksiModel = new TransaksiModel();
        $detailTransaksiModel = new DetailTransaksiModel();
        $barangIds = $this->request->getPost('barang_id');

        $db = \Config\Database::connect();
        try {
            $db->transBegin();

            // Update data transaksi
            $transaksiModel->update($transaksiId, [
                'customer_id' => $this->request->getPost('customer_id'),
                'tanggal_keluar' => date('Y-m-d', strtotime($this->request->getPost('tanggal_pinjam'))),
                'jam_keluar' => date('H:i:s', strtotime($this->request->getPost('tanggal_pinjam'))),
                'tanggal_kembali' => date('Y-m-d', strtotime($this->request->getPost('tanggal_kembali'))),
                'jam_kembali' => date('H:i:s', strtotime($this->request->getPost('tanggal_kembali'))),
                'status_transaksi' => $this->request->getPost('status_id'),
                'catatan' => $this->request->getPost('catatan'),
            ]);

            // Update barang terkait transaksi
            $detailTransaksiModel->where('transaksi_id', $transaksiId)->delete(); // Hapus detail lama
            foreach ($barangIds as $barangId) {
                $detailTransaksiModel->insert([
                    'transaksi_id' => $transaksiId,
                    'barang_id' => $barangId,
                    'jumlah' => 1, // Default jumlah
                    'spesifikasi' => 'N/A', // Default spesifikasi
                ]);
            }

            $db->transCommit();
            return redirect()->to('/transaksi')->with('success', 'Transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui transaksi.');
        }
    }


}
