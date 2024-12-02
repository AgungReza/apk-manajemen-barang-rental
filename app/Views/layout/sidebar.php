<aside
    class="bg-gray-600 w-[250px] min-h-screen pt-[60px] fixed text-white"
>
    <nav>
        <ul>
            <li class="p-4 hover:bg-gray-500 transition">
                <a href="/" class="flex items-center text-white">
                    <span class="material-icons mr-2"></span>
                    Home
                </a>
            </li>
            <li class="p-4 hover:bg-gray-500 transition">
                <a href="/barang" class="flex items-center text-white">
                    <span class="material-icons mr-2"></span>
                    Barang
                </a>
            </li>
            <li class="p-4 hover:bg-gray-500 transition relative group">
                <button class="flex items-center w-full text-white">
                    <span class="material-icons mr-2"></span>
                    Peminjaman
                    <span class="ml-auto material-icons transform group-hover:rotate-90 transition">
                        &#9662;
                    </span>
                </button>
                <ul class="hidden group-hover:block bg-gray-700 ml-4">
                    <li class="p-4 hover:bg-gray-600 transition">
                        <a href="/transaksi" class="flex items-center text-white">
                            <span class="material-icons mr-2"></span>
                            Form Peminjaman
                        </a>
                    </li>
                    <li class="p-4 hover:bg-gray-600 transition">
                        <a href="/peminjaman/log" class="flex items-center text-white">
                            <span class="material-icons mr-2"></span>
                            Log Peminjaman
                        </a>
                    </li>
                </ul>
            </li>
            <li class="p-4 hover:bg-gray-500 transition relative group">
                <button class="flex items-center w-full text-white">
                    <span class="material-icons mr-2"></span>
                    Customer
                    <span class="ml-auto material-icons transform group-hover:rotate-90 transition">
                        &#9662;
                    </span>
                </button>
                <ul class="hidden group-hover:block bg-gray-700 ml-4">
                    <li class="p-4 hover:bg-gray-600 transition">
                        <a href="/formcustomer" class="flex items-center text-white">
                            <span class="material-icons mr-2"></span>
                            Form Customer
                        </a>
                    </li>
                    <li class="p-4 hover:bg-gray-600 transition">
                        <a href="/customer/list" class="flex items-center text-white">
                            <span class="material-icons mr-2"></span>
                            Daftar Customer
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>
