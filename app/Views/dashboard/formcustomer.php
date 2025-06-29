<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Form Pendaftaran Customer
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded-lg shadow-md border border-gray-200">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Form Pendaftaran Customer</h1>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/formcustomer/save') ?>" method="POST" class="space-y-6">
                <?= csrf_field() ?>

                <!-- Customer ID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Customer ID</label>
                        <input 
                            type="text" 
                            id="customer_id" 
                            name="customer_id" 
                            value="<?= $customer_id ?? '' ?>" 
                            readonly 
                            class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md"
                        >
                    </div>
                </div>

                <!-- Personal Information Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Customer -->
                    <div>
                        <label for="nama_customer" class="block text-sm font-medium text-gray-700 mb-1">Nama Customer</label>
                        <input 
                            type="text" 
                            id="nama_customer" 
                            name="nama_customer" 
                            value="<?= old('nama_customer') ?>" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                            required
                        >
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?= old('email') ?>" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                            required
                        >
                    </div>
                    
                    <!-- NIK/NIS/NIM -->
                    <div>
                        <label for="nik_nis_nim" class="block text-sm font-medium text-gray-700 mb-1">NIK/NIS/NIM</label>
                        <input 
                            type="text" 
                            id="nik_nis_nim" 
                            name="nik_nis_nim" 
                            value="<?= old('nik_nis_nim') ?>" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                            required
                        >
                    </div>
                    
                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea 
                            id="alamat" 
                            name="alamat" 
                            rows="2" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                            required
                        ><?= old('alamat') ?></textarea>
                    </div>
                    
                    <!-- Kelas -->
                    <!--<div>
                        <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <input 
                            type="text" 
                            id="kelas" 
                            name="kelas" 
                            value="<?= old('kelas') ?>" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                            required
                        >
                    </div>-->
                    
                    <!-- Jurusan -->
                   <!-- <div>
                        <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                        <input 
                            type="text" 
                            id="jurusan" 
                            name="jurusan" 
                            value="<?= old('jurusan') ?>" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                            required
                        >
                    </div>
                </div> -->

                <!-- Submit Button -->
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