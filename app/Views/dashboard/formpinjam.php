<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Form Transaksi
<?= isset($transaksi) ? 'Edit Transaksi' : 'Form Transaksi' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded shadow-md relative z-10">
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
            <form action="<?= isset($transaksi) ? '/transaksi/update' : '/transaksi/save' ?>" method="post">
                <?= csrf_field(); ?>
                <?php if (isset($transaksi)): ?>
                    <input type="hidden" name="transaksi_id" value="<?= $transaksi['transaksi_id'] ?>">
                <?php endif; ?>

                <!-- Pencarian Customer -->
                <div class="mb-4 relative z-20">
                    <label for="customer_search" class="block text-sm font-medium text-gray-700">Nama Customer</label>
                    <input id="customer_search" name="customer_name" value="<?= isset($customer) ? esc($customer['nama_customer']) : '' ?>" placeholder="Cari nama customer..." class="block w-full rounded-md border-gray-300 shadow-sm" />
                    <input type="hidden" id="customer_id" name="customer_id" value="<?= isset($transaksi) ? $transaksi['customer_id'] : '' ?>">
                    <div id="customer_suggestions" class="absolute bg-white border rounded shadow-md hidden max-h-40 overflow-y-auto z-10 w-full"></div>
                    <div id="no_customer_found" class="hidden mt-2">
                        <p class="text-sm text-gray-600">
                            Customer tidak ditemukan, 
                            <a href="/formcustomer" class="text-blue-600 hover:underline font-medium">klik di sini</a> untuk menambah customer baru.
                        </p>
                    </div>
                </div>

                <!-- Waktu Pinjam & Kembali -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="tanggal_pinjam">Waktu Pinjam</label>
                        <input id="tanggal_pinjam" name="tanggal_pinjam" type="datetime-local" class="block w-full rounded-md border-gray-300 shadow-sm" value="<?= isset($transaksi) ? date('Y-m-d\TH:i', strtotime($transaksi['tanggal_keluar'] . ' ' . $transaksi['jam_keluar'])) : '' ?>" />
                    </div>
                    <div>
                        <label for="tanggal_kembali">Waktu Kembali</label>
                        <input id="tanggal_kembali" name="tanggal_kembali" type="datetime-local" class="block w-full rounded-md border-gray-300 shadow-sm" value="<?= isset($transaksi) ? date('Y-m-d\TH:i', strtotime($transaksi['tanggal_kembali'] . ' ' . $transaksi['jam_kembali'])) : '' ?>" />
                    </div>
                </div>

                <!-- Pencarian Barang -->
                <div class="mb-4 relative z-20">
                    <label for="barang_search" class="block text-sm font-medium text-gray-700">Cari Barang</label>
                    <input id="barang_search" name="keyword" placeholder="Cari barang..." class="block w-full rounded-md border-gray-300 shadow-sm" />
                    <div id="barang_suggestions" class="absolute bg-white border rounded shadow-md hidden max-h-40 overflow-y-auto z-10 w-full"></div>
                </div>

                <!-- List Barang -->
                <div id="barang_list" class="p-4 border rounded mb-4">
                    <p id="barang_placeholder" class="text-gray-600 <?= isset($detailBarang) && count($detailBarang) > 0 ? 'hidden' : '' ?>">Belum ada barang yang dipinjam.</p>
                    <?php if (isset($detailBarang) && count($detailBarang) > 0): ?>
                        <?php foreach ($detailBarang as $barang): ?>
                            <div class="flex justify-between items-center border-b p-2">
                                <span><?= esc($barang['barang_id']) ?> - <?= esc($barang['nama_barang']) ?> (Jumlah: <?= esc($barang['jumlah']) ?>)</span>
                                <input type="hidden" name="barang_id[]" value="<?= esc($barang['barang_id']) ?>">
                                <input type="hidden" name="jumlah[]" value="<?= esc($barang['jumlah']) ?>">
                                <button type="button" class="text-red-500 font-bold" onclick="removeBarang(this)">x</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Catatan -->
                <div class="mb-4">
                    <label for="catatan">Catatan</label>
                    <textarea name="catatan" id="catatan" class="block w-full rounded-md border-gray-300 shadow-sm"><?= isset($transaksi) ? esc($transaksi['catatan']) : '' ?></textarea>
                </div>

                <!-- Status -->
                <div class="mb-4 relative z-20">
                    <label for="status_transaksi">Status Transaksi</label>
                    <select name="status_id" id="status_transaksi" class="block w-full rounded-md border-gray-300 shadow-sm">
                        <?php if (isset($statusList) && is_array($statusList)): ?>
                            <?php foreach ($statusList as $status): ?>
                                <option value="<?= $status['id'] ?>" <?= isset($transaksi) && $transaksi['status_transaksi'] == $status['id'] ? 'selected' : '' ?>>
                                    <?= esc($status['status_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option disabled selected>Tidak ada data status</option>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Tombol Simpan -->
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan Transaksi</button>
            </form>
        </div>
    </div>
</div>

<script>
// === AUTOCOMPLETE CUSTOMER ===
const customerSearch = document.getElementById('customer_search');
const customerSuggestions = document.getElementById('customer_suggestions');
const noCustomerFound = document.getElementById('no_customer_found');

customerSearch.addEventListener('input', function () {
    const keyword = this.value;
    if (keyword.trim() === '') {
        customerSuggestions.innerHTML = '';
        customerSuggestions.classList.add('hidden');
        noCustomerFound.classList.add('hidden');
        return;
    }

    fetch('/customer/search', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ keyword }),
    })
        .then(response => response.json())
        .then(data => {
            customerSuggestions.innerHTML = '';
            customerSuggestions.classList.remove('hidden');
            noCustomerFound.classList.add('hidden');

            if (data.length > 0) {
                data.forEach(customer => {
                    const item = document.createElement('div');
                    item.textContent = customer.nama_customer;
                    item.classList.add('p-2', 'hover:bg-gray-100', 'cursor-pointer');
                    item.addEventListener('click', () => {
                        customerSearch.value = customer.nama_customer;
                        document.getElementById('customer_id').value = customer.customer_id;
                        customerSuggestions.classList.add('hidden');
                        noCustomerFound.classList.add('hidden');
                    });
                    customerSuggestions.appendChild(item);
                });
            } else {
                customerSuggestions.classList.add('hidden');
                noCustomerFound.classList.remove('hidden');
            }
        });
});

