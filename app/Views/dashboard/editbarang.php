<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Edit Barang
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-6">Edit Barang</h1>
            <form action="/barang/update" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="barang_id" value="<?= $barang['barang_id'] ?>">

                <!-- Nama Barang -->
                <div class="mb-4">
                    <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="<?= $barang['nama_barang'] ?>" required>
                </div>

                <!-- Jenis Barang -->
                <div class="mb-4">
                    <label for="kategori_alat" class="block text-sm font-medium text-gray-700">Jenis Barang</label>
                    <select id="kategori_alat" name="kategori_alat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <option value="habis_pakai" <?= $barang['kategori_alat'] == 'habis_pakai' ? 'selected' : '' ?>>Habis Pakai</option>
                        <option value="tidak_habis_pakai" <?= $barang['kategori_alat'] == 'tidak_habis_pakai' ? 'selected' : '' ?>>Tidak Habis Pakai</option>
                    </select>
                </div>

                <!-- Merk -->
                <div class="mb-4">
                    <label for="merek" class="block text-sm font-medium text-gray-700">Merk</label>
                    <input type="text" id="merek" name="merek" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="<?= $barang['merek'] ?>">
                </div>

                <!-- Spesifikasi -->
                <div class="mb-4">
                    <label for="spesifikasi" class="block text-sm font-medium text-gray-700">Spesifikasi</label>
                    <textarea id="spesifikasi" name="spesifikasi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"><?= $barang['spesifikasi'] ?></textarea>
                </div>

                <!-- Jumlah Stok -->
                <div class="mb-4">
                    <label for="jumlah_stok" class="block text-sm font-medium text-gray-700">Jumlah Stok</label>
                    <input type="number" id="jumlah_stok" name="jumlah_stok" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="<?= $barang['jumlah_stok'] ?>" required>
                </div>
                <!-- Tahun Pengadaan -->
                <div class="mb-4">
                    <label for="jumlah_stok" class="block text-sm font-medium text-gray-700">Tahun Pengadaan</label>
                    <input type="number" id="tahun_pengadaan" name="tahun_pengadaan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="<?= $barang['tahun_pengadaan'] ?>" required>
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>