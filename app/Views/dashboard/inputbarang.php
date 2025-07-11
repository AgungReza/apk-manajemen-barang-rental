<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Form Input Barang
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-6">Form Input Barang</h1>
            <form action="/barang/save" method="post">
                <?= csrf_field(); ?>

                <!-- ID Barang (readonly) -->
                <div class="mb-4">
                    <label for="barang_id" class="block text-sm font-medium text-gray-700">ID Barang</label>
                    <input type="text" id="barang_id" name="barang_id" value="<?= esc($barang_id) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 text-gray-600 cursor-not-allowed sm:text-sm" readonly>
                </div>

                <!-- Nama Barang -->
                <div class="mb-4">
                    <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>

                <!-- Merk -->
                <div class="mb-4">
                    <label for="merek" class="block text-sm font-medium text-gray-700">Merk</label>
                    <input type="text" id="merek" name="merek" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <!-- Spesifikasi -->
                <div class="mb-4">
                    <label for="spesifikasi" class="block text-sm font-medium text-gray-700">Spesifikasi</label>
                    <textarea id="spesifikasi" name="spesifikasi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>

                <!-- Harga -->
                <div class="mb-4">
                    <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                    <input type="number" id="harga" name="harga" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <p class="text-xs text-gray-500 mt-1">Masukkan angka tanpa titik atau koma, contoh: 100000</p>
                </div>


                <!-- Kondisi -->
                <div class="mb-4">
                    <label for="kondisi" class="block text-sm font-medium text-gray-700">Kondisi</label>
                    <input type="text" id="kondisi" name="kondisi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <!-- Catatan -->
                <div class="mb-4">
                    <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                    <textarea id="catatan" name="catatan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
