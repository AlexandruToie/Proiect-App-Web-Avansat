<?php include __DIR__ . '/../../views/layoutcode/header.php'; ?>

<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="text-center mb-12">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
            Centru de Ajutor
        </h1>
        <p class="mt-4 text-lg text-gray-500">
            Înainte de a deschide un tichet, verifică dacă problema ta se află printre cele deja rezolvate.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        
        <?php if (!empty($publicTickets)): ?>
            <?php foreach ($publicTickets as $index => $faq): ?>
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition cursor-pointer group h-full" 
                     onclick="toggleFaq('faq-<?php echo $faq['id']; ?>')">
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                            </span>
                        </div>
                        <div class="ml-4 w-full">
                            <h3 class="text-lg font-medium text-gray-900"><?php echo htmlspecialchars($faq['title']); ?></h3>
                            <p class="mt-1 text-sm text-gray-500">Click pentru soluție...</p>
                        </div>
                    </div>
                    
                    <div id="faq-<?php echo $faq['id']; ?>" class="hidden mt-4 pt-4 border-t border-gray-100 text-gray-600 text-sm">
                        <div class="prose prose-sm max-w-none">
                            <?php echo nl2br(htmlspecialchars($faq['solution_text'])); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-1 md:col-span-2 text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nicio soluție publică momentan</h3>
                <p class="mt-1 text-sm text-gray-500">Fii primul care raportează o problemă!</p>
            </div>
        <?php endif; ?>

    </div>

    <div class="text-center py-8 border-t border-gray-200">
        <h3 class="text-xl font-bold text-gray-900">Problema ta nu e în listă?</h3>
        <p class="text-gray-500 mb-6">Nu-ți face griji, echipa noastră e aici să te ajute.</p>
        
        <button onclick="showTicketForm()" id="showFormBtn" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-full hover:bg-blue-700 shadow-lg transition transform hover:-translate-y-1">
            Deschide un Tichet Nou &darr;
        </button>
    </div>

    <div id="ticketFormContainer" class="hidden mt-8 transition-all duration-500 ease-in-out">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-8 sm:p-10 bg-gray-50">
                
                <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Detalii Tichet</h2>

                <div id="suggestions-box" class="hidden mb-8 bg-yellow-50 rounded-xl p-5 border border-yellow-200">
                    <div class="flex items-center mb-3">
                        <span class="text-yellow-600 mr-2 font-bold">💡 Sfat:</span>
                        <h3 class="text-yellow-800 font-bold text-sm">Am găsit ceva similar:</h3>
                    </div>
                    <div id="suggestions-list" class="space-y-3"></div>
                </div>

                <form action="<?php echo BASE_URL; ?>/ticketscode/store" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subiectul Problemei</label>
                        <input type="text" name="title" id="ticketTitle" required
                            class="block w-full rounded-lg border-gray-300 pl-4 py-3 focus:border-blue-500 focus:ring-blue-500 sm:text-sm border shadow-sm"
                            placeholder="ex: Eroare la conectare VPN...">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descriere Detaliată</label>
                        <textarea id="message" name="message" rows="6" required
                            class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-lg p-4"
                            placeholder="Descrie exact ce s-a întâmplat..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Atașamente (Opțional)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-white hover:border-blue-400 transition cursor-pointer relative group bg-white">
                            <div class="space-y-1 text-center">
                                <svg id="upload-icon" class="mx-auto h-12 w-12 text-gray-400 group-hover:text-blue-500 transition" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <span class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                        <span id="file-label">Încarcă un fișier</span>
                                    </span>
                                </div>
                            </div>
                            <input id="file-upload" name="attachment" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-between">
                        <button type="button" onclick="hideForm()" class="text-sm font-medium text-gray-600 hover:text-red-600 transition">
                            Anulează
                        </button>
                        <button type="submit" class="inline-flex justify-center py-3 px-8 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition">
                            Trimite Tichetul
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// 1. Toggle FAQ (Simplu și eficient)
function toggleFaq(id) {
    const el = document.getElementById(id);
    if (el.classList.contains('hidden')) {
        el.classList.remove('hidden');
    } else {
        el.classList.add('hidden');
    }
}

// 2. Formular Logic
function showTicketForm() {
    const form = document.getElementById('ticketFormContainer');
    const btn = document.getElementById('showFormBtn');
    form.classList.remove('hidden');
    btn.classList.add('hidden');
    form.scrollIntoView({ behavior: 'smooth' });
}

function hideForm() {
    document.getElementById('ticketFormContainer').classList.add('hidden');
    document.getElementById('showFormBtn').classList.remove('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// 3. Upload Feedback
document.getElementById('file-upload').addEventListener('change', function(e) {
    const fileName = e.target.files[0] ? e.target.files[0].name : null;
    const label = document.getElementById('file-label');
    const icon = document.getElementById('upload-icon');
    if (fileName) {
        label.textContent = "Fișier: " + fileName;
        label.className = "text-green-600 font-bold";
        icon.classList.add('text-green-500');
    }
});

// 4. Smart Search
document.getElementById('ticketTitle').addEventListener('input', function(e) {
    let text = e.target.value;
    const box = document.getElementById('suggestions-box');
    const list = document.getElementById('suggestions-list');

    if (text.length > 3) {
        fetch('<?php echo BASE_URL; ?>/api/check-solution', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ title: text })
        })
        .then(res => res.json())
        .then(data => {
            if (data.found) {
                list.innerHTML = `
                    <div class="bg-white p-3 rounded border border-yellow-200 shadow-sm">
                        <strong class="block text-gray-800">${data.solution_title}</strong>
                        <p class="text-sm text-gray-600 mt-1">${data.solution_content}</p>
                    </div>`;
                box.classList.remove('hidden');
            } else {
                box.classList.add('hidden');
            }
        })
        .catch(err => console.log(err));
    } else {
        box.classList.add('hidden');
    }
});
</script>

<?php include __DIR__ . '/../../views/layoutcode/footer.php'; ?>