<?php
// views/login/index.php
require_once '../../shared/security/session.php';
require_guest(); // Impede o utilizador de ver o login se já estiver autenticado
$csrf_token = generate_csrf_token();
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso - UNO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex items-center justify-center">
    
    <div class="max-w-md w-full p-8 bg-white rounded-2xl shadow-xl border border-slate-100">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                <i class="fa-solid fa-shield-halved text-white text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800" id="form-title">Acesso Seguro</h1>
            <p class="text-sm text-slate-500 mt-2" id="form-subtitle">Introduza as suas credenciais para continuar.</p>
        </div>

        <form id="auth-form" class="space-y-5" novalidate>
            <!-- Token CSRF protegido -->
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
            <input type="hidden" name="action" id="action" value="login">

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">E-mail</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-regular fa-envelope text-slate-400"></i>
                    </div>
                    <input type="email" id="email" name="email" required
                        class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg focus:ring-slate-800 focus:border-slate-800 text-sm transition-colors outline-none"
                        placeholder="seu@email.com">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Palavra-passe</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-key text-slate-400"></i>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg focus:ring-slate-800 focus:border-slate-800 text-sm transition-colors outline-none"
                        placeholder="••••••••">
                </div>
            </div>

            <!-- Toast de Erro Integrado -->
            <div id="error-message" class="hidden p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-md"></div>

            <button type="submit" id="submit-btn" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-colors">
                <span>Entrar no Sistema</span>
                <i class="fa-solid fa-arrow-right-to-bracket ml-2"></i>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center text-sm">
            <button type="button" id="toggle-mode" class="text-slate-600 hover:text-slate-900 font-medium transition-colors">
                Não tem conta? Criar uma agora.
            </button>
        </div>
    </div>

    <!-- Módulo JS Isolado da View -->
    <script type="module" src="./ui/login.js"></script>
</body>
</html>