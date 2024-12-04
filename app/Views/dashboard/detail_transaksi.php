<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Detail Transaksi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold text-indigo-600 mb-6">Detail Transaksi</h1>

            <!-- Informasi Transaksi -->
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-700">ID Transaksi:</p>
                        <p class="text-lg font-semibold text-gray-900"><?= esc($transaksi['transaksi_id']) ?></p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Nama Customer:</p>
                        <p class="text-lg font-semibold text-gray-900"><?= esc($transaksi['nama_customer']) ?></p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Tanggal Pinjam:</p>
                        <p class="text-lg font-semibold text-gray-900"><?= esc($transaksi['tanggal_pinjam']) ?></p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Tanggal Kembali:</p>
                        <p class="text-lg font-semibold text-gray-900"><?= esc($transaksi['tanggal_kembali']) ?></p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Status Transaksi:</p>
                        <p class="text-lg font-semibold text-gray-900"><?= esc($transaksi['status_transaksi']) ?></p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Catatan:</p>
                        <p class="text-lg text-gray-900"><?= esc($transaksi['catatan']) ?></p>
                    </div>
                </div>
            </div>

            <!-- Daftar Barang -->
            <h2 class="text-xl font-bold text-gray-800 mb-4">Daftar Barang</h2>
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full bg-white border border-gray-300 text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-6 py-3 border-b">ID Barang</th>
                            <th class="px-6 py-3 border-b">Nama Barang</th>
                            <th class="px-6 py-3 border-b">Jumlah</th>
                            <th class="px-6 py-3 border-b">Spesifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($barang)): ?>
                            <?php foreach ($barang as $item): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 border-b"><?= esc($item['barang_id']) ?></td>
                                    <td class="px-6 py-4 border-b"><?= esc($item['nama_barang']) ?></td>
                                    <td class="px-6 py-4 border-b"><?= esc($item['jumlah']) ?></td>
                                    <td class="px-6 py-4 border-b"><?= esc($item['spesifikasi']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 border-b text-center text-gray-500">Barang tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
