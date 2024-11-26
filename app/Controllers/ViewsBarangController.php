<?php

namespace App\Controllers;

use App\Models\BarangModel;

class ViewsBarangController extends BaseController
{
    protected $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    // Menampilkan daftar barang
    public function views()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect ke halaman login jika belum login
        }

        $barang = $this->barangModel->findAll();

        return view('dashboard/viewsbarang', ['barang' => $barang]);
    }

    // Metode pencarian barang
    public function search()
    {
        $query = $this->request->getGet('q'); // Mengambil parameter pencarian dari URL
        $barang = $this->barangModel
            ->like('nama_barang', $query)
            ->orLike('merek', $query)
            ->orLike('kategori_alat', $query)
            ->findAll();

        return view('dashboard/viewsbarang', [
            'barang' => $barang,
            'q' => $query // Mengirimkan kembali query ke view untuk ditampilkan di form
        ]);
    }

    // Menampilkan detail barang
    public function detail($barangId)
    {
        $barang = $this->barangModel->find($barangId);

        if (!$barang) {
            return redirect()->to('/barang')->with('error', 'Barang tidak ditemukan.');
        }

        $data = [
            'barang' => $barang
        ];

        return view('dashboard/detailbarang', $data);
    }
}
