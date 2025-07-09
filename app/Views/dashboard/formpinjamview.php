<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
<?= isset($transaksi) ? 'Edit Transaksi' : 'Form Transaksi' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-6"><?= isset($transaksi) ? 'Edit Transaksi' : 'Form Transaksi' ?></h1>

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

            <!-- Form -->
            <form action="/transaksi/update" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="transaksi_id" value="<?= $transaksi['transaksi_id'] ?>">

                <!-- Customer -->
                <div class="mb-4 relative">
                    <label for="customer_search" class="block text-sm font-medium text-gray-700">Nama Customer</label>
                    <input id="customer_search" name="customer_name" value="<?= esc($customer['nama_customer']) ?>" class="block w-full rounded-md border-gray-300 shadow-sm" placeholder="Cari customer...">
                    <input type="hidden" id="customer_id" name="customer_id" value="<?= esc($transaksi['customer_id']) ?>">
                    <div id="customer_suggestions" class="absolute bg-white border rounded shadow-md hidden max-h-40 overflow-y-auto z-10"></div>
                    <div id="no_customer_found" class="hidden mt-2 text-sm text-gray-600">
                        Customer tidak ditemukan, <a href="/formcustomer" class="text-blue-600 hover:underline">klik di sini</a> untuk menambah customer.
                    </div>
                </div>

                <!-- Waktu Pinjam & Kembali -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="tanggal_pinjam">Waktu Pinjam</label>
                        <input id="tanggal_pinjam" name="tanggal_pinjam" type="datetime-local" class="block w-full rounded-md border-gray-300 shadow-sm"
                            value="<?= date('Y-m-d\TH:i', strtotime($transaksi['tanggal_keluar'] . ' ' . $transaksi['jam_keluar'])) ?>">
                    </div>
                    <div>
                        <label for="tanggal_kembali">Waktu Kembali</label>
                        <input id="tanggal_kembali" name="tanggal_kembali" type="datetime-local" class="block w-full rounded-md border-gray-300 shadow-sm"
                            value="<?= date('Y-m-d\TH:i', strtotime($transaksi['tanggal_kembali'] . ' ' . $transaksi['jam_kembali'])) ?>">
                    </div>
                </div>

                <!-- Barang -->
                <div class="mb-4 relative">
                    <label for="barang_search" class="block text-sm font-medium text-gray-700">Cari Barang</label>
                    <input id="barang_search" name="keyword" class="block w-full rounded-md border-gray-300 shadow-sm" placeholder="Cari barang...">
                    <div id="barang_suggestions" class="absolute bg-white border rounded shadow-md hidden max-h-40 overflow-y-auto z-10"></div>
                </div>

                <!-- Daftar Barang -->
                <div id="barang_list" class="p-4 border rounded mb-4 bg-gray-50">
                    <p id="barang_placeholder" class="text-gray-600 <?= count($detailBarang) > 0 ? 'hidden' : '' ?>">Belum ada barang ditambahkan.</p>
                    <?php foreach ($detailBarang as $barang): ?>
                        <div class="flex justify-between items-center border-b p-2">
                            <span><?= esc($barang['barang_id']) ?> - <?= esc($barang['nama_barang']) ?> - Rp<?= number_format($barang['harga'], 0, ',', '.') ?></span>
                            <input type="hidden" name="barang_id[]" value="<?= esc($barang['barang_id']) ?>">
                            <input type="hidden" name="barang_harga[]" value="<?= esc($barang['harga']) ?>">
                            <button type="button" class="text-red-500 font-bold" onclick="removeBarang(this)">x</button>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Durasi Sewa -->
                <div class="mb-4">
                    <label for="durasi_sewa_display">Durasi Sewa</label>
                    <input id="durasi_sewa_display" type="text" class="block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly value="<?= $transaksi['durasi_sewa'] ?> hari">
                    <input type="hidden" name="durasi_sewa" id="durasi_sewa" value="<?= $transaksi['durasi_sewa'] ?>">
                </div>

                <!-- Diskon -->
                <div class="mb-4">
                    <label for="diskon">Diskon (%)</label>
                    <input type="number" name="diskon" id="diskon" min="0" max="100" class="block w-full rounded-md border-gray-300 shadow-sm" value="<?= $transaksi['diskon'] ?>">
                </div>

                <!-- Total Harga -->
                <div class="mb-4">
                    <label for="total_harga_display">Total Harga</label>
                    <input id="total_harga_display" type="text" class="block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 font-bold text-indigo-700" readonly value="Rp<?= number_format($transaksi['total_harga'], 0, ',', '.') ?>">
                    <input type="hidden" name="total_harga" id="total_harga" value="<?= $transaksi['total_harga'] ?>">
                </div>

                <!-- Catatan -->
                <div class="mb-4">
                    <label for="catatan">Catatan</label>
                    <textarea name="catatan" id="catatan" class="block w-full rounded-md border-gray-300 shadow-sm"><?= esc($transaksi['catatan']) ?></textarea>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status_transaksi">Status</label>
                    <select name="status_id" id="status_transaksi" class="block w-full rounded-md border-gray-300 shadow-sm">
                        <?php foreach ($statusList as $status): ?>
                            <option value="<?= $status['id'] ?>" <?= $transaksi['status_transaksi'] == $status['id'] ? 'selected' : '' ?>>
                                <?= esc($status['status_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Tombol Simpan -->
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

<script>
const barangList = document.getElementById('barang_list');
const barangPlaceholder = document.getElementById('barang_placeholder');

// Customer search
document.getElementById('customer_search').addEventListener('input', function () {
    const keyword = this.value.trim();
    const suggestions = document.getElementById('customer_suggestions');
    const notFound = document.getElementById('no_customer_found');

    if (!keyword) {
        suggestions.innerHTML = '';
        suggestions.classList.add('hidden');
        notFound.classList.add('hidden');
        return;
    }

    fetch('/customer/search', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify({ keyword })
    }).then(res => res.json()).then(data => {
        suggestions.innerHTML = '';
        suggestions.classList.remove('hidden');
        notFound.classList.add('hidden');
        if (data.length > 0) {
            data.forEach(customer => {
                const item = document.createElement('div');
                item.textContent = customer.nama_customer;
                item.classList.add('p-2', 'hover:bg-gray-100', 'cursor-pointer');
                item.onclick = () => {
                    document.getElementById('customer_search').value = customer.nama_customer;
                    document.getElementById('customer_id').value = customer.customer_id;
                    suggestions.classList.add('hidden');
                };
                suggestions.appendChild(item);
            });
        } else {
            suggestions.classList.add('hidden');
            notFound.classList.remove('hidden');
        }
    });
});

// Barang search
document.getElementById('barang_search').addEventListener('input', function () {
    const keyword = this.value.trim();
    const suggestions = document.getElementById('barang_suggestions');
    if (!keyword) {
        suggestions.innerHTML = '';
        suggestions.classList.add('hidden');
        return;
    }

    fetch('/barang/search', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify({ keyword })
    }).then(res => res.json()).then(data => {
        suggestions.innerHTML = '';
        suggestions.classList.remove('hidden');
        if (data.length > 0) {
            data.forEach(barang => {
                const item = document.createElement('div');
                item.innerHTML = `<span>ID: ${barang.barang_id} - ${barang.nama_barang} - Rp${barang.harga.toLocaleString('id-ID')}</span>`;
                item.classList.add('p-2', 'hover:bg-gray-100', 'cursor-pointer');
                item.onclick = () => {
                    addBarang(barang.barang_id, barang.nama_barang, barang.harga);
                    suggestions.classList.add('hidden');
                    document.getElementById('barang_search').value = '';
                };
                suggestions.appendChild(item);
            });
        } else {
            suggestions.innerHTML = `<div class="p-2 text-gray-500">Barang tidak ditemukan.</div>`;
        }
    });
});

