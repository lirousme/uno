<?php
// Caminho: index.php
// Responsabilidade: Ponto de entrada e roteador simples de views.

require_once __DIR__ . '/shared/security/session.php';

// Redireccionamento seguro baseado no estado
if (is_logged_in()) {
    require_once __DIR__ . '/views/dashboard/index.php';
} else {
    require_once __DIR__ . '/views/login/index.php';
}