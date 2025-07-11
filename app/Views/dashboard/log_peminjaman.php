<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Log Peminjaman
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-6">Log Peminjaman</h1>

            <form action="/peminjaman/log" method="get" class="mb-6">
                <div class="flex flex-wrap gap-4">
                    <input type="text" name="search" placeholder="Cari nama pengguna..." class="flex-1 rounded-md border-gray-300 shadow-sm p-2" value="<?= esc($search ?? '') ?>">
                    <div class="flex items-center gap-2">
                        <label for="tanggal" class="text-sm font-medium">Tanggal:</label>
                        <input type="date" id="tanggal" name="tanggal" class="rounded-md border-gray-300 shadow-sm p-2" value="<?= esc($tanggal ?? '') ?>">
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Cari</button>
                    <a href="/peminjaman/export" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Cetak Excel
                    </a>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">ID Transaksi</th>
                            <th class="px-4 py-2 border">Nama Customer</th>
                            <th class="px-4 py-2 border">Tanggal Pinjam</th>
                            <th class="px-4 py-2 border">Tanggal Kembali</th>
                            <th class="px-4 py-2 border">Status Transaksi</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($peminjaman)): ?>
                            <?php foreach ($peminjaman as $item): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border"><?= esc($item['transaksi_id']) ?></td>
                                    <td class="px-4 py-2 border"><?= esc($item['nama_customer']) ?></td>
                                    <td class="px-4 py-2 border"><?= esc($item['tanggal_pinjam']) ?></td>
                                    <td class="px-4 py-2 border"><?= esc($item['tanggal_kembali']) ?></td>
                                    <td class="px-4 py-2 border"><?= esc($item['status_transaksi']) ?></td>
                                    <td class="px-4 py-2 border">
                                        <a href="/transaksi/form/<?= $item['transaksi_id'] ?>" class="text-blue-600 hover:underline">Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center px-4 py-2 border">Data peminjaman tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
