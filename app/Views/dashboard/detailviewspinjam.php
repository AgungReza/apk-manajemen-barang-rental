<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Detail Transaksi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-6">Detail Transaksi</h1>

            <!-- Notifikasi -->
            <?php if (session()->getFlashdata('info')): ?>
                <div class="p-4 mb-4 text-blue-800 bg-blue-200 rounded-lg" role="alert">
                    <?= session()->getFlashdata('info'); ?>
                </div>
            <?php endif; ?>

            <!-- Detail Customer -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Customer</label>
                <p class="mt-1 block w-full bg-gray-100 text-gray-700 rounded-md p-2"><?= esc($transaksi['customer_name']); ?></p>
            </div>

            <!-- Tanggal Pinjam dan Kembali -->
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
                    <p class="mt-1 block w-full bg-gray-100 text-gray-700 rounded-md p-2"><?= esc($transaksi['tanggal_pinjam']); ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
                    <p class="mt-1 block w-full bg-gray-100 text-gray-700 rounded-md p-2"><?= esc($transaksi['tanggal_kembali']); ?></p>
                </div>
            </div>

            <!-- Daftar Barang -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Daftar Barang</label>
                <div class="p-4 border border-gray-300 rounded-lg bg-gray-50">
                    <?php if (!empty($transaksi['barang_list'])): ?>
                        <ul>
                            <?php foreach ($transaksi['barang_list'] as $barang): ?>
                                <li>ID: <?= esc($barang['barang_id']); ?> - <?= esc($barang['nama_barang']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-gray-600">Belum ada barang yang ditambahkan.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Catatan -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Catatan</label>
                <p class="mt-1 block w-full bg-gray-100 text-gray-700 rounded-md p-2"><?= nl2br(esc($transaksi['catatan'])); ?></p>
            </div>

            <!-- Status Transaksi -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Status Transaksi</label>
                <p class="mt-1 block w-full bg-gray-100 text-gray-700 rounded-md p-2"><?= esc($transaksi['status_name']); ?></p>
            </div>

            <!-- Tombol Kembali -->
            <div class="flex justify-end">
                <a href="/transaksi" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Kembali</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
 