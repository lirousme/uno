<?php
// /views/login/api/register.php

/**
 * Endopoint para registo de novos utilizadores.
 * Regras: Username único, validação restrita, password hashed (Argon2id preferencialmente).
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

// Validação básica
if (empty($username) || empty($password)) {
    http_response_code(400);
    echo json_encode(['error' => 'Username e palavra-passe são obrigatórios.']);
    exit;
}

if (strlen($username) < 3 || strlen($password) < 6) {
    http_response_code(400);
    echo json_encode(['error' => 'Username mínimo 3 caracteres, palavra-passe mínima 6.']);
    exit;
}

try {
    // 1. Verificar se o username já existe
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    if ($stmt->fetch()) {
        http_response_code(409); // Conflict
        echo json_encode(['error' => 'Este username já está em uso.']);
        exit;
    }

    // 2. Hash da password (utiliza o algoritmo mais forte nativo do PHP, normalmente bcrypt ou Argon2)
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // 3. Inserção
    $insert = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (:username, :hash)");
    $insert->execute([
        'username' => $username,
        'hash' => $passwordHash
    ]);

    // Resposta de sucesso sem vazar dados sensíveis
    http_response_code(201); // Created
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // Log interno, resposta limpa para o cliente (evitar vazar detalhes da DB)
    error_log("Erro ao registar: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erro interno ao criar conta.']);
}