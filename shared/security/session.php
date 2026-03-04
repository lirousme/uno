<?php
// shared/security/session.php
// Responsável pelas sessões seguras, tokens CSRF e validações de acesso.

function start_secure_session() {
    if (session_status() === PHP_SESSION_NONE) {
        // Exige configurações restritas do lado do cliente
        ini_set('session.cookie_httponly', 1); // Previne XSS de roubar sessão
        ini_set('session.cookie_secure', 1);   // Mudar para 1 em produção (HTTPS obrigatório)
        ini_set('session.cookie_samesite', 'Lax'); // Previne CSRF base
        ini_set('session.use_strict_mode', 1);
        session_start();
    }
}

function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(403);
        die(json_encode(['error' => 'Token CSRF inválido ou expirado.']));
    }
}

// Bloqueia acesso se não estiver logado
function require_auth() {
    start_secure_session();
    if (empty($_SESSION['user_id'])) {
        header("Location: /views/login/");
        exit;
    }
}

// Bloqueia acesso se já estiver logado (ex: página de login)
function require_guest() {
    start_secure_session();
    if (!empty($_SESSION['user_id'])) {
        header("Location: /views/dashboard/");
        exit;
    }
}