<?php
// /views/login/api/endpoint_register.php
// Back-end: Registo com hash seguro

session_start();
require_once __DIR__ . '/../../../shared/config/db.php';
require_once __DIR__ . '/../../../shared/utils/response.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') sendJson(['error' => 'Method not allowed'], 405);

$data = json_decode(file_get_contents('php://input'), true);

$headers = getallheaders();
$clientToken = $headers['X-Csrf-Token'] ?? '';
if (!hash_equals($_SESSION['csrf_token'] ?? '', $clientToken)) {
    sendJson(['error' => 'Sessão inválida. Recarregue a página.'], 403);
}

$username = trim(strtolower($data['username'] ?? ''));
$password = $data['password'] ?? '';

// Validações servidor (Nunca confiar apenas no JS)
if (strlen($username) < 3 || strlen($password) < 6) {
    sendJson(['error' => 'Username ou password não cumprem os requisitos mínimos.'], 400);
}
if (!preg_match('/^[a-z0-9_.]+$/', $username)) {
    sendJson(['error' => 'Username contém caracteres inválidos.'], 400);
}

$pdo = getDBConnection();

// Verificar se username já existe
$stmtCheck = $pdo->prepare('SELECT id FROM users WHERE username = ?');
$stmtCheck->execute([$username]);
if ($stmtCheck->fetch()) {
    sendJson(['error' => 'Username indisponível.'], 409);
}

// Criptografia obrigatória no DB (Hash de password forte)
$hash = password_hash($password, PASSWORD_ARGON2ID, ['memory_cost' => 65536, 'time_cost' => 4, 'threads' => 2]);
// Fallback para Bcrypt caso o servidor não suporte Argon2id
if (!$hash) {
    $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

try {
    $stmt = $pdo->prepare('INSERT INTO users (username, password_hash) VALUES (:username, :hash)');
    $stmt->execute(['username' => $username, 'hash' => $hash]);
    
    // Auto-login após registo
    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['username'] = $username;
    
    sendJson(['success' => true, 'message' => 'Conta criada com sucesso!']);
} catch (\Exception $e) {
    error_log("Registo falhou: " . $e->getMessage()); // Log silencioso
    sendJson(['error' => 'Ocorreu um erro ao criar a conta.'], 500);
}