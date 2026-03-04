<?php
// /views/login/index.php

/**
 * View principal de Login.
 * Exclusivamente dedicada a compor os fragmentos de interface e fornecer o contexto (Variáveis/Tokens).
 */

// Garantir que a sessão e o CSRF token estão disponíveis
require_once __DIR__ . '/../../shared/security/session.php';
?>
<!DOCTYPE html>
<html lang="pt-PT" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Uno App</title>
    <!-- Token CSRF disponibilizado para o JS -->
    <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
    
    <!-- Tailwind via CDN (Para produção, deve ser compilado) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md bg-gray-800 rounded-2xl shadow-2xl border border-gray-700 overflow-hidden relative">
        
        <!-- Toast de Notificações (Pode ser movido para Shared futuramente) -->
        <div id="toast-container" class="absolute top-4 left-1/2 transform -translate-x-1/2 w-11/12 hidden transition-opacity duration-300">
            <div id="toast-msg" class="bg-red-500/20 border border-red-500 text-red-200 text-sm p-3 rounded-lg text-center font-medium"></div>
        </div>

        <div class="p-8">
            <div class="text-center mb-8">
                <i class="fa-solid fa-cube text-4xl text-blue-500 mb-2"></i>
                <h1 class="text-2xl font-bold tracking-tight">Bem-vindo ao Uno</h1>
            </div>

            <!-- Inclusão dos Componentes HTML puros (SSI) -->
            <div id="view-login">
                <?php include __DIR__ . '/components/form_login.html'; ?>
            </div>

            <div id="view-register" class="hidden">
                <?php include __DIR__ . '/components/form_register.html'; ?>
            </div>
        </div>
    </div>

    <!-- Interface Controller -->
    <script type="module" src="/views/login/ui/main.js"></script>
</body>
</html>