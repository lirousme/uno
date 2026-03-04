<?php
// views/dashboard/index.php
require_once '../../shared/security/session.php';
require_auth(); // Bloqueio imediato de acessos não autorizados
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - UNO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex flex-col">
    
    <header class="bg-white shadow-sm border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <i class="fa-solid fa-cube text-slate-800 text-2xl"></i>
                        <span class="font-bold text-xl tracking-tight text-slate-900">UNO</span>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <div class="text-sm text-slate-600 px-3 py-1.5 bg-slate-100 rounded-full font-medium">
                        <i class="fa-regular fa-user mr-1"></i>
                        <?= htmlspecialchars($_SESSION['user_email'] ?? 'Utilizador') ?>
                    </div>
                    <a href="../../shared/api/logout.php" class="text-sm font-semibold text-red-600 hover:text-red-700 transition-colors flex items-center gap-1">
                        Sair <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200">
            <div class="p-8 border-b border-slate-100">
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Bem-vindo à plataforma!</h2>
                <p class="text-slate-500">
                    Sessão iniciada e protegida. A estrutura modular está preparada para escalar as próximas funcionalidades nas subpastas correctas.
                </p>
            </div>
            
            <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6 bg-slate-50/50">
                <!-- Skeleton cards para exemplo de UI -->
                <div class="bg-white p-5 rounded-lg border border-slate-100 shadow-sm flex items-center space-x-4">
                    <div class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-chart-line text-slate-400"></i>
                    </div>
                    <div class="flex-1 space-y-2">
                        <div class="h-3 bg-slate-200 rounded w-3/4"></div>
                        <div class="h-3 bg-slate-100 rounded w-1/2"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>