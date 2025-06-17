<?php

namespace App\Controllers;

use App\Models\BarangModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ViewsBarangController extends BaseController
{
    protected $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function views()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); 
        }

        $barang = $this->barangModel->findAll();

        return view('dashboard/viewsbarang', ['barang' => $barang]);
    }

    public function search()
    {
        $query = $this->request->getGet('q'); 
        $barang = $this->barangModel
            ->like('nama_barang', $query)
            ->orLike('merek', $query)
            ->orLike('kategori_alat', $query)
            ->findAll();

        return view('dashboard/viewsbarang', [
            'barang' => $barang,
            'q' => $query 
        ]);
    }

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
    public function exportExcel()
    {
        $barang = $this->barangModel->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'ID Barang')
              ->setCellValue('B1', 'Nama Barang')
              ->setCellValue('C1', 'Kategori Alat')
              ->setCellValue('D1', 'Merek')
              ->setCellValue('E1', 'Spesifikasi')
              ->setCellValue('F1', 'Tahun Pengadaan')
              ->setCellValue('G1', 'Sumber Anggaran')
              ->setCellValue('H1', 'Lokasi Penyimpanan')
              ->setCellValue('I1', 'Kondisi')
              ->setCellValue('J1', 'Catatan')
              ->setCellValue('K1', 'Jumlah Stok');

        // Populate data
        $row = 2;
        foreach ($barang as $item) {
            $sheet->setCellValue('A' . $row, $item['barang_id'])
                  ->setCellValue('B' . $row, $item['nama_barang'])
                  ->setCellValue('C' . $row, $item['kategori_alat'])
                  ->setCellValue('D' . $row, $item['merek'])
                  ->setCellValue('E' . $row, $item['spesifikasi'])
                  ->setCellValue('F' . $row, $item['tahun_pengadaan'])
                  ->setCellValue('G' . $row, $item['sumber_anggaran'])
                  ->setCellValue('H' . $row, $item['lokasi_penyimpanan'])
                  ->setCellValue('I' . $row, $item['kondisi'])
                  ->setCellValue('J' . $row, $item['catatan'])
                  ->setCellValue('K' . $row, $item['jumlah_stok']);
            $row++;
        }

        // Write to file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Daftar_Barang.xlsx';

        // Set HTTP headers for file download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
