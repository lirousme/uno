<?php
// /index.php

/**
 * Ponto de entrada único (Router). 
 * Nenhuma lógica de view ou DB aqui, apenas roteamento seguro e controlo de acesso.
 */

require_once __DIR__ . '/shared/security/session.php';

// Limpeza da URL para o roteamento
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);

// ---------------------------------------------------------
// Rotas de API (Endpoints)
// ---------------------------------------------------------
if ($path === '/api/login') {
    require __DIR__ . '/views/login/api/login.php';
    exit;
}
if ($path === '/api/register') {
    require __DIR__ . '/views/login/api/register.php';
    exit;
}
// Futura rota de logout
if ($path === '/api/logout') {
    session_destroy();
    header('Location: /login');
    exit;
}

// ---------------------------------------------------------
// Rotas de View (Páginas HTML)
// ---------------------------------------------------------
if ($path === '/' || $path === '/dashboard') {
    // Controlo de acesso: Apenas logados
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }
    require __DIR__ . '/views/dashboard/index.php';
    exit;
} 

if ($path === '/login') {
    // Se já estiver logado, atira para o dashboard
    if (isset($_SESSION['user_id'])) {
        header('Location: /dashboard');
        exit;
    }
    require __DIR__ . '/views/login/index.php';
    exit;
}

// Fallback para 404
http_response_code(404);
echo "404 - Página não encontrada.";