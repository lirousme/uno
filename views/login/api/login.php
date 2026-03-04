<?php
// /views/login/api/login.php

/**
 * Endopoint para autenticação de utilizadores.
 * Regras: Prevenção de enumeration attacks, rotação de ID de sessão após sucesso.
 */

require_once __DIR__ . '/../../../shared/config/db.php';
require_once __DIR__ . '/../../../shared/security/session.php';

header('Content-Type: application/json');

// Validação Anti-CSRF
$headers = apache_request_headers();
$clientCsrf = $headers['X-CSRF-Token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
if (!hash_equals($_SESSION['csrf_token'], $clientCsrf)) {
    http_response_code(403);
    echo json_encode(['error' => 'Ação não autorizada (Falha CSRF)']);
    exit;
}

// Leitura do payload JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$username = trim($data['username'] ?? '');
$password = $data['password'] ?? '';

if (empty($username) || empty($password)) {
    http_response_code(400);
    echo json_encode(['error' => 'Credenciais incompletas.']);
    exit;
}

try {
    // 1. Procurar o user
    $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    // 2. Verificar a senha (usamos mensagem genérica para evitar User Enumeration)
    if (!$user || !password_verify($password, $user['password_hash'])) {
        // Blind Spot Mitigation: Uma falha de login intencionalmente atrasada poderia prevenir "timing attacks", 
        // mas a função password_verify já tem tempo constante seguro no PHP.
        http_response_code(401);
        echo json_encode(['error' => 'Credenciais inválidas.']);
        exit;
    }

    // 3. Login bem sucedido: ROTACIONAR ID DA SESSÃO contra Session Fixation
    session_regenerate_id(true);

    // Guardar dados na sessão
    $_SESSION['user_id'] = $user['id'];
    
    // Resposta de sucesso
    http_response_code(200);
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    error_log("Erro no login: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erro interno ao validar login.']);
}