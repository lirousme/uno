<?php
// /views/dashboard/index.php

/**
 * View do Dashboard.
 * Por enquanto, apenas um layout branco em Dark Mode.
 */
?>
<!DOCTYPE html>
<html lang="pt-PT" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Uno</title>
    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen">
    
    <!-- Navbar simples -->
    <nav class="bg-gray-800 border-b border-gray-700 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-cube text-2xl text-blue-500"></i>
            <span class="font-bold text-xl tracking-tight">Uno</span>
        </div>
        
        <a href="/api/logout" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">
            <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i>Sair
        </a>
    </nav>

    <!-- Conteúdo principal (em branco como pedido) -->
    <main class="p-6">
        <p class="text-gray-500">O teu dashboard está em branco.</p>
    </main>

</body>
</html>