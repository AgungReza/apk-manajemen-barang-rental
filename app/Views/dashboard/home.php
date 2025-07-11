<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Dashboard Home
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="flex-1 ml-[250px] mt-[50px] p-6">
    <!-- Kotak Statistik -->
    <div class="flex flex-wrap justify-between gap-4">
        <div class="flex-1 min-w-[200px] max-w-[300px] bg-white p-6 rounded-lg shadow text-center">
            <h2 class="text-3xl font-bold text-indigo-600"><?= esc($totalBarang) ?></h2>
            <p class="text-gray-500 mt-2">Jumlah Barang</p>
        </div>
        <div class="flex-1 min-w-[200px] max-w-[300px] bg-white p-6 rounded-lg shadow text-center">
            <h2 class="text-3xl font-bold text-indigo-600"><?= esc($totalCustomer) ?></h2>
            <p class="text-gray-500 mt-2">Jumlah Customer</p>
        </div>
        <div class="flex-1 min-w-[200px] max-w-[300px] bg-white p-6 rounded-lg shadow text-center">
            <h2 class="text-3xl font-bold text-indigo-600"><?= esc($totalTransaksi) ?></h2>
            <p class="text-gray-500 mt-2">Jumlah Transaksi</p>
        </div>
    </div>

    <!-- Bookingan dan Pengembalian -->
    <div class="flex flex-col md:flex-row gap-6 mt-8">
        <!-- Barang Bookingan -->
        <div class="flex-1 bg-white p-6 rounded-xl shadow">
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

        <!-- Barang Akan Dikembalikan -->
        <div class="flex-1 bg-white p-6 rounded-xl shadow">
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

    <!-- Aktivitas Terbaru (Dummy) -->
    <div class="bg-white rounded-xl shadow p-6 mt-8">
        <h2 class="text-xl font-semibold text-[#091F5B] mb-5 pb-4 border-b border-gray-100">Aktivitas Terbaru</h2>

        <!-- Dummy 1 -->
        <div class="flex mb-5 pb-5 border-b border-gray-100">
            <div class="w-10 h-10 flex items-center justify-center rounded-md bg-blue-100 text-blue-500 mr-4 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-grow">
                <div class="font-semibold text-gray-800 mb-1">Peminjaman baru</div>
                <div class="text-sm text-gray-500 leading-relaxed">Customer: Budi Santoso - Barang: Proyektor Epson</div>
                <div class="text-xs text-gray-400 mt-1">3 jam yang lalu</div>
            </div>
        </div>

        <!-- Dummy 2 -->
        <div class="flex mb-5 pb-5 border-b border-gray-100">
            <div class="w-10 h-10 flex items-center justify-center rounded-md bg-green-100 text-green-500 mr-4 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-grow">
                <div class="font-semibold text-gray-800 mb-1">Barang baru ditambahkan</div>
                <div class="text-sm text-gray-500 leading-relaxed">Kamera Canon EOS 90D telah ditambahkan ke inventaris</div>
                <div class="text-xs text-gray-400 mt-1">Kemarin, 14:30</div>
            </div>
        </div>

        <!-- Dummy 3 -->
        <div class="flex">
            <div class="w-10 h-10 flex items-center justify-center rounded-md bg-purple-100 text-purple-500 mr-4 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-grow">
                <div class="font-semibold text-gray-800 mb-1">Customer baru terdaftar</div>
                <div class="text-sm text-gray-500 leading-relaxed">Jaya Abadi telah terdaftar sebagai customer baru</div>
                <div class="text-xs text-gray-400 mt-1">2 hari yang lalu</div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>
