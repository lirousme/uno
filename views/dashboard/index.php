<?php
// /views/dashboard/index.php
// View: Dashboard (Privado)

session_start();

// Protecção de Rota Rigorosa
if (!isset($_SESSION['user_id'])) {
    header("Location: /views/login/index.php");
    exit;
}

$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); // Sanitização na renderização
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNO - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex font-sans antialiased overflow-hidden">
    
    <!-- Inclui Componente: Sidebar (Lista Adjacente) -->
    <?php require_once __DIR__ . '/components/sidebar.php'; ?>

    <!-- Área Principal -->
    <main class="flex-1 flex flex-col h-screen">
        <header class="h-16 bg-gray-800 border-b border-gray-700 flex items-center justify-between px-6">
            <h2 class="font-semibold text-gray-200">Raíz</h2>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-400">Olá, <span class="text-white"><?= $username ?></span></span>
                <button id="btn-logout" class="text-gray-400 hover:text-red-400 transition-colors" title="Sair">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </div>
        </header>

        <div class="flex-1 p-6 overflow-y-auto bg-gray-900" id="main-content">
            <!-- Estado Vazio Inicial -->
            <div id="empty-state" class="hidden h-full flex flex-col items-center justify-center text-center">
                <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-regular fa-folder-open text-3xl text-gray-500"></i>
                </div>
                <h3 class="text-xl font-medium mb-2">Nenhum directório encontrado</h3>
                <p class="text-gray-400 mb-6 max-w-md">Parece que ainda não criaste nada. Começa por criar o teu primeiro directório na barra lateral.</p>
                <button id="btn-empty-create" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fa-solid fa-plus mr-2"></i> Criar Directório
                </button>
            </div>
            
            <!-- Grid de items do dashboard será injectada pelo JS baseada no nó activo -->
            <div id="content-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 hidden"></div>
        </div>
    </main>

    <!-- Inclusão de Modais da View -->
    <?php 
        require_once __DIR__ . '/components/modal_create.php'; 
        require_once __DIR__ . '/components/modal_edit.php';
    ?>

    <!-- Globais -->
    <script>
        window.APP_CONFIG = { csrfToken: "<?= $_SESSION['csrf_token'] ?>" };
    </script>
    
    <!-- Lógica UI Modularizada -->
    <script type="module" src="./ui/dashboard.js"></script>
</body>
</html>