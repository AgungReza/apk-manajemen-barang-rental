<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\DetailTransaksiModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
    public function export()
    {
        $peminjamanModel = new PeminjamanModel();
        $detailModel = new DetailTransaksiModel();

        // Query data log peminjaman
        $logData = $peminjamanModel->select('
                tb_transaksi.transaksi_id,
                customer.nama_customer,
                CONCAT(tb_transaksi.tanggal_keluar, " ", tb_transaksi.jam_keluar) as tanggal_pinjam,
                CONCAT(tb_transaksi.tanggal_kembali, " ", tb_transaksi.jam_kembali) as tanggal_kembali,
                status.status_name as status_transaksi
            ')
            ->join('customer', 'customer.customer_id = tb_transaksi.customer_id')
            ->join('status', 'status.id = tb_transaksi.status_transaksi')
            ->findAll();

        // Buat spreadsheet
$spreadsheet = new Spreadsheet();

// Sheet: Gabungan Data
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Gabungan Data');

// Header Gabungan Data
$sheet->setCellValue('A1', 'ID Transaksi')
      ->setCellValue('B1', 'Nama Customer')
      ->setCellValue('C1', 'Tanggal Pinjam')
      ->setCellValue('D1', 'Tanggal Kembali')
      ->setCellValue('E1', 'Status Transaksi')
      ->setCellValue('F1', 'ID Barang')
      ->setCellValue('G1', 'Nama Barang')
      ->setCellValue('H1', 'Jumlah')
      ->setCellValue('I1', 'Spesifikasi');

// Data Gabungan
$row = 2;
foreach ($logData as $log) {
    $details = $detailModel->select('
            tb_detail_transaksi.transaksi_id,
            tb_barang.barang_id,
            tb_barang.nama_barang,
            tb_detail_transaksi.jumlah,
            tb_detail_transaksi.spesifikasi
        ')
        ->join('tb_barang', 'tb_barang.barang_id = tb_detail_transaksi.barang_id')
        ->where('tb_detail_transaksi.transaksi_id', $log['transaksi_id'])
        ->findAll();

    // Jika tidak ada detail barang, tetap tuliskan log
    if (empty($details)) {
        $sheet->setCellValue('A' . $row, $log['transaksi_id'])
              ->setCellValue('B' . $row, $log['nama_customer'])
              ->setCellValue('C' . $row, $log['tanggal_pinjam'])
              ->setCellValue('D' . $row, $log['tanggal_kembali'])
              ->setCellValue('E' . $row, $log['status_transaksi']);
        $row++;
    } else {
        foreach ($details as $detail) {
            $sheet->setCellValue('A' . $row, $log['transaksi_id'])
                  ->setCellValue('B' . $row, $log['nama_customer'])
                  ->setCellValue('C' . $row, $log['tanggal_pinjam'])
                  ->setCellValue('D' . $row, $log['tanggal_kembali'])
                  ->setCellValue('E' . $row, $log['status_transaksi'])
                  ->setCellValue('F' . $row, $detail['barang_id'])
                  ->setCellValue('G' . $row, $detail['nama_barang'])
                  ->setCellValue('H' . $row, $detail['jumlah'])
                  ->setCellValue('I' . $row, $detail['spesifikasi']);
            $row++;
        }
    }
}

// Simpan file Excel
$writer = new Xlsx($spreadsheet);
$fileName = 'Gabungan_Log_dan_Detail.xlsx';

// Header untuk download file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;

    }
}
