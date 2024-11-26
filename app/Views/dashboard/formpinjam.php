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

                <!-- Nama Customer -->
                <div class="mb-4">
                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Nama Customer</label>
                    <input 
                        id="customer_name" 
                        name="customer_name"
                        type="text" 
                        placeholder="Nama customer..." 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>

                <!-- Tanggal Pinjam -->
                <div class="mb-4">
                    <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
                    <input 
                        id="tanggal_pinjam" 
                        name="tanggal_pinjam"
                        type="date" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="<?= date('Y-m-d') ?>"
                    />
                </div>

                <!-- Tanggal Kembali -->
                <div class="mb-4">
                    <label for="tanggal_kembali" class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
                    <input 
                        id="tanggal_kembali" 
                        name="tanggal_kembali"
                        type="date" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>

                <!-- Pencarian Barang -->
                <div class="mb-4">
                    <label for="barang_search" class="block text-sm font-medium text-gray-700">Cari Barang</label>
                    <div class="flex gap-4">
                        <input 
                            id="barang_search" 
                            type="text" 
                            name="keyword"
                            placeholder="Masukkan nama barang..." 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <button 
                            type="button" 
                            id="search_button" 
                            class="inline-flex justify-center rounded-md bg-green-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Cari Barang
                        </button>
                    </div>
                </div>

                <!-- Hasil Pencarian Barang -->
                <div id="barang_suggestions" class="mt-4 bg-white border border-gray-300 rounded-lg shadow-md p-4 hidden">
                    <p class="text-gray-500">Hasil pencarian akan muncul di sini...</p>
                </div>

                <!-- Daftar Barang yang Dipinjam -->
                <div class="mb-4 mt-6">
                    <label class="block text-sm font-medium text-gray-700">Daftar Barang yang Dipinjam</label>
                    <div id="barang_list" class="p-4 border border-gray-300 rounded-lg bg-gray-50">
                        <p id="barang_placeholder" class="text-gray-600">Belum ada barang yang ditambahkan.</p>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="flex justify-end">
                    <button 
                        type="submit" 
                        id="save_transaction" 
                        class="inline-flex justify-center rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const searchButton = document.getElementById('search_button');
    const barangSearch = document.getElementById('barang_search');
    const suggestionsContainer = document.getElementById('barang_suggestions');
    const barangList = document.getElementById('barang_list');
    const barangPlaceholder = document.getElementById('barang_placeholder');

    searchButton.addEventListener('click', function () {
        const keyword = barangSearch.value;

        if (keyword.trim() === '') {
            alert('Masukkan kata kunci untuk mencari barang!');
            return;
        }

        fetch('/barang/search', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ keyword: keyword })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Response tidak OK');
            }
            return response.json();
        })
        .then(data => {
            suggestionsContainer.innerHTML = '';
            suggestionsContainer.classList.remove('hidden');

            if (data.length > 0) {
                data.forEach(item => {
                    const suggestion = document.createElement('div');
                    suggestion.classList.add('p-2', 'flex', 'justify-between', 'items-center', 'border-b', 'hover:bg-gray-100', 'cursor-pointer');
                    suggestion.innerHTML = `
                        <span>${item.nama_barang}</span>
                        <button 
                            type="button" 
                            class="text-green-500 font-bold"
                            onclick="addBarang('${item.barang_id}', '${item.nama_barang}')">
                            + Tambah
                        </button>
                    `;
                    suggestionsContainer.appendChild(suggestion);
                });
            } else {
                suggestionsContainer.innerHTML = '<p class="text-red-500">Barang tidak ditemukan.</p>';
            }
        })
        .catch(error => {
            console.error('Terjadi kesalahan saat pencarian:', error);
            suggestionsContainer.innerHTML = '<p class="text-red-500">Terjadi kesalahan pada server.</p>';
        });
    });

    function addBarang(id, nama) {
        barangPlaceholder.classList.add('hidden');

        const newItem = document.createElement('div');
        newItem.classList.add('p-2', 'flex', 'justify-between', 'items-center', 'border-b');
        newItem.innerHTML = `
            <span>${nama}</span>
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
