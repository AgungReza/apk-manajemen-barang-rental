<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\StatusModel;
use App\Models\TransaksiModel;

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
        log_message('error', 'Validasi gagal: ' . json_encode($validation->getErrors()));
        return redirect()->back()->with('errors', $validation->getErrors());
    }

    $barangIds = $this->request->getPost('barang_id');
    if (!is_array($barangIds)) {
        $barangIds = [$barangIds];
    }
    log_message('info', "Barang ID diterima: " . json_encode($barangIds));

    $barangModel = new BarangModel();
    foreach ($barangIds as $barangId) {
        if (!$barangModel->find($barangId)) {
            log_message('error', "Barang ID tidak valid: " . $barangId);
            return redirect()->back()->with('error', 'Barang ID tidak valid.');
        }
        log_message('info', "Barang valid dengan ID: " . $barangId);
    }

    $userId = session()->get('user_id');
    if (!$userId) {
        log_message('error', 'User ID tidak ditemukan di sesi login.');
        return redirect()->back()->with('error', 'Anda harus login untuk melakukan transaksi.');
    }

    $transaksiModel = new TransaksiModel();
    $db = \Config\Database::connect();

    try {
        $db->transBegin(); 

        foreach ($barangIds as $barangId) {
            $transaksiId = uniqid('TRX-');
            $transaksiData = [
                'transaksi_id' => $transaksiId,
                'customer_id' => $this->request->getPost('customer_id'),
                'user_id' => $userId,
                'tanggal_keluar' => $this->request->getPost('tanggal_pinjam'),
                'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
                'barang_id' => $barangId,
                'status_transaksi' => $this->request->getPost('status_id'),
                'catatan' => $this->request->getPost('catatan'),
            ];

            log_message('info', "Data transaksi sebelum insert: " . json_encode($transaksiData));

            $builder = $db->table('tb_transaksi');
            if (!$builder->insert($transaksiData)) {
                $lastQuery = $db->getLastQuery();
                $error = $db->error(); 
                log_message('error', 'Gagal menyimpan data transaksi.');
                log_message('error', 'Query terakhir: ' . $lastQuery);
                log_message('error', 'Error Code: ' . $error['code']);
                log_message('error', 'Error Message: ' . $error['message']);
                throw new \Exception('Gagal menyimpan transaksi.');
            }
        }

        $db->transCommit();
        log_message('info', 'Transaksi berhasil disimpan.');
        return redirect()->to('/transaksi')->with('success', 'Transaksi berhasil disimpan.');
    } catch (\Exception $e) {
        $db->transRollback(); 
        log_message('error', 'Kesalahan saat menyimpan transaksi: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi.');
    }
}

}
