<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Dashboard Home
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="flex-1 ml-[250px] mt-[50px] p-6">
    <div class="flex flex-col md:flex-row gap-6">
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

        <!-- Kotak Kanan: Barang yang Akan Kembali -->
        <div class="flex-1 bg-white p-6 rounded shadow-md">
            <h1 class="text-xl font-bold mb-4 text-green-600">Barang Akan Kembali</h1>
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
                    <p class="text-gray-500 italic">Tidak ada barang yang kembali hari ini.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>
