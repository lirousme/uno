<?php
// Caminho: views/dashboard/index.php
// Responsabilidade: Área privada do sistema

if (session_status() === PHP_SESSION_NONE) {
    require_once __DIR__ . '/../../shared/security/session.php';
}

if (!is_logged_in()) {
    header('Location: /');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-PT" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNO - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { colors: { gray: { 950: '#0a0a0a', 900: '#171717', 800: '#262626' }}}}}
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-950 text-gray-100 min-h-screen flex flex-col antialiased">
    
    <!-- Navbar simples (futuramente mover para shared/components/navbar.php) -->
    <header class="bg-gray-900 border-b border-gray-800 px-6 py-4 flex justify-between items-center shadow-md">
        <div class="text-xl font-bold flex items-center">
            <i class="fa-solid fa-cube text-indigo-500 mr-2"></i>UNO
        </div>
        <div class="flex items-center gap-6">
            <span class="text-gray-400 text-sm">Olá, <span class="font-semibold text-white"><?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></span></span>
            <button id="btn-logout" class="text-sm bg-red-900/30 text-red-400 hover:bg-red-600 hover:text-white border border-red-800 hover:border-red-600 px-4 py-2 rounded-lg transition-colors font-medium flex items-center">
                <i class="fa-solid fa-power-off mr-2"></i>Sair
            </button>
        </div>
    </header>

    <main class="flex-grow p-8 max-w-7xl mx-auto w-full">
        <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
        
        <div class="p-6 bg-gray-900 border border-gray-800 rounded-2xl shadow-lg">
            <h2 class="text-lg font-semibold mb-2">Visão Geral</h2>
            <p class="text-gray-400">Bem-vindo(a) à tua área reservada. O sistema modular UNO está activo.</p>
            
            <div class="mt-6 flex items-center text-sm text-emerald-400 bg-emerald-900/20 border border-emerald-800/50 p-3 rounded-lg w-fit">
                <i class="fa-solid fa-shield-check mr-2"></i>Sessão autenticada e protegida.
            </div>
        </div>
    </main>

    <script>
        document.getElementById('btn-logout').addEventListener('click', async () => {
            const data = new FormData();
            data.append('csrf_token', '<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>');

            try {
                await fetch('/shared/api/logout.php', { method: 'POST', body: data });
                window.location.reload();
            } catch(e) {
                console.error("Erro ao terminar sessão", e);
            }
        });
    </script>
</body>
</html>