<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Form Transaksi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-6">Form Transaksi</h1>

            <!-- Notifikasi -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="p-4 mb-4 text-green-800 bg-green-200 rounded-lg"><?= session()->getFlashdata('success'); ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="p-4 mb-4 text-red-800 bg-red-200 rounded-lg"><?= session()->getFlashdata('error'); ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="p-4 mb-4 text-yellow-800 bg-yellow-200 rounded-lg">
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/transaksi/save" method="post">
                <?= csrf_field(); ?>

                <!-- Customer -->
                <div class="mb-4">
                    <label for="customer_search" class="block text-sm font-medium text-gray-700">Nama Customer</label>
                    <div class="relative">
                        <input id="customer_search" name="customer_name" type="text" placeholder="Cari nama customer..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        <input type="hidden" id="customer_id" name="customer_id">
                        <div id="customer_suggestions" class="absolute bg-white border border-gray-300 rounded-lg shadow-md w-full hidden"></div>
                        <div id="no_customer_found" class="hidden mt-2">
                            <p class="text-sm text-gray-600">Customer tidak ditemukan, <a href="/formcustomer" class="text-blue-600 hover:underline">klik di sini</a> untuk menambah customer baru.</p>
                        </div>
                    </div>
                </div>

                <!-- Tanggal -->
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700">Waktu Pinjam</label>
                        <input id="tanggal_pinjam" name="tanggal_pinjam" type="datetime-local" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="<?= date('Y-m-d\TH:i') ?>" />
                    </div>
                    <div>
                        <label for="tanggal_kembali" class="block text-sm font-medium text-gray-700">Waktu Kembali</label>
                        <input id="tanggal_kembali" name="tanggal_kembali" type="datetime-local" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    </div>
                </div>

                <!-- Barang -->
                <div class="mb-4">
                    <label for="barang_search" class="block text-sm font-medium text-gray-700">Cari Barang</label>
                    <div class="relative">
                        <input id="barang_search" name="keyword" type="text" placeholder="Cari nama barang..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
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

                <!-- Durasi Sewa -->
                <div class="mb-4">
                    <label for="durasi_sewa" class="block text-sm font-medium text-gray-700">Durasi Sewa</label>
                    <input id="durasi_sewa_display" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" value="1 hari" readonly>
                    <input type="hidden" id="durasi_sewa" name="durasi_sewa" value="1">
                </div>

                <!-- Diskon -->
                <div class="mb-4">
                    <label for="diskon" class="block text-sm font-medium text-gray-700">Diskon (%)</label>
                    <input id="diskon" name="diskon" type="number" min="0" max="100" value="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>

                <!-- Total Harga -->
                <div id="total_harga_section" class="mb-4 hidden">
                    <label class="block text-sm font-medium text-gray-700">Total Harga</label>
                    <p id="total_harga_display" class="text-lg font-bold text-indigo-700">Rp0</p>
                    <input type="hidden" id="total_harga" name="total_harga" value="0">
                </div>

                <!-- Catatan -->
                <div class="mb-4">
                    <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                    <textarea id="catatan" name="catatan" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Tambahkan catatan..."></textarea>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status_transaksi" class="block text-sm font-medium text-gray-700">Status Transaksi</label>
                    <select id="status_transaksi" name="status_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <?php foreach ($statusList as $status): ?>
                            <option value="<?= $status['id'] ?>"><?= $status['status_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end">
                    <button type="button" id="submit_button" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('tanggal_pinjam').addEventListener('change', updateTotalHarga);
document.getElementById('tanggal_kembali').addEventListener('change', updateTotalHarga);
document.getElementById('diskon').addEventListener('input', updateTotalHarga);
let groupedBarangData = [];

const customerSearch = document.getElementById('customer_search');
const customerSuggestions = document.getElementById('customer_suggestions');
const noCustomerFound = document.getElementById('no_customer_found');
customerSearch.addEventListener('input', function () {
    const keyword = this.value.trim();
    if (!keyword) {
        customerSuggestions.innerHTML = '';
        customerSuggestions.classList.add('hidden');
        noCustomerFound.classList.add('hidden');
        return;
    }
    fetch('/customer/search', {
        method: 'POST',
        headers: {'Content-Type': 'application/json','X-Requested-With': 'XMLHttpRequest'},
        body: JSON.stringify({ keyword })
    })
    .then(res => res.json())
    .then(data => {
        customerSuggestions.innerHTML = '';
        customerSuggestions.classList.remove('hidden');
        noCustomerFound.classList.add('hidden');
        if (data.length > 0) {
            data.forEach(customer => {
                const item = document.createElement('div');
                item.textContent = customer.nama_customer;
                item.classList.add('p-2', 'hover:bg-gray-100', 'cursor-pointer');
                item.onclick = () => {
                    customerSearch.value = customer.nama_customer;
                    document.getElementById('customer_id').value = customer.customer_id;
                    customerSuggestions.classList.add('hidden');
                    noCustomerFound.classList.add('hidden');
                };
                customerSuggestions.appendChild(item);
            });
        } else {
            customerSuggestions.classList.add('hidden');
            noCustomerFound.classList.remove('hidden');
        }
    });
});

const barangSearch = document.getElementById('barang_search');
const barangSuggestions = document.getElementById('barang_suggestions');
const barangList = document.getElementById('barang_list');
const barangPlaceholder = document.getElementById('barang_placeholder');

barangSearch.addEventListener('input', function () {
    const keyword = this.value.trim();
    if (!keyword) {
        barangSuggestions.innerHTML = '';
        barangSuggestions.classList.add('hidden');
        return;
    }

    fetch('/barang/search', {
        method: 'POST',
        headers: {'Content-Type': 'application/json','X-Requested-With': 'XMLHttpRequest'},
        body: JSON.stringify({ keyword })
    })
    .then(res => res.json())
    .then(data => {
        barangSuggestions.innerHTML = '';
        barangSuggestions.classList.remove('hidden');

        if (data.length > 0) {
            const groupedData = groupByName(data);
            groupedBarangData = Object.values(groupedData).flat(); // ✅ global

            Object.keys(groupedData).forEach(namaBarang => {
                const group = groupedData[namaBarang];
                const parentItem = document.createElement('div');
                parentItem.classList.add('p-2', 'border-b', 'bg-gray-100', 'font-bold');
                parentItem.textContent = namaBarang;
                barangSuggestions.appendChild(parentItem);

                group.forEach(barang => {
                    const childItem = document.createElement('div');
                    childItem.classList.add('p-2', 'ml-4', 'flex', 'justify-between', 'items-center');

                    const statusColor = barang.status_color === 'green' ? 'text-green-600' : 'text-red-600';
                    childItem.innerHTML = `
                        <div>
                            <span class="text-sm ${statusColor}">ID: ${barang.barang_id}</span>
                            <span class="text-xs ${statusColor}">(${barang.status_text})</span><br>
                            <span class="text-sm text-gray-700">Harga: Rp${barang.harga.toLocaleString('id-ID')}</span>
                        </div>
                        <button 
                            type="button" 
                            class="text-blue-600 hover:underline font-medium" 
                            onclick="addBarang('${barang.barang_id}', '${namaBarang}', ${barang.status_color === 'green'})"
                            ${barang.status_color === 'red' ? 'disabled' : ''}>
                            Pilih
                        </button>
                    `;
                    barangSuggestions.appendChild(childItem);
                });
            });
        } else {
            barangSuggestions.innerHTML = `<div class="p-2 text-gray-500">Barang tidak ditemukan.</div>`;
        }
    });
});

function groupByName(data) {
    return data.reduce((groups, barang) => {
        if (!groups[barang.nama_barang]) groups[barang.nama_barang] = [];
        groups[barang.nama_barang].push(barang);
        return groups;
    }, {});
}

function addBarang(id, nama, isAvailable) {
    const barangData = groupedBarangData.find(item => item.barang_id === id);
    if (!barangData || !isAvailable) {
        alert('Barang tidak tersedia.');
        return;
    }

    const exists = [...document.querySelectorAll('input[name="barang_id[]"]')].some(item => item.value === id);
    if (exists) {
        alert('Barang sudah ditambahkan.');
        return;
    }

    barangPlaceholder.classList.add('hidden');

    const newItem = document.createElement('div');
    newItem.classList.add('p-2', 'flex', 'justify-between', 'items-center', 'border-b');
    newItem.innerHTML = `
        <span>ID: ${id} - ${nama} - Rp${barangData.harga.toLocaleString('id-ID')}</span>
        <button class="text-red-500 font-bold" onclick="removeBarang(this)">x</button>
        <input type="hidden" name="barang_id[]" value="${id}">
        <input type="hidden" name="barang_harga[]" value="${barangData.harga}">
    `;
    barangList.appendChild(newItem);

    updateTotalHarga();
}

function removeBarang(button) {
    button.parentElement.remove();
    if (barangList.childElementCount === 1) {
        barangPlaceholder.classList.remove('hidden');
    }
    updateTotalHarga();
}

function updateTotalHarga() {
    const hargaInputs = document.querySelectorAll('input[name="barang_harga[]"]');
    const tanggalPinjam = document.getElementById('tanggal_pinjam').value;
    const tanggalKembali = document.getElementById('tanggal_kembali').value;
    const diskonInput = document.getElementById('diskon');
    
    let durasi = 1; // default
    if (tanggalPinjam && tanggalKembali) {
        const start = new Date(tanggalPinjam);
        const end = new Date(tanggalKembali);
        const diff = Math.floor((end - start) / (1000 * 60 * 60 * 24));
        durasi = diff + 1;
        if (durasi < 1) durasi = 1;

    }

    // Hitung total
    let total = 0;
    hargaInputs.forEach(input => {
        total += parseInt(input.value) * durasi;
    });

    // Hitung diskon
    const diskonPersen = parseInt(diskonInput.value) || 0;
    const diskonNominal = Math.floor(total * diskonPersen / 100);
    const totalSetelahDiskon = total - diskonNominal;

    // Tampilkan dan set value
    document.getElementById('durasi_sewa_display').value = durasi + ' hari';
    document.getElementById('durasi_sewa').value = durasi;
    document.getElementById('total_harga_display').textContent = 'Rp' + totalSetelahDiskon.toLocaleString('id-ID');
    document.getElementById('total_harga').value = totalSetelahDiskon;

    // Tampilkan/sembunyikan section
    const totalSection = document.getElementById('total_harga_section');
    totalSection.classList.toggle('hidden', hargaInputs.length === 0);
}

document.getElementById('submit_button').addEventListener('click', function (e) {
    e.preventDefault();
    const form = document.querySelector('form');
    const customerId = document.getElementById('customer_id').value;
    const barangList = document.querySelectorAll('input[name="barang_id[]"]');

    if (!customerId || barangList.length === 0) {
        alert('Pastikan customer dan barang sudah dipilih.');
        return;
    }

    if (confirm('Apakah Anda ingin menyimpan transaksi dan mencetak Surat Jalan?')) {
        form.action = '/transaksi/save?cetak=1';
        form.submit();
    } else {
        form.action = '/transaksi/save';
        form.submit();
    }
});
</script>
<?= $this->endSection() ?>
