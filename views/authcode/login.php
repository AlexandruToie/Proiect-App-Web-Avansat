<?php include __DIR__ . '/../layoutcode/header.php'; ?>

<div class="flex justify-center items-center min-h-[70vh]">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Autentificare</h2>

        <?php if (isset($_GET['success']) && $_GET['success'] == 'registered'): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm text-center">
                Cont creat cu succes! Te rugăm să te loghezi.
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm text-center">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/login" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="email@exemplu.com">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Parolă</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="********">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                Intră în cont
            </button>
        </form>

        <p class="mt-4 text-center text-gray-600 text-sm">
            Nu ai cont? <a href="<?php echo BASE_URL; ?>/register" class="text-blue-600 hover:underline">Înregistrează-te</a>
        </p>
    </div>
</div>

<?php include __DIR__ . '/../layoutcode/footer.php'; ?>