<?php
// Caminho: shared/security/session.php
// Responsabilidade: Controlar segurança da sessão, CSRF e rotação.

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

// Cookies HttpOnly, Secure (se HTTPS) e SameSite=Strict
session_set_cookie_params([
    'lifetime' => 86400, // 24 horas
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']), 
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_name('uno_session_id');
session_start();

// Rotação de ID para evitar Session Fixation
if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} elseif (time() - $_SESSION['last_regeneration'] > 1800) { // 30 minutos
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

// Gerar token CSRF se não existir
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Helper global
function is_logged_in() {
    return isset($_SESSION['user_id']);
}