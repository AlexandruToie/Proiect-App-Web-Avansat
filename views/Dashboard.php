<?php 
// Nu mai avem nevoie de verificări aici, le face Controller-ul
// Include Header-ul
include __DIR__ . '/layoutcode/header.php'; 
?>

<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <?php if (isset($_GET['success']) && $_GET['success'] == 'ticket_created'): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8 rounded-r-lg shadow-sm flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700 font-medium">Tichetul tău a fost creat cu succes!</p>
            </div>
        </div>
    <?php endif; ?>

    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Tichetele Mele
            </h2>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="<?php echo BASE_URL; ?>/ticketscode/create" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition transform hover:-translate-y-0.5">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tichet Nou
            </a>
        </div>
    </div>

    <div class="bg-white p-4 rounded-lg shadow-sm mb-6 border border-gray-200">
        <form action="<?php echo BASE_URL; ?>/dashboard" method="GET" class="flex flex-col md:flex-row gap-4">
            
            <div class="flex-grow">
                <label for="search" class="sr-only">Caută</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" id="search" 
                        class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-2 border" 
                        placeholder="Caută după titlu sau ID..." 
                        value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                </div>
            </div>

            <div class="w-full md:w-48">
                <select name="status" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md border">
                    <option value="all">Toate Statusurile</option>
                    <option value="open" <?php echo (isset($_GET['status']) && $_GET['status'] == 'open') ? 'selected' : ''; ?>>În Lucru (Open)</option>
                    <option value="resolved" <?php echo (isset($_GET['status']) && $_GET['status'] == 'resolved') ? 'selected' : ''; ?>>Rezolvate</option>
                    <option value="closed" <?php echo (isset($_GET['status']) && $_GET['status'] == 'closed') ? 'selected' : ''; ?>>Închise</option>
                </select>
            </div>

            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                Filtrează
            </button>
            
            <?php if(!empty($_GET['search']) || (isset($_GET['status']) && $_GET['status'] !== 'all')): ?>
                <a href="<?php echo BASE_URL; ?>/dashboard" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-red-600 bg-white hover:bg-red-50 transition">
                    Șterge Filtre
                </a>
            <?php endif; ?>
        </form>
    </div>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subiect</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                <th class="px-6 py-3 text-right">Acțiuni</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (count($tickets) > 0): 
                                foreach ($tickets as $ticket): 
                                    $statusClasses = match($ticket['status']) {
                                        'open' => 'bg-green-100 text-green-800',
                                        'closed' => 'bg-gray-100 text-gray-800',
                                        'resolved' => 'bg-blue-100 text-blue-800',
                                        default => 'bg-yellow-100 text-yellow-800'
                                    };
                            ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#<?php echo $ticket['id']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900"><?php echo htmlspecialchars($ticket['title']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $statusClasses; ?>">
                                        <?php echo ucfirst($ticket['status']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('d M Y', strtotime($ticket['created_at'])); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="<?php echo BASE_URL; ?>/ticketscode/view?id=<?php echo $ticket['id']; ?>" class="text-blue-600 hover:text-blue-900 font-bold">Vezi Detalii &rarr;</a>
                                </td>
                            </tr>
                            <?php endforeach; 
                            else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    Nu am găsit niciun tichet conform căutării tale.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layoutcode/footer.php'; ?>