// === AUTOCOMPLETE BARANG ===
const barangSearch = document.getElementById('barang_search');
const barangSuggestions = document.getElementById('barang_suggestions');
const barangList = document.getElementById('barang_list');
const barangPlaceholder = document.getElementById('barang_placeholder');

barangSearch.addEventListener('input', function () {
    const keyword = this.value.trim();
    if (keyword === '') {
        barangSuggestions.innerHTML = '';
        barangSuggestions.classList.add('hidden');
        return;
    }

    fetch('/barang/search', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ keyword }),
    })
        .then(response => response.json())
        .then(data => {
            barangSuggestions.innerHTML = '';
            barangSuggestions.classList.remove('hidden');

            if (data.length > 0) {
                data.forEach(barang => {
                    const item = document.createElement('div');
                    item.classList.add('p-2', 'hover:bg-gray-100', 'cursor-pointer', 'flex', 'justify-between');
                    item.innerHTML = `<span>ID: ${barang.barang_id} - ${barang.nama_barang}</span>`;
                    item.addEventListener('click', () => {
                        addBarang(barang.barang_id, barang.nama_barang);
                        barangSuggestions.classList.add('hidden');
                        barangSearch.value = '';
                    });
                    barangSuggestions.appendChild(item);
                });
            } else {
                barangSuggestions.innerHTML = `<div class="p-2 text-gray-500">Barang tidak ditemukan.</div>`;
            }
        })
        .catch(err => console.error('Error fetching barang:', err));
});

function addBarang(id, nama) {
    const existingItems = barangList.querySelectorAll('input[name="barang_id[]"]');
    for (let item of existingItems) {
        if (item.value === id) {
            alert('Barang sudah ditambahkan.');
            return;
        }
    }

    barangPlaceholder.classList.add('hidden');

    const newItem = document.createElement('div');
    newItem.classList.add('p-2', 'flex', 'justify-between', 'items-center', 'border-b');
    newItem.innerHTML = `
        <span>ID: ${id} - ${nama}</span>
        <button class="text-red-500 font-bold" onclick="removeBarang(this)">x</button>
        <input type="hidden" name="barang_id[]" value="${id}">
    `;

    barangList.appendChild(newItem);
}

function removeBarang(button) {
    button.parentElement.remove();
    if (barangList.querySelectorAll('.border-b').length === 0) {
        barangPlaceholder.classList.remove('hidden');
    }
}
</script>

<?= $this->endSection() ?>
