<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\StatusModel;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use App\Models\CustomerModel;
use Dompdf\Dompdf;
use Dompdf\Options;

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
            foreach ($results as &$barang) {
                $barang['status_color'] = $barang['status'] == 1 ? 'green' : 'red';
                $barang['status_text'] = $barang['status'] == 1 ? 'Siap Digunakan' : 'Tidak Tersedia';
            }
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

        $barangHarga = $this->request->getPost('barang_harga');
        $diskon = (int) $this->request->getPost('diskon');

        $tanggalPinjam = strtotime($this->request->getPost('tanggal_pinjam'));
        $tanggalKembali = strtotime($this->request->getPost('tanggal_kembali'));
        $jamPinjam = $this->request->getPost('jam_pinjam') ?: date('H:i:s');
        $jamKembali = $this->request->getPost('jam_kembali') ?: date('H:i:s');

        $durasi = max(1, floor(($tanggalKembali - $tanggalPinjam) / (60 * 60 * 24)) + 1);

        $total = 0;
        foreach ($barangHarga as $harga) {
            $total += (int)$harga * $durasi;
        }
        $diskonNominal = floor($total * $diskon / 100);
        $totalSetelahDiskon = $total - $diskonNominal;

        $transaksiModel = new TransaksiModel();
        $detailTransaksiModel = new DetailTransaksiModel();
        $barangModel = new BarangModel();
        $db = \Config\Database::connect();

        try {
            $db->transBegin();
            $transaksiId = uniqid('TRX-');
            $transaksiData = [
                'transaksi_id' => $transaksiId,
                'customer_id' => $this->request->getPost('customer_id'),
                'tanggal_keluar' => date('Y-m-d', $tanggalPinjam),
                'jam_keluar' => $jamPinjam,
                'tanggal_kembali' => date('Y-m-d', $tanggalKembali),
                'jam_kembali' => $jamKembali,
                'status_transaksi' => $this->request->getPost('status_id'),
                'catatan' => $this->request->getPost('catatan'),
                'durasi_sewa' => $durasi,
                'diskon' => $diskon,
                'total_harga' => $totalSetelahDiskon,
            ];
            $transaksiModel->insert($transaksiData);

            foreach ($barangIds as $i => $barangId) {
                $detailTransaksiModel->insert([
                    'transaksi_id' => $transaksiId,
                    'barang_id' => $barangId,
                    'jumlah' => 1,
                    'spesifikasi' => 'N/A',
                    'harga' => (int)$barangHarga[$i],
                ]);
                $barangModel->update($barangId, ['status' => 2]);
            }

            $db->transCommit();
            return redirect()->to('/transaksi')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function update()
    {
        $transaksiId = $this->request->getPost('transaksi_id');
        $barangIds = $this->request->getPost('barang_id');
        $barangHarga = $this->request->getPost('barang_harga');
        $diskon = (int) $this->request->getPost('diskon');

        $tanggalPinjam = strtotime($this->request->getPost('tanggal_pinjam'));
        $tanggalKembali = strtotime($this->request->getPost('tanggal_kembali'));
        $jamPinjam = $this->request->getPost('jam_pinjam') ?: date('H:i:s');
        $jamKembali = $this->request->getPost('jam_kembali') ?: date('H:i:s');

        $durasi = max(1, floor(($tanggalKembali - $tanggalPinjam) / (60 * 60 * 24)) + 1);

        $total = 0;
        foreach ($barangHarga as $harga) {
            $total += (int)$harga * $durasi;
        }
        $diskonNominal = floor($total * $diskon / 100);
        $totalSetelahDiskon = $total - $diskonNominal;

        $transaksiModel = new TransaksiModel();
        $detailTransaksiModel = new DetailTransaksiModel();
        $barangModel = new BarangModel();
        $db = \Config\Database::connect();

        try {
            $db->transBegin();
            $transaksiModel->update($transaksiId, [
                'customer_id' => $this->request->getPost('customer_id'),
                'tanggal_keluar' => date('Y-m-d', $tanggalPinjam),
                'jam_keluar' => $jamPinjam,
                'tanggal_kembali' => date('Y-m-d', $tanggalKembali),
                'jam_kembali' => $jamKembali,
                'status_transaksi' => $this->request->getPost('status_id'),
                'catatan' => $this->request->getPost('catatan'),
                'durasi_sewa' => $durasi,
                'diskon' => $diskon,
                'total_harga' => $totalSetelahDiskon,
            ]);

            $detailTransaksiModel->where('transaksi_id', $transaksiId)->delete();
            foreach ($barangIds as $i => $barangId) {
                $detailTransaksiModel->insert([
                    'transaksi_id' => $transaksiId,
                    'barang_id' => $barangId,
                    'jumlah' => 1,
                    'spesifikasi' => 'N/A',
                    'harga' => (int)$barangHarga[$i],
                ]);
                $barangModel->update($barangId, ['status' => in_array($this->request->getPost('status_id'), [1, 2]) ? 2 : 1]);
            }
            $db->transCommit();
            return redirect()->to('/transaksi')->with('success', 'Transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui transaksi.');
        }
    }

    public function edit($id)
    {
        $transaksiModel = new TransaksiModel();
        $detailTransaksiModel = new DetailTransaksiModel();
        $customerModel = new CustomerModel();
        $statusModel = new StatusModel();

        $transaksi = $transaksiModel->find($id);
        if (!$transaksi) {
            return redirect()->to('/transaksi')->with('error', 'Transaksi tidak ditemukan.');
        }

        $detailBarang = $detailTransaksiModel
            ->select('tb_detail_transaksi.*, tb_barang.nama_barang')
            ->join('tb_barang', 'tb_barang.barang_id = tb_detail_transaksi.barang_id', 'left')
            ->where('tb_detail_transaksi.transaksi_id', $id)
            ->findAll();

        $customer = $customerModel->find($transaksi['customer_id']);
        $statusList = $statusModel->findAll();

        return view('dashboard/formpinjamview', [
            'transaksi' => $transaksi,
            'detailBarang' => $detailBarang,
            'customer' => $customer,
            'statusList' => $statusList,
        ]);
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

    public function cetakSuratJalan($id)
    {
        $transaksiModel = new TransaksiModel();
        $detailTransaksiModel = new DetailTransaksiModel();
        $customerModel = new CustomerModel();

        $transaksi = $transaksiModel->find($id);
        if (!$transaksi) {
            return redirect()->to('/transaksi')->with('error', 'Transaksi tidak ditemukan.');
        }

        $detailBarang = $detailTransaksiModel
            ->select('tb_detail_transaksi.*, tb_barang.nama_barang')
            ->join('tb_barang', 'tb_barang.barang_id = tb_detail_transaksi.barang_id')
            ->where('tb_detail_transaksi.transaksi_id', $id)
            ->findAll();

        $customer = $customerModel->find($transaksi['customer_id']);

        $html = view('dashboard/surat_jalan', [
            'transaksi' => $transaksi,
            'detail_barang' => $detailBarang,
            'customer' => $customer,
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Surat_Jalan_{$id}.pdf", ['Attachment' => false]);
    }
}
