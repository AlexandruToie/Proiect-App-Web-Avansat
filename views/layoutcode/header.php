<!DOCTYPE html>
<html lang="ro" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpDesk Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full flex flex-col">

<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="<?php echo BASE_URL; ?>/" class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 tracking-tight cursor-pointer">
                        HelpDesk<span class="text-gray-800">Pro</span>
                    </a>
                </div>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                <div class="hidden sm:ml-10 sm:flex sm:space-x-8">
                    <a href="<?php echo BASE_URL; ?>/dashboard" 
                       class="border-transparent text-gray-500 hover:border-blue-500 hover:text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition">
                       Dashboard
                    </a>
                    <a href="<?php echo BASE_URL; ?>/ticketscode/create" 
                       class="border-transparent text-gray-500 hover:border-blue-500 hover:text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition">
                       Tichet Nou
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <div class="flex items-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="flex items-center space-x-4">
                        
                        <a href="<?php echo BASE_URL; ?>/profile" class="text-sm text-gray-700 font-medium hover:text-blue-600 transition group flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Salut, <span class="text-gray-900 font-bold group-hover:text-blue-700"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                        </a>
                        
                        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <a href="<?php echo BASE_URL; ?>/admin" class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full font-bold hover:bg-indigo-200 transition">
                                ADMIN
                            </a>
                        <?php endif; ?>

                        <a href="<?php echo BASE_URL; ?>/logout" class="text-sm text-red-600 hover:text-red-800 font-medium transition ml-4 border-l pl-4 border-gray-300">
                            Deconectare
                        </a>
                    </div>
                <?php else: ?>
                    <div class="space-x-4">
                        <a href="<?php echo BASE_URL; ?>/login" class="text-gray-500 hover:text-gray-900 font-medium">Autentificare</a>
                        <a href="<?php echo BASE_URL; ?>/register" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium transition shadow-sm">Înregistrare</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<main class="flex-grow bg-gray-50">