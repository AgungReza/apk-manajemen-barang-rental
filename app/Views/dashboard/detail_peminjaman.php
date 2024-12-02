<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Detail Peminjaman
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-6">Detail Peminjaman</h1>
            <table class="min-w-full bg-white border border-gray-300">
                <tr>
                    <th class="px-4 py-2 border">Nama Peminjam</th>
                    <td class="px-4 py-2 border"><?= esc($detail['nama_customer']) ?></td>
                </tr>
                <tr>
                    <th class="px-4 py-2 border">ID Barang</th>
                    <td class="px-4 py-2 border"><?= esc($detail['barang_id']) ?></td>
                </tr>
                <tr>
                    <th class="px-4 py-2 border">Nama Barang</th>
                    <td class="px-4 py-2 border"><?= esc($detail['nama_barang']) ?></td>
                </tr>
                <tr>
                    <th class="px-4 py-2 border">Tanggal Keluar</th>
                    <td class="px-4 py-2 border"><?= esc($detail['tanggal_keluar']) ?></td>
                </tr>
                <tr>
                    <th class="px-4 py-2 border">Tanggal Kembali</th>
                    <td class="px-4 py-2 border"><?= esc($detail['tanggal_kembali']) ?></td>
                </tr>
            </table>
            <a href="/peminjaman/log" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                Kembali ke Log Peminjaman
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
