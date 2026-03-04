<?php
// shared/api/logout.php
// Endpoint global para término seguro da sessão.

require_once '../security/session.php';
start_secure_session();

// Destrói todas as variáveis
$_SESSION = array();

// Invalida o cookie de sessão no cliente
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();
header("Location: ../../views/login/");
exit;