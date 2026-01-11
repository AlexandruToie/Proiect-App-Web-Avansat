<?php include __DIR__ . '/../../views/layoutcode/header.php'; ?>

<div class="max-w-xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Setări Profil</h2>
            <p class="text-sm text-gray-500">Actualizează-ți datele personale</p>
        </div>

        <div class="p-6">
            <?php if (isset($_GET['success'])): ?>
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm font-bold">
                    Profil actualizat cu succes!
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm font-bold">
                    Parola trebuie să aibă minim 6 caractere.
                </div>
            <?php endif; ?>

            <form action="<?php echo BASE_URL; ?>/profile/update" method="POST">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresa de Email</label>
                    <input type="text" value="<?php echo htmlspecialchars($user['email']); ?>" disabled
                        class="w-full bg-gray-100 border-gray-300 rounded-lg p-3 text-gray-500 cursor-not-allowed">
                    <p class="text-xs text-gray-400 mt-1">Emailul nu poate fi schimbat.</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nume Complet</label>
                    <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required
                        class="w-full border-gray-300 border rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <hr class="my-6 border-gray-200">

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Parolă Nouă (Opțional)</label>
                    <input type="password" name="password" placeholder="Lasă gol dacă nu vrei să schimbi"
                        class="w-full border-gray-300 border rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-700 transition">
                        Salvează Modificările
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../views/layoutcode/footer.php'; ?>