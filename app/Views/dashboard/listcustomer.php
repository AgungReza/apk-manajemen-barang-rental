<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Daftar Customer
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row mt-16">
    <div class="flex-1 ml-[250px] p-6">
        <div class="bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-6">Daftar Customer</h1>

            <!-- Form Pencarian -->
            <div class="flex items-center justify-between mb-4">
                <form action="/customer/search" method="get" class="flex flex-1">
                    <input 
                        type="text" 
                        name="q" 
                        placeholder="Cari customer..." 
                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2"
                        value="<?= isset($q) ? esc($q) : '' ?>">
                    <button 
                        type="submit" 
                        class="ml-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Tabel Data Customer -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">Customer ID</th>
                            <th class="px-4 py-2 border">Nama Customer</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($customers) && is_array($customers)): ?>
                            <?php foreach ($customers as $customer): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border"><?= esc($customer['customer_id']) ?></td>
                                    <td class="px-4 py-2 border"><?= esc($customer['nama_customer']) ?></td>
                                    <td class="px-4 py-2 border">
                                        <a href="/editcustomer/<?= esc($customer['customer_id']) ?>" class="text-blue-600 hover:underline">Edit</a> |
                                        <a href="/deletecustomer/<?= esc($customer['customer_id']) ?>" class="text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus customer ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center px-4 py-2 border">Data customer tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
