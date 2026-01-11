<?php include __DIR__ . '/../../views/layoutcode/header.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Panou Administrare
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Privire de ansamblu asupra activității HelpDesk.
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <span class="inline-flex items-center px-4 py-2 rounded-md shadow-sm text-sm font-medium bg-blue-100 text-blue-800 border border-blue-200">
                Total Tichete: <?php echo count($tickets); ?>
            </span>
        </div>
    </div>

    <?php
        $stats = [
            'open' => 0,
            'resolved' => 0,
            'closed' => 0
        ];
        foreach ($tickets as $t) {
            if (isset($stats[$t['status']])) {
                $stats[$t['status']]++;
            } else {
                // Pentru siguranță, dacă apare un status nou
                $stats['open']++; 
            }
        }
    ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Rată de Rezolvare</dt>
                            <dd>
                                <div class="text-lg font-medium text-gray-900">
                                    <?php 
                                    $total = count($tickets);
                                    $rezolvate = $stats['resolved'] + $stats['closed'];
                                    echo $total > 0 ? round(($rezolvate / $total) * 100) . '%' : '0%'; 
                                    ?>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <span class="text-green-600 font-bold"><?php echo $stats['resolved']; ?></span> tichete rezolvate cu succes.
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg lg:col-span-2 p-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">Distribuție Statusuri</h3>
            <div style="height: 200px; width: 100%;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

    </div>

    <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Lista Detaliată</h3>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilizator</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subiect</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Public?</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acțiuni</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($tickets as $ticket): 
                    $statusColor = match($ticket['status']) {
                        'open' => 'bg-green-100 text-green-800',
                        'closed' => 'bg-gray-100 text-gray-800',
                        'resolved' => 'bg-blue-100 text-blue-800',
                        default => 'bg-yellow-100 text-yellow-800'
                    };
                ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#<?php echo $ticket['id']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                        <?php echo htmlspecialchars($ticket['full_name']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        <?php echo htmlspecialchars($ticket['title']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $statusColor; ?>">
                            <?php echo ucfirst($ticket['status']); ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <?php if($ticket['is_public']): ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                FAQ
                            </span>
                        <?php else: ?>
                            <span class="text-gray-300">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="<?php echo BASE_URL; ?>/admin/ticket?id=<?php echo $ticket['id']; ?>" class="text-indigo-600 hover:text-indigo-900 font-bold">
                            Gestionează
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const ctx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(ctx, {
        type: 'doughnut', // Tipul graficului (Gogoașă)
        data: {
            labels: ['Deschise (Open)', 'Rezolvate (Resolved)', 'Închise (Closed)'],
            datasets: [{
                label: 'Număr Tichete',
                data: [
                    <?php echo $stats['open']; ?>, 
                    <?php echo $stats['resolved']; ?>, 
                    <?php echo $stats['closed']; ?>
                ],
                backgroundColor: [
                    '#10B981', // Verde pentru Open
                    '#3B82F6', // Albastru pentru Resolved
                    '#6B7280'  // Gri pentru Closed
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });
</script>

<?php include __DIR__ . '/../../views/layoutcode/footer.php'; ?>