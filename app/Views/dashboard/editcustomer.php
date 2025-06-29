<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Edit Customer
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-6">Edit Customer</h1>
            <form action="/editcustomer/<?= esc($customer['customer_id']) ?>" method="post">
                <?= csrf_field(); ?>

                <!-- Nama Customer -->
                <div class="mb-4">
                    <label for="nama_customer" class="block text-sm font-medium text-gray-700">Nama Customer</label>
                    <input type="text" id="nama_customer" name="nama_customer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="<?= esc($customer['nama_customer']) ?>" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="<?= isset($customer['email']) ? esc($customer['email']) : '' ?>" required>
                </div>

                <!-- NIS -->
                <div class="mb-4">
                    <label for="nik_nis_nim" class="block text-sm font-medium text-gray-700">Nomor Induk Siswa</label>
                    <input type="text" id="nik_nis_nim" name="nik_nis_nim" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="<?= isset($customer['nik_nis_nim']) ? esc($customer['nik_nis_nim']) : '' ?>" required>
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"><?= isset($customer['alamat']) ? esc($customer['alamat']) : '' ?></textarea>
                </div>

                <!-- Kelas -->
                <div class="mb-4">
                    <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                    <input type="text" id="kelas" name="kelas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="<?= isset($customer['kelas']) ? esc($customer['kelas']) : '' ?>" required>
                </div>

                <!-- Jurusan -->
                <div class="mb-4">
                    <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
                    <input type="text" id="jurusan" name="jurusan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="<?= isset($customer['jurusan']) ? esc($customer['jurusan']) : '' ?>" required>
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