<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Daftar Barang
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-6">Daftar Barang</h1>

            <!-- Form Pencarian dan Tombol Tambah Barang -->
            <div class="flex items-center justify-between mb-4">
                <form action="/barang/search" method="get" class="flex flex-1">
                    <input type="text" name="q" placeholder="Cari barang..." 
                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2"
                        value="<?= isset($q) ? $q : '' ?>">
                    <button type="submit" class="ml-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Cari</button>
                </form>

                <a href="/barang/add" class="ml-4 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Tambah Barang
                </a>
            </div>

            <!-- Tabel Data Barang -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">ID Barang</th>
                            <th class="px-4 py-2 border">Nama Barang</th>
                            <th class="px-4 py-2 border">Jumlah</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($barang) && is_array($barang)): ?>
                            <?php foreach ($barang as $item): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border"><?= $item['barang_id'] ?></td>
                                    <td class="px-4 py-2 border"><?= $item['nama_barang'] ?></td>
                                    <td class="px-4 py-2 border"><?= $item['jumlah_stok'] ?></td>
                                    <td class="px-4 py-2 border">
                                        <a href="/barang/edit/<?= $item['barang_id'] ?>" class="text-blue-600 hover:underline">Edit</a> |
                                        <a href="/barang/delete/<?= $item['barang_id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center px-4 py-2 border">Data barang tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
