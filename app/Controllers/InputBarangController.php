<?php

namespace App\Controllers;

use App\Models\BarangModel;

class InputBarangController extends BaseController
{
    protected $barangModel; // Properti model
    protected $db;          // Properti database

    public function __construct()
    {
        $this->barangModel = new BarangModel(); // Inisialisasi model
        $this->db = \Config\Database::connect(); // Koneksi ke database
    }

    // Halaman Form Input Barang
    public function add()
    {
        return view('dashboard/inputbarang');
    }

    // Proses Simpan Data
    public function save()
    {
        log_message('info', 'Memulai proses penyimpanan data barang.');

        // Validasi Input
        $validation = $this->validate([
            'nama_barang' => 'required',
            'kategori_alat' => 'required',
            'jumlah_stok' => 'required|numeric',
        ]);

        if (!$validation) {
            log_message('error', 'Validasi gagal: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Generate ID Barang Unik
        $barang_id = $this->generateUniqueBarangID();

        // Siapkan Data
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

        // Simpan Data ke Database
        if ($this->barangModel->insert($data)) { // Gunakan insert() untuk menambah data baru
            log_message('info', 'Query executed: ' . $this->db->getLastQuery());
            return redirect()->to('/barang')->with('success', 'Data berhasil disimpan!');
        } else {
            log_message('error', 'Query failed: ' . $this->db->getLastQuery());
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
        }
    }

    // Generate ID Barang Unik
    private function generateUniqueBarangID()
    {
        do {
            // Generate ID dengan kombinasi huruf dan angka
            $barang_id = strtoupper(substr(uniqid(), -6)); // ID unik dengan panjang 6 karakter
        } while ($this->barangModel->where('barang_id', $barang_id)->countAllResults() > 0);

        return $barang_id;
    }
}
