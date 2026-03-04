<?php
// /views/login/index.php
// View: Login (Página)

session_start();
// Prevenção CSRF básica para a sessão (idealmente em middleware shared futuro)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Se já estiver logado, redirecciona para o dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: /views/dashboard/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNO - Acesso</title>
    <!-- TailwindCSS via CDN (em produção deve ser buildado localmente) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Configuração base de segurança: CSP restritiva -->
    <!-- Em produção, ajustar para permitir apenas scripts da própria origem. Aqui permitimos CDN para Tailwind/FA -->
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center font-sans antialiased selection:bg-indigo-500 selection:text-white">
    
    <!-- Container Principal (SSI do componente) -->
    <main class="w-full max-w-md p-6">
        <div class="text-center mb-8">
            <i class="fa-solid fa-cube text-4xl text-indigo-500 mb-2"></i>
            <h1 class="text-3xl font-bold tracking-tight">UNO</h1>
            <p class="text-gray-400 text-sm mt-1">Plataforma Segura</p>
        </div>

        <!-- Renderiza o componente do formulário -->
        <?php require_once __DIR__ . '/components/form.php'; ?>
    </main>

    <!-- Variáveis globais seguras injetadas pelo server -->
    <script>
        window.APP_CONFIG = {
            csrfToken: "<?= $_SESSION['csrf_token'] ?>"
        };
    </script>
    
    <!-- Carrega a lógica de UI como Módulo ES6 -->
    <script type="module" src="./ui/login.js"></script>
</body>
</html>