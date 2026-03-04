<?php
// Caminho: shared/api/logout.php
require_once __DIR__ . '/../security/session.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar CSRF antes de permitir logout
    if (hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        $_SESSION = [];
        session_destroy();
        // Forçar invalidação do cookie
        setcookie(session_name(), '', time() - 3600, '/');
    }
}

echo json_encode(['success' => true]);