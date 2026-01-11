<?php include __DIR__ . '/../layoutcode/header.php'; ?>

<div class="container mx-auto px-4 py-12">
    <div class="max-w-3xl mx-auto">
        
        <a href="<?php echo BASE_URL; ?>/ticketscode/create" class="text-blue-600 hover:underline mb-6 inline-block">&larr; Înapoi la listă</a>

        <div class="bg-white p-8 rounded-lg shadow-md mb-6 border-l-4 border-red-500">
            <div class="flex items-center mb-4">
                <div class="bg-red-100 text-red-600 p-2 rounded-full mr-3">
                    User: <strong><?php echo htmlspecialchars($solution['author_name']); ?></strong>
                </div>
                <span class="text-gray-500 text-sm">Data: <?php echo $solution['created_at']; ?></span>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Problema: <?php echo htmlspecialchars($solution['title']); ?></h1>
            </div>

        <div class="flex justify-center mb-6">
            <span class="text-4xl text-gray-400">⬇️ Rezolvată cu:</span>
        </div>

        <div class="bg-green-50 p-8 rounded-lg shadow-md border-l-4 border-green-500">
            <h2 class="text-xl font-bold text-green-800 mb-4">✅ Soluția aplicată</h2>
            <div class="prose max-w-none text-gray-800 text-lg">
                <?php echo nl2br(htmlspecialchars($solution['solution_text'])); ?>
            </div>
        </div>

        <div class="mt-8 text-center bg-white p-6 rounded shadow-sm">
            <p class="text-gray-600 mb-4">Această rezolvare a ajutat deja <strong><?php echo $solution['helpful_count']; ?></strong> colegi.</p>
            <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 shadow transition">
                👍 E exact ce căutam! (Rezolvat)
            </button>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../layoutcode/footer.php'; ?>