function addBarang(id, nama, harga) {
    const exists = [...document.querySelectorAll('input[name="barang_id[]"]')].some(i => i.value === id);
    if (exists) {
        alert('Barang sudah ditambahkan.');
        return;
    }

    barangPlaceholder.classList.add('hidden');
    const item = document.createElement('div');
    item.classList.add('p-2', 'flex', 'justify-between', 'items-center', 'border-b');
    item.innerHTML = `
        <span>ID: ${id} - ${nama} - Rp${harga.toLocaleString('id-ID')}</span>
        <button class="text-red-500 font-bold" onclick="removeBarang(this)">x</button>
        <input type="hidden" name="barang_id[]" value="${id}">
        <input type="hidden" name="barang_harga[]" value="${harga}">
    `;
    barangList.appendChild(item);
    updateTotalHarga();
}

function removeBarang(button) {
    button.parentElement.remove();
    if (barangList.querySelectorAll('input[name="barang_id[]"]').length === 0) {
        barangPlaceholder.classList.remove('hidden');
    }
    updateTotalHarga();
}

document.getElementById('tanggal_pinjam').addEventListener('change', updateTotalHarga);
document.getElementById('tanggal_kembali').addEventListener('change', updateTotalHarga);
document.getElementById('diskon').addEventListener('input', updateTotalHarga);

function updateTotalHarga() {
    const hargaInputs = document.querySelectorAll('input[name="barang_harga[]"]');
    const start = new Date(document.getElementById('tanggal_pinjam').value);
    const end = new Date(document.getElementById('tanggal_kembali').value);
    let durasi = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
    if (isNaN(durasi) || durasi < 1) durasi = 1;

    let total = 0;
    hargaInputs.forEach(input => {
        total += parseInt(input.value) * durasi;
    });

    const diskon = parseInt(document.getElementById('diskon').value) || 0;
    const diskonNominal = Math.floor(total * diskon / 100);
    const totalAkhir = total - diskonNominal;

    document.getElementById('durasi_sewa_display').value = durasi + ' hari';
    document.getElementById('durasi_sewa').value = durasi;
    document.getElementById('total_harga_display').value = 'Rp' + totalAkhir.toLocaleString('id-ID');
    document.getElementById('total_harga').value = totalAkhir;
}
</script>

<?= $this->endSection() ?>
