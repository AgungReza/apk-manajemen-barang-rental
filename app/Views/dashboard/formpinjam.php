<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Transaksi</title>
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 py-8 px-4">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Form Transaksi</h1>
        
        <!-- Nama Customer -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Customer</label>
            <div class="flex gap-4">
                <input 
                    id="customer_name" 
                    type="text" 
                    placeholder="Cari nama customer..." 
                    class="border border-gray-300 rounded-lg w-full p-2"
                />
                <button 
                    type="button" 
                    id="add_customer" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    + Tambah Customer
                </button>
            </div>
            <div id="customer_suggestions" class="bg-white border rounded shadow mt-2 hidden"></div>
        </div>

        <!-- Tanggal Pinjam -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pinjam</label>
            <input 
                id="tanggal_pinjam" 
                type="date" 
                class="border border-gray-300 rounded-lg w-full p-2"
                value="<?= date('Y-m-d') ?>"
            />
        </div>

        <!-- Tanggal Kembali -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kembali</label>
            <input 
                id="tanggal_kembali" 
                type="date" 
                class="border border-gray-300 rounded-lg w-full p-2"
            />
        </div>

        <!-- Pencarian Barang -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Cari Barang</label>
            <div class="flex gap-4">
                <input 
                    id="barang_search" 
                    type="text" 
                    placeholder="Cari barang..." 
                    class="border border-gray-300 rounded-lg w-full p-2"
                />
                <button 
                    type="button" 
                    id="add_barang" 
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    + Tambah Barang
                </button>
            </div>
            <div id="barang_suggestions" class="bg-white border rounded shadow mt-2 hidden"></div>
        </div>

        <!-- Daftar Barang yang Dipinjam -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Daftar Barang yang Dipinjam</label>
            <div id="barang_list" class="p-4 border border-gray-300 rounded-lg bg-gray-50">
                <p class="text-gray-600">Belum ada barang yang ditambahkan.</p>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <div>
            <button 
                type="button" 
                id="save_transaction" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                Simpan Transaksi
            </button>
        </div>
    </div>

    <script>
        // Nama customer autocomplete
        $("#customer_name").on("input", function() {
            const query = $(this).val();
            if (query.length > 1) {
                // Ganti URL berikut sesuai endpoint backend Anda
                $.ajax({
                    url: '/search_customer', 
                    method: 'GET',
                    data: { name: query },
                    success: function(data) {
                        const customers = data.customers; // Sesuaikan dengan respons backend
                        let suggestions = '';
                        customers.forEach(customer => {
                            suggestions += `<div class="p-2 hover:bg-gray-100 cursor-pointer" 
                                onclick="selectCustomer('${customer.id}', '${customer.name}')">
                                ${customer.name}
                            </div>`;
                        });
                        $("#customer_suggestions").html(suggestions).removeClass('hidden');
                    }
                });
            } else {
                $("#customer_suggestions").addClass('hidden');
            }
        });

        function selectCustomer(id, name) {
            $("#customer_name").val(name);
            $("#customer_suggestions").addClass('hidden');
        }

        // Barang autocomplete
        $("#barang_search").on("input", function() {
            const query = $(this).val();
            if (query.length > 1) {
                // Ganti URL berikut sesuai endpoint backend Anda
                $.ajax({
                    url: '/search_barang',
                    method: 'GET',
                    data: { name: query },
                    success: function(data) {
                        const items = data.items; // Sesuaikan dengan respons backend
                        let suggestions = '';
                        items.forEach(item => {
                            suggestions += `<div class="p-2 hover:bg-gray-100 cursor-pointer" 
                                onclick="addBarang('${item.id}', '${item.name}')">
                                ${item.name}
                            </div>`;
                        });
                        $("#barang_suggestions").html(suggestions).removeClass('hidden');
                    }
                });
            } else {
                $("#barang_suggestions").addClass('hidden');
            }
        });

        function addBarang(id, name) {
            const itemHTML = `<div class="flex justify-between items-center border p-2 mb-2 rounded-lg">
                <span>${name}</span>
                <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded"
                    onclick="removeBarang(this)">Hapus</button>
            </div>`;
            $("#barang_list").append(itemHTML);
            $("#barang_suggestions").addClass('hidden');
        }

        function removeBarang(element) {
            $(element).parent().remove();
        }
    </script>
</body>
</html>
