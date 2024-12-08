<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Dashboard Home
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .banner-container {
        position: relative;
        height: 500px; 
        width: 100%;
        overflow: hidden; 
        border-radius: 8px; 
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); 
    }

    .banner-image {
        height: 100%; 
        width: 100%;
        object-fit: cover; 
    }

    .banner-text {
        position: absolute; 
        top: 50%; 
        left: 50%; 
        transform: translate(-50%, -50%); 
        color: white; 
        text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7); 
        text-align: center; 
    }

    .banner-text h1 {
        font-size: 50px; 
        margin: 0;
    }

    .banner-text p {
        font-size: 20px; 
        margin: 0;
    }
</style>

<main class="flex-1 ml-[250px] mt-[50px] p-6">
    <!-- Kotak Banner -->
    <div class="banner-container">
        <img src="/img/gSekolah.jpg" alt="Banner Gambar" class="banner-image">
        <div class="banner-text">
            <h1>Selamat Datang di Dashboard</h1>
            <p>Pantau barang bookingan dan pengembalian barang di sini.</p>
        </div>
    </div>

        <!-- Kotak Informasi -->
        <div class="flex flex-wrap justify-between gap-6 mt-10">
            <div class="flex-1 max-w-[300px] bg-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-3xl font-bold text-indigo-600"><?= esc($totalBarang) ?></h2>
                <p class="text-gray-500 mt-2">Jumlah Barang</p>
            </div>
            <div class="flex-1 max-w-[300px] bg-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-3xl font-bold text-indigo-600"><?= esc($totalCustomer) ?></h2>
                <p class="text-gray-500 mt-2">Jumlah Customer</p>
            </div>
            <div class="flex-1 max-w-[300px] bg-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-3xl font-bold text-indigo-600"><?= esc($totalTransaksi) ?></h2>
                <p class="text-gray-500 mt-2">Jumlah Transaksi</p>
            </div>
        </div>

    <div class="flex flex-col md:flex-row gap-6 mt-10">
        <!-- Kotak Kiri: Barang Bookingan -->
        <div class="flex-1 bg-white p-6 rounded shadow-md">
            <h1 class="text-xl font-bold mb-4 text-indigo-600">Barang Bookingan</h1>
            <div class="overflow-y-auto max-h-[300px]">
                <?php if (!empty($bookingToday)): ?>
                    <div class="grid grid-cols-1 gap-4">
                        <?php foreach ($bookingToday as $booking): ?>
                            <a href="/transaksi/form/<?= esc($booking['transaksi_id']) ?>" class="block p-4 bg-gray-100 rounded shadow flex justify-between hover:bg-gray-200 transition duration-200">
                                <span><?= esc($booking['nama_customer']) ?></span>
                                <span class="font-bold"><?= esc($booking['jam_keluar']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 italic">Tidak ada barang bookingan untuk hari ini.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Kotak Kanan: Barang Akan Dikembalikan -->
        <div class="flex-1 bg-white p-6 rounded shadow-md">
            <h1 class="text-xl font-bold mb-4 text-green-600">Barang Akan Dikembalikan</h1>
            <div class="overflow-y-auto max-h-[300px]">
                <?php if (!empty($returningToday)): ?>
                    <div class="grid grid-cols-1 gap-4">
                        <?php foreach ($returningToday as $return): ?>
                            <a href="/transaksi/form/<?= esc($return['transaksi_id']) ?>" class="block p-4 bg-gray-100 rounded shadow flex justify-between hover:bg-gray-200 transition duration-200">
                                <span><?= esc($return['nama_customer']) ?></span>
                                <span class="font-bold"><?= esc($return['jam_kembali']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 italic">Tidak ada barang yang akan dikembalikan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>
