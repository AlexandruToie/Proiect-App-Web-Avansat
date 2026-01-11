<?php include __DIR__ . '/../../views/layoutcode/header.php'; ?>

<div class="max-w-4xl mx-auto py-10 px-4">
    
    <div class="bg-white shadow-md rounded-lg p-6 mb-6 border-l-4 <?php echo ($ticket['status'] == 'open') ? 'border-green-500' : 'border-gray-500'; ?>">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">
                    #<?php echo $ticket['id']; ?> - <?php echo htmlspecialchars($ticket['title']); ?>
                </h1>
                <span class="text-sm text-gray-500">Creat la: <?php echo date('d M Y H:i', strtotime($ticket['created_at'])); ?></span>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-bold 
                <?php echo ($ticket['status'] == 'open') ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800'; ?>">
                <?php echo strtoupper($ticket['status']); ?>
            </span>
        </div>
    </div>

    <div class="space-y-6 mb-8">
        <?php foreach($messages as $msg): 
            $isMe = ($msg['user_id'] == $_SESSION['user_id']);
        ?>
            <div class="flex <?php echo $isMe ? 'justify-end' : 'justify-start'; ?>">
                <div class="max-w-lg <?php echo $isMe ? 'bg-blue-600 text-white' : 'bg-white text-gray-800 border border-gray-200'; ?> rounded-lg shadow px-5 py-4">
                    
                    <div class="text-xs font-bold mb-1 <?php echo $isMe ? 'text-blue-200' : 'text-gray-500'; ?>">
                        <?php echo htmlspecialchars($msg['full_name']); ?> 
                        <span class="font-normal opacity-75">(<?php echo date('H:i, d M', strtotime($msg['created_at'])); ?>)</span>
                    </div>

                    <p class="whitespace-pre-line"><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>

                    <?php if (!empty($msg['attachment'])): ?>
                        <div class="mt-3 pt-3 border-t <?php echo $isMe ? 'border-blue-500' : 'border-gray-100'; ?>">
                            <p class="text-xs mb-1 opacity-75">📎 Atașament:</p>
                            
                            <?php 
                                $ext = strtolower(pathinfo($msg['attachment'], PATHINFO_EXTENSION));
                                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): 
                            ?>
                                <a href="<?php echo BASE_URL; ?>/uploads/<?php echo $msg['attachment']; ?>" target="_blank">
                                    <img src="<?php echo BASE_URL; ?>/uploads/<?php echo $msg['attachment']; ?>" 
                                         alt="Screenshot" 
                                         class="max-w-xs rounded-lg border-2 border-white/20 hover:opacity-90 transition shadow-sm mt-1 bg-white">
                                </a>
                            <?php else: ?>
                                <a href="<?php echo BASE_URL; ?>/uploads/<?php echo $msg['attachment']; ?>" target="_blank" class="underline text-sm font-bold hover:text-yellow-300">
                                    Descarcă Fișierul (<?php echo strtoupper($ext); ?>)
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if($ticket['status'] !== 'closed'): ?>
        <div class="bg-white p-6 rounded-lg shadow-md mt-8 border-t-4 border-blue-500">
            <h3 class="font-bold text-gray-700 mb-4 text-lg">Adaugă un răspuns</h3>
            
            <form action="<?php echo BASE_URL; ?>/ticketscode/reply" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
                
                <textarea name="message" required rows="4" 
                    class="w-full border-gray-300 border rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none mb-4" 
                    placeholder="Scrie mesajul tău aici..."></textarea>
                
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Atașează imagine (Opțional):</label>
                    <input type="file" name="attachment" accept="image/*,.pdf" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 shadow-md transition font-bold">
                        Trimite Răspuns
                    </button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="bg-gray-100 p-4 rounded text-center text-gray-500">
            Acest tichet a fost închis. Nu se mai pot adăuga răspunsuri.
        </div>
    <?php endif; ?>

</div>

<?php include __DIR__ . '/../../views/layoutcode/footer.php'; ?>