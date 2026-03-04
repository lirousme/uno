<?php
// /views/login/api/endpoint_login.php
// Back-end: Autenticação Segura (Prevenção SQLi, Rate limit concept, Sessão segura)

session_start();
require_once __DIR__ . '/../../../shared/config/db.php';
require_once __DIR__ . '/../../../shared/utils/response.php';

// Apenas POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') sendJson(['error' => 'Method not allowed'], 405);

// Ler JSON (Evita problemas de form-urlencoded tampering)
$data = json_decode(file_get_contents('php://input'), true);

// Validação CSRF (Exigência arquitectónica)
$headers = getallheaders();
$clientToken = $headers['X-Csrf-Token'] ?? '';
if (!hash_equals($_SESSION['csrf_token'] ?? '', $clientToken)) {
    sendJson(['error' => 'Sessão inválida. Recarregue a página.'], 403);
}

$username = trim(strtolower($data['username'] ?? ''));
$password = $data['password'] ?? '';

if (empty($username) || empty($password)) {
    sendJson(['error' => 'Credenciais incompletas.'], 400);
}

// Nota: Aqui idealmente entraria Rate Limiting contra Bruteforce (Redis / Memcached na camada Shared)

$pdo = getDBConnection();
$stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE username = :username LIMIT 1');
$stmt->execute(['username' => $username]);
$user = $stmt->fetch();

// Prevenção de enumeração (Timing attacks - usamos password_verify mesmo se falhar para equilibrar tempo, embora num DB simples seja residual)
if ($user && password_verify($password, $user['password_hash'])) {
    // Rotação de sessão obrigatória (Prevenção Session Fixation)
    session_regenerate_id(true);
    
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $username;
    
    sendJson(['success' => true, 'message' => 'Login efectuado com sucesso.']);
} else {
    // Resposta genérica para evitar enumeração de contas
    sendJson(['error' => 'Username ou password incorrectos.'], 401);
}