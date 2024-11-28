<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Form Transaksi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-6">Form Transaksi</h1>
            <form action="/transaksi/save" method="post">
                <?= csrf_field(); ?>

                <!-- Pencarian Customer -->
                <div class="mb-4">
                    <label for="customer_search" class="block text-sm font-medium text-gray-700">Nama Customer</label>
                    <div class="relative">
                        <input 
                            id="customer_search" 
                            name="customer_name" 
                            type="text" 
                            placeholder="Cari nama customer..." 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <div id="customer_suggestions" class="absolute bg-white border border-gray-300 rounded-lg shadow-md w-full hidden"></div>
                        <div id="no_customer_found" class="hidden mt-2">
                            <p class="text-sm text-gray-600">
                                Customer tidak ditemukan, 
                                <a 
                                    href="/formcustomer" 
                                    class="text-blue-600 hover:underline font-medium">
                                    klik di sini
                                </a> 
                                untuk menambah customer baru.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tanggal Pinjam dan Tanggal Kembali -->
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
                        <input 
                            id="tanggal_pinjam" 
                            name="tanggal_pinjam"
                            type="date" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="<?= date('Y-m-d') ?>"
                        />
                    </div>
                    <div>
                        <label for="tanggal_kembali" class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
                        <input 
                            id="tanggal_kembali" 
                            name="tanggal_kembali"
                            type="date" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                    </div>
                </div>

                <!-- Pencarian Barang -->
                <div class="mb-4">
                    <label for="barang_search" class="block text-sm font-medium text-gray-700">Cari Barang</label>
                    <div class="relative">
                        <input 
                            id="barang_search" 
                            name="keyword"
                            type="text" 
                            placeholder="Cari nama barang..." 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <div id="barang_suggestions" class="absolute bg-white border border-gray-300 rounded-lg shadow-md w-full hidden"></div>
                    </div>
                </div>

                <!-- Daftar Barang yang Dipinjam -->
                <div class="mb-4 mt-6">
                    <label class="block text-sm font-medium text-gray-700">Daftar Barang yang Dipinjam</label>
                    <div id="barang_list" class="p-4 border border-gray-300 rounded-lg bg-gray-50">
                        <p id="barang_placeholder" class="text-gray-600">Belum ada barang yang ditambahkan.</p>
                    </div>
                </div>

                <!-- Catatan -->
                <div class="mb-4">
                    <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                    <textarea 
                        id="catatan" 
                        name="catatan" 
                        rows="4" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                        placeholder="Tambahkan catatan untuk transaksi ini..."></textarea>
                </div>

                <!-- Tombol Simpan -->
                <div class="flex justify-end gap-4">
                    <button 
                        type="submit" 
                        class="inline-flex justify-center rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Real-time search customer
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
            body: JSON.stringify({ keyword: keyword }),
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

    // Real-time search barang
    const barangSearch = document.getElementById('barang_search');
    const barangSuggestions = document.getElementById('barang_suggestions');
    const barangList = document.getElementById('barang_list');
    const barangPlaceholder = document.getElementById('barang_placeholder');

    barangSearch.addEventListener('input', function () {
        const keyword = this.value;

        if (keyword.trim() === '') {
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
            body: JSON.stringify({ keyword: keyword }),
        })
        .then(response => response.json())
        .then(data => {
            barangSuggestions.innerHTML = '';
            barangSuggestions.classList.remove('hidden');
            data.forEach(barang => {
                const item = document.createElement('div');
                item.classList.add('p-2', 'hover:bg-gray-100', 'cursor-pointer', 'flex', 'justify-between');
                item.innerHTML = `
                    <span>ID: ${barang.barang_id} - ${barang.nama_barang}</span>
                `;
                item.addEventListener('click', () => {
                    addBarang(barang.barang_id, barang.nama_barang);
                    barangSuggestions.classList.add('hidden');
                    barangSearch.value = ''; // Reset input setelah barang ditambahkan
                });
                barangSuggestions.appendChild(item);
            });
        });
    });

    function addBarang(id, nama) {
        barangPlaceholder.classList.add('hidden');
        const newItem = document.createElement('div');
        newItem.classList.add('p-2', 'flex', 'justify-between', 'items-center', 'border-b');
        newItem.innerHTML = `
            <span>ID: ${id} - ${nama}</span>
            <button class="text-red-500 font-bold" onclick="removeBarang(this)">x</button>
        `;
        barangList.appendChild(newItem);

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'barang_id[]';
        hiddenInput.value = id;
        newItem.appendChild(hiddenInput);
    }

    function removeBarang(button) {
        button.parentElement.remove();

        if (barangList.childElementCount === 1) {
            barangPlaceholder.classList.remove('hidden');
        }
    }
</script>
<?= $this->endSection() ?>
