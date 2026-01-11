<?php include __DIR__ . '/../layoutcode/header.php'; ?>

<div class="flex justify-center items-center min-h-[80vh]">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Creează un cont nou</h2>

        <?php if (isset($error) && !empty($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <strong>Atenție:</strong> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/register" method="POST">
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="full_name">
                    Nume Complet
                </label>
                <input type="text" name="full_name" id="full_name" required
                    value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Ion Popescu">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Adresă de Email
                </label>
                <input type="email" name="email" id="email" required
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="email@exemplu.com">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Parolă
                </label>
                <input type="password" name="password" id="password" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="********">
                <p class="text-xs text-gray-500 mt-1">Minim 6 caractere.</p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">
                    Confirmă Parola
                </label>
                <input type="password" name="confirm_password" id="confirm_password" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="********">
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 shadow-lg">
                Înregistrează-te
            </button>
        </form>

        <p class="mt-4 text-center text-gray-600 text-sm">
            Ai deja cont? 
            <a href="<?php echo BASE_URL; ?>/login" class="text-blue-600 hover:underline font-semibold">
                Autentifică-te
            </a>
        </p>
    </div>
</div>

<?php include __DIR__ . '/../layoutcode/footer.php'; ?>