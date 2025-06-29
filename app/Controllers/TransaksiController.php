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
            log_message('error', "Transaksi dengan ID {$id} tidak ditemukan.");
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

            log_message('info', "Pencarian customer dengan keyword: {$keyword}.");
            return $this->response->setJSON($results);
        }
        log_message('error', "Request pencarian customer bukan AJAX.");
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

            log_message('info', "Pencarian barang dengan keyword: {$keyword}.");
            return $this->response->setJSON($results);
        }
        log_message('error', "Request pencarian barang bukan AJAX.");
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
                'tanggal_keluar' => date('Y-m-d', strtotime($this->request->getPost('tanggal_pinjam'))),
                'tanggal_kembali' => date('Y-m-d', strtotime($this->request->getPost('tanggal_kembali'))),
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
                $barangModel->update($barangId, ['status' => 2]); // Ubah status barang
            }

            $db->transCommit();

            // Cek parameter cetak
            if ($this->request->getGet('cetak') == 1) {
                return $this->cetakSuratJalan($transaksiId);
            }

            return redirect()->to('/transaksi')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
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

        // Load view untuk PDF
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


    public function update()
    {
        $transaksiId = $this->request->getPost('transaksi_id');
        if (!$transaksiId) {
            log_message('error', 'ID transaksi tidak ditemukan saat update.');
            return redirect()->back()->with('error', 'ID transaksi tidak ditemukan.');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'customer_id' => 'required',
            'tanggal_pinjam' => 'required|valid_date',
            'tanggal_kembali' => 'required|valid_date',
            'barang_id' => 'required',
            'status_id' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            log_message('error', 'Validasi gagal pada update transaksi. Errors: ' . json_encode($validation->getErrors()));
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $transaksiModel = new TransaksiModel();
        $detailTransaksiModel = new DetailTransaksiModel();
        $barangModel = new BarangModel();

        $barangIds = $this->request->getPost('barang_id');
        $statusTransaksi = $this->request->getPost('status_id');

        $db = \Config\Database::connect();
        try {
            $db->transBegin();
            log_message('info', 'Memulai transaksi database untuk update transaksi.');

            $transaksiModel->update($transaksiId, [
                'customer_id' => $this->request->getPost('customer_id'),
                'tanggal_keluar' => date('Y-m-d', strtotime($this->request->getPost('tanggal_pinjam'))),
                'jam_keluar' => date('H:i:s', strtotime($this->request->getPost('tanggal_pinjam'))),
                'tanggal_kembali' => date('Y-m-d', strtotime($this->request->getPost('tanggal_kembali'))),
                'jam_kembali' => date('H:i:s', strtotime($this->request->getPost('tanggal_kembali'))),
                'status_transaksi' => $statusTransaksi,
                'catatan' => $this->request->getPost('catatan'),
            ]);
            log_message('info', "Transaksi dengan ID {$transaksiId} berhasil diperbarui.");

            $detailTransaksiModel->where('transaksi_id', $transaksiId)->delete();
            log_message('info', "Detail transaksi lama untuk transaksi ID {$transaksiId} berhasil dihapus.");

            foreach ($barangIds as $barangId) {
                $detailTransaksiModel->insert([
                    'transaksi_id' => $transaksiId,
                    'barang_id' => $barangId,
                    'jumlah' => 1,
                    'spesifikasi' => 'N/A',
                ]);
                log_message('info', "Detail transaksi untuk barang ID {$barangId} berhasil ditambahkan kembali.");

                // Perbarui status barang
                if (in_array($statusTransaksi, [1, 2])) {
                    $updated = $barangModel->update($barangId, ['status' => 2]);
                    log_message('info', "Barang ID {$barangId} diperbarui menjadi status 2 (sibuk): " . ($updated ? 'Success' : 'Failed'));
                } elseif (in_array($statusTransaksi, [3, 4])) {
                    $updated = $barangModel->update($barangId, ['status' => 1]);
                    log_message('info', "Barang ID {$barangId} diperbarui menjadi status 1 (ready): " . ($updated ? 'Success' : 'Failed'));
                }
            }
            

            $db->transCommit();
            log_message('info', 'Transaksi database berhasil di-commit.');
            return redirect()->to('/transaksi')->with('success', 'Transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Terjadi kesalahan saat memperbarui transaksi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui transaksi.');
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
}
