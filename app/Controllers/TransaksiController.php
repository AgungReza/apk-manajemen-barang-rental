<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\TransaksiModel;

class TransaksiController extends BaseController
{
    public function index()
    {
        return view('dashboard/formpinjam');
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
            'customer_name' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required',
            'barang_id' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $transaksiModel = new TransaksiModel();
        try {
            // Simpan transaksi
            $transaksiId = $transaksiModel->insert([
                'customer_name' => $this->request->getPost('customer_name'),
                'tanggal_pinjam' => $this->request->getPost('tanggal_pinjam'),
                'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            ]);

            // Simpan detail barang
            $barangIds = $this->request->getPost('barang_id');
            foreach ($barangIds as $barangId) {
                $transaksiModel->insertBarangDetail($transaksiId, $barangId);
            }

            return redirect()->to('/transaksi')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi.');
        }
    }
}
