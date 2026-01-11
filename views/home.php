<?php include __DIR__ . '/layoutcode/header.php'; ?>

<div class="relative bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Rezolvăm problemele</span>
                        <span class="block text-blue-600 xl:inline">rapid și eficient.</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-auto">
                        Platforma HelpDesk Pro este locul unde găsești răspunsuri. Fie că folosești sistemul nostru de sugestii inteligente, fie că discuți direct cu echipa noastră, suntem aici pentru tine.
                    </p>
                    
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <div class="rounded-md shadow">
                                <a href="<?php echo BASE_URL; ?>/dashboard" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg transition">
                                    Mergi la Dashboard
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="<?php echo BASE_URL; ?>/ticketscode/create" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 md:py-4 md:text-lg transition">
                                    Tichet Nou
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="rounded-md shadow">
                                <a href="<?php echo BASE_URL; ?>/register" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg transition">
                                    Începe Acum
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="<?php echo BASE_URL; ?>/login" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 md:py-4 md:text-lg transition">
                                    Autentificare
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-gray-50 flex items-center justify-center">
        <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full opacity-90" 
             src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" 
             alt="Team working">
    </div>
</div>

<div class="py-16 bg-gray-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base font-semibold text-blue-600 tracking-wide uppercase">Funcționalități</h2>
            <p class="mt-1 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Tot ce ai nevoie pentru suport tehnic
            </p>
            <p class="max-w-2xl text-xl text-gray-500 lg:mx-auto mt-4">
                Am simplificat procesul de raportare a problemelor pentru ca tu să te poți concentra pe ceea ce contează.
            </p>
        </div>

        <div class="mt-12">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                
                <div class="pt-6">
                    <div class="flow-root bg-white rounded-lg px-6 pb-8 shadow-lg h-full hover:shadow-xl transition transform hover:-translate-y-1">
                        <div class="-mt-6">
                            <div>
                                <span class="inline-flex items-center justify-center p-3 bg-blue-500 rounded-md shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                </span>
                            </div>
                            <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Smart Search</h3>
                            <p class="mt-5 text-base text-gray-500">
                                Sistemul nostru îți sugerează automat soluții pe măsură ce scrii, economisind timp prețios.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <div class="flow-root bg-white rounded-lg px-6 pb-8 shadow-lg h-full hover:shadow-xl transition transform hover:-translate-y-1">
                        <div class="-mt-6">
                            <div>
                                <span class="inline-flex items-center justify-center p-3 bg-green-500 rounded-md shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                </span>
                            </div>
                            <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Comunicare Directă</h3>
                            <p class="mt-5 text-base text-gray-500">
                                Discută în timp real cu administratorii prin sistemul nostru de chat integrat în tichete.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <div class="flow-root bg-white rounded-lg px-6 pb-8 shadow-lg h-full hover:shadow-xl transition transform hover:-translate-y-1">
                        <div class="-mt-6">
                            <div>
                                <span class="inline-flex items-center justify-center p-3 bg-purple-500 rounded-md shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </span>
                            </div>
                            <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Suport Multimedia</h3>
                            <p class="mt-5 text-base text-gray-500">
                                O imagine face cât 1000 de cuvinte. Încarcă screenshot-uri sau PDF-uri pentru a explica problema.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layoutcode/footer.php'; ?>