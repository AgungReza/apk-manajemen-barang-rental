<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Form Pendaftaran Customer
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-6">Form Pendaftaran Customer</h1>

            <!-- Notifikasi Error -->
            <?php if (session()->get('errors')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        <?php foreach (session()->get('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Notifikasi Sukses -->
            <?php if (session()->get('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <?= session()->get('success') ?>
                </div>
            <?php endif; ?>

            <form action="/formcustomer/save" method="POST">
                <?= csrf_field(); ?>

                <!-- Customer ID -->
                <div class="mb-4">
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer ID</label>
                    <input 
                        type="text" 
                        id="customer_id" 
                        name="customer_id" 
                        value="<?= $customer_id ?>" 
                        readonly 
                        class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                </div>

                <!-- Nama Customer -->
                <div class="mb-4">
                    <label for="nama_customer" class="block text-sm font-medium text-gray-700">Nama Customer</label>
                    <input 
                        type="text" 
                        id="nama_customer" 
                        name="nama_customer" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                        required
                    >
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                        required
                    >
                </div>

                <!-- NIK/NIS/NIM -->
                <div class="mb-4">
                    <label for="nik_nis_nim" class="block text-sm font-medium text-gray-700">NIK/NIS/NIM</label>
                    <input 
                        type="text" 
                        id="nik_nis_nim" 
                        name="nik_nis_nim" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                        required
                    >
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea 
                        id="alamat" 
                        name="alamat" 
                        rows="3" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                        required
                    ></textarea>
                </div>

                <!-- Kelas -->
                <div class="mb-4">
                    <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                    <input 
                        type="text" 
                        id="kelas" 
                        name="kelas" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                        required
                    >
                </div>

                <!-- Jurusan -->
                <div class="mb-4">
                    <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
                    <input 
                        type="text" 
                        id="jurusan" 
                        name="jurusan" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                        required
                    >
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button 
                        type="submit" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
