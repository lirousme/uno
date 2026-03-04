<?php
// /shared/security/session.php

/**
 * Ficheiro partilhado para inicialização segura de sessões e prevenção de CSRF.
 */

// Configurações estritas de segurança para cookies de sessão antes de iniciar
ini_set('session.cookie_httponly', 1); // Previne acesso via JS (XSS)
ini_set('session.use_only_cookies', 1); // Previne Session Fixation via URL
ini_set('session.cookie_samesite', 'Strict'); // Previne CSRF

// Em produção com HTTPS, descomentar a linha abaixo:
// ini_set('session.cookie_secure', 1);

session_start();

// Geração de token CSRF global para ser usado nas views
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}