<?php include __DIR__ . '/../../views/layoutcode/header.php'; ?>

<div class="max-w-7xl mx-auto py-10 px-4">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white shadow rounded-lg p-6 border-l-4 <?php echo $ticket['status'] == 'open' ? 'border-green-500' : ($ticket['status'] == 'closed' ? 'border-gray-500' : 'border-blue-500'); ?>">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 mb-1">
                            #<?php echo $ticket['id']; ?> - <?php echo htmlspecialchars($ticket['title']); ?>
                        </h1>
                        <p class="text-sm text-gray-500">
                            Raportat de: <span class="font-bold text-gray-900"><?php echo htmlspecialchars($ticket['full_name']); ?></span> 
                            (<?php echo htmlspecialchars($ticket['email']); ?>)
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-bold bg-gray-100 text-gray-800">
                        <?php echo strtoupper($ticket['status']); ?>
                    </span>
                </div>
            </div>

            <div class="space-y-4">
                <?php if(empty($messages)): ?>
                    <p class="text-center text-gray-400 italic">Niciun mesaj în acest tichet.</p>
                <?php else: ?>
                    <?php foreach($messages as $msg): 
                        $isAdmin = ($msg['role'] === 'admin');
                    ?>
                    <div class="flex <?php echo $isAdmin ? 'justify-end' : 'justify-start'; ?>">
                        <div class="max-w-lg <?php echo $isAdmin ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-200 text-gray-800'; ?> rounded-lg shadow px-5 py-4">
                            <div class="text-xs font-bold mb-1 <?php echo $isAdmin ? 'text-indigo-200' : 'text-gray-500'; ?>">
                                <?php echo htmlspecialchars($msg['full_name']); ?>
                                <span class="opacity-75 font-normal"> - <?php echo date('d M H:i', strtotime($msg['created_at'])); ?></span>
                            </div>
                            <p class="whitespace-pre-line"><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                            
                            <?php if (!empty($msg['attachment'])): ?>
                                <div class="mt-2 pt-2 border-t <?php echo $isAdmin ? 'border-indigo-400' : 'border-gray-100'; ?>">
                                    <a href="<?php echo BASE_URL; ?>/uploads/<?php echo $msg['attachment']; ?>" target="_blank" class="text-xs underline font-bold hover:opacity-80">
                                        📎 Vezi Atașament
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white shadow-lg rounded-lg border border-indigo-100 p-6 sticky top-24">
                
                <h3 class="font-bold text-gray-800 mb-4 text-lg border-b pb-2">Acțiuni Administrator</h3>
                
                <form action="<?php echo BASE_URL; ?>/admin/reply" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Status Tichet</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2">
                            <option value="open" <?php echo $ticket['status'] == 'open' ? 'selected' : ''; ?>>🟢 Open (În Lucru)</option>
                            <option value="resolved" <?php echo $ticket['status'] == 'resolved' ? 'selected' : ''; ?>>🔵 Resolved (Rezolvat)</option>
                            <option value="closed" <?php echo $ticket['status'] == 'closed' ? 'selected' : ''; ?>>⚫ Closed (Închis Definitiv)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Mesaj Răspuns</label>
                        <textarea name="message" rows="4" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Scrie aici răspunsul tău..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Atașează Fișier</label>
                        <input type="file" name="attachment" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>

                    <hr class="my-6 border-gray-200">

                    <div class="bg-yellow-50 p-4 rounded-md border border-yellow-200 mb-6">
                        <div class="flex items-center mb-2">
                            <input type="checkbox" name="is_public" id="is_public" value="1" <?php echo $ticket['is_public'] ? 'checked' : ''; ?> class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="is_public" class="ml-2 block text-sm font-bold text-gray-800">
                                Afișează Public (FAQ)
                            </label>
                        </div>
                        
                        <label class="block text-xs font-bold text-gray-700 mb-1">Soluția Oficială (Pentru FAQ)</label>
                        <textarea name="solution_text" rows="3" class="w-full border-gray-300 rounded-md shadow-sm text-sm" placeholder="Ex: Problema a fost rezolvată prin restartare..."><?php echo htmlspecialchars($ticket['solution_text'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 shadow transition transform hover:-translate-y-0.5">
                        Actualizează Tichetul
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <form action="<?php echo BASE_URL; ?>/admin/delete" method="POST" onsubmit="return confirm('ATENȚIE! Ești sigur că vrei să ștergi acest tichet? Această acțiune este ireversibilă!');">
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Șterge Tichetul
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../../views/layoutcode/footer.php'; ?>