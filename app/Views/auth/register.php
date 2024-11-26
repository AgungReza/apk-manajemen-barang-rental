<?= $this->extend('layout/header') ?>

<?= $this->section('content') ?>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Register</h2>
        <form action="/register/submit" method="POST">
            <!-- First Name Input -->
            <div class="mb-4">
                <label for="first_name" class="block text-gray-700 text-sm font-medium mb-2">Nama Depan</label>
                <input
                    type="text"
                    id="first_name"
                    name="first_name"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Masukkan nama depan">
            </div>
            <!-- Last Name Input -->
            <div class="mb-4">
                <label for="last_name" class="block text-gray-700 text-sm font-medium mb-2">Nama Belakang</label>
                <input
                    type="text"
                    id="last_name"
                    name="last_name"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Masukkan nama belakang">
            </div>
            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Masukkan email Anda">
            </div>
            <!-- Password Input -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Masukkan password">
            </div>
            <!-- Confirm Password Input -->
            <div class="mb-6">
                <label for="confirm_password" class="block text-gray-700 text-sm font-medium mb-2">Konfirmasi Password</label>
                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Konfirmasi password Anda">
            </div>
            <!-- Register Button -->
            <button
                type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                Daftar
            </button>
        </form>
        <!-- Login Link -->
        <div class="mt-4 text-center">
            <span class="text-sm text-gray-600">Sudah memiliki akun?</span>
            <a href="/login" class="text-sm text-blue-500 hover:underline">Login</a>
        </div>
    </div>
<?= $this->endSection() ?>
