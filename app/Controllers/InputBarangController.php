<?php

namespace App\Controllers;

use App\Models\BarangModel;

class InputBarangController extends BaseController
{
    protected $barangModel; 
    protected $db;         

    public function __construct()
    {
        $this->barangModel = new BarangModel(); 
        $this->db = \Config\Database::connect();
    }

    public function add()
    {
        return view('dashboard/inputbarang');
    }

    public function save()
    {
        log_message('info', 'Memulai proses penyimpanan data barang.');

        $validation = $this->validate([
            'nama_barang' => 'required',
            'kategori_alat' => 'required',
            'jumlah_stok' => 'required|numeric',
        ]);

        if (!$validation) {
            log_message('error', 'Validasi gagal: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $barang_id = $this->generateUniqueBarangID();

        $data = [
            'barang_id' => $barang_id,
            'nama_barang' => $this->request->getPost('nama_barang'),
            'kategori_alat' => $this->request->getPost('kategori_alat'),
            'merek' => $this->request->getPost('merek'),
            'spesifikasi' => $this->request->getPost('spesifikasi'),
            'tahun_pengadaan' => $this->request->getPost('tahun_pengadaan'),
            'sumber_anggaran' => $this->request->getPost('sumber_anggaran'),
            'lokasi_penyimpanan' => $this->request->getPost('lokasi_penyimpanan'),
            'kondisi' => $this->request->getPost('kondisi'),
            'catatan' => $this->request->getPost('catatan'),
            'jumlah_stok' => $this->request->getPost('jumlah_stok'),
            'user_id' => session()->get('user_id'),
        ];

        if ($this->barangModel->insert($data)) { 
            log_message('info', 'Query executed: ' . $this->db->getLastQuery());
            return redirect()->to('/barang')->with('success', 'Data berhasil disimpan!');
        } else {
            log_message('error', 'Query failed: ' . $this->db->getLastQuery());
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
        }
    }

    private function generateUniqueBarangID()
    {
        do {
            $barang_id = strtoupper(substr(uniqid(), -6)); 
        } while ($this->barangModel->where('barang_id', $barang_id)->countAllResults() > 0);

        return $barang_id;
    }
}
