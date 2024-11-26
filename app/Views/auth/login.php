<?= $this->extend('layout/header') ?>

<?= $this->section('content') ?>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Login</h2>

        <!-- Pesan Error -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Pesan Sukses -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="/login/submit" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter your email">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter your password">
            </div>
            <button
                type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                Login
            </button>
        </form>
        <div class="mt-4 text-center">
            <span class="text-sm text-gray-600">Belum memiliki akun?</span>
            <a href="/register" class="text-sm text-blue-500 hover:underline">Daftar</a>
        </div>
    </div>
<?= $this->endSection() ?>
