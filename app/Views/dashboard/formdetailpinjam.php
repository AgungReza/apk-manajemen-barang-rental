<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Detail Transaksi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-6">Form Transaksi</h1>

            <!-- Notifikasi -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="p-4 mb-4 text-green-800 bg-green-200 rounded-lg" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="p-4 mb-4 text-red-800 bg-red-200 rounded-lg" role="alert">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="p-4 mb-4 text-yellow-800 bg-yellow-200 rounded-lg" role="alert">
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/transaksi/save" method="post">
                <?= csrf_field(); ?>

                <!-- Pencarian Customer -->
                <div class="mb-4">
                    <label for="customer_search" class="block text-sm font-medium text-gray-700">Nama Customer</label>
                    <div class="relative">
                        <input id="customer_search" name="customer_name" type="text" placeholder="Cari nama customer..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        <input type="hidden" id="customer_id" name="customer_id">
                        <div id="customer_suggestions" class="absolute bg-white border border-gray-300 rounded-lg shadow-md w-full hidden"></div>
                        <div id="no_customer_found" class="hidden mt-2">
                            <p class="text-sm text-gray-600">
                                Customer tidak ditemukan, 
                                <a href="/formcustomer" class="text-blue-600 hover:underline font-medium">klik di sini</a> untuk menambah customer baru.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tanggal Pinjam dan Tanggal Kembali -->
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700">Waktu Pinjam</label>
                        <input id="tanggal_pinjam" name="tanggal_pinjam" type="datetime-local" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="<?= date('Y-m-d\TH:i') ?>" />
                    </div>
                    <div>
                        <label for="tanggal_kembali" class="block text-sm font-medium text-gray-700">Waktu Kembali</label>
                        <input id="tanggal_kembali" name="tanggal_kembali" type="datetime-local" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    </div>
                </div>

                <!-- Pencarian Barang -->
                <div class="mb-4">
                    <label for="barang_search" class="block text-sm font-medium text-gray-700">Cari Barang</label>
                    <div class="relative">
                        <input id="barang_search" name="keyword" type="text" placeholder="Cari nama barang..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        <div id="barang_suggestions" class="absolute bg-white border border-gray-300 rounded-lg shadow-md w-full hidden"></div>
                    </div>
                </div>

                <!-- Daftar Barang -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Daftar Barang</label>
                    <div id="barang_list" class="p-4 border border-gray-300 rounded-lg bg-gray-50">
                        <p id="barang_placeholder" class="text-gray-600">Belum ada barang yang ditambahkan.</p>
                    </div>
                </div>


                <!-- Catatan -->
                <div class="mb-4">
                    <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                    <textarea id="catatan" name="catatan" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Tambahkan catatan..."></textarea>
                </div>

                <!-- Status Transaksi -->
                <div class="mb-4">
                    <label for="status_transaksi" class="block text-sm font-medium text-gray-700">Status Transaksi</label>
                    <select id="status_transaksi" name="status_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <?php foreach ($statusList as $status): ?>
                            <option value="<?= $status['id'] ?>"><?= $status['status_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Tombol Simpan -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
