<?php
// views/login/api/auth.php
// Trata submissão de login/registo. Oculta dados de erros específicos para prevenir enumeração.

require_once '../../../shared/security/session.php';
require_once '../../../shared/db/connection.php';

// Protecção 1: Método restrito
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['error' => 'Método inválido.']));
}

start_secure_session();

// Protecção 2: CSRF
$token = $_POST['csrf_token'] ?? '';
verify_csrf_token($token);

// Rate Limiting Temporário (Proposta: Passar para Redis futuramente)
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}
if ($_SESSION['login_attempts'] > 5 && (time() - $_SESSION['last_attempt_time']) < 300) {
    http_response_code(429);
    die(json_encode(['error' => 'Muitas tentativas. Aguarde 5 minutos.']));
}

$action = $_POST['action'] ?? '';
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$password = $_POST['password'] ?? '';

// Protecção 3: Sanitização e validação de base
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    die(json_encode(['error' => 'Formato de e-mail inválido.']));
}
if (strlen($password) < 8) {
    http_response_code(400);
    die(json_encode(['error' => 'A palavra-passe tem de ter pelo menos 8 caracteres.']));
}

$db = get_db_connection();

if ($action === 'register') {
    // Evita enumeração através do tempo de resposta num cenário avançado, 
    // mas de forma simples vamos manter a mensagem genérica.
    $stmt = $db->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        http_response_code(400);
        die(json_encode(['error' => 'Não foi possível completar o registo.'])); // Não revela que o email existe
    }

    // Protecção 4: Hashing Argon2 (ou default mais forte actual)
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare('INSERT INTO users (email, password_hash) VALUES (?, ?)');
    
    try {
        $stmt->execute([$email, $hash]);
        $_SESSION['user_id'] = $db->lastInsertId();
        $_SESSION['user_email'] = $email;
        session_regenerate_id(true); // Protecção 5: Prevenção de Fixação de Sessão
        
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        http_response_code(500);
        die(json_encode(['error' => 'Ocorreu um erro interno.']));
    }

} elseif ($action === 'login') {
    $stmt = $db->prepare('SELECT id, password_hash FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $email;
        $_SESSION['login_attempts'] = 0; // Limpa o rate limit local
        session_regenerate_id(true); // Rotação essencial após login
        
        echo json_encode(['success' => true]);
    } else {
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt_time'] = time();
        
        http_response_code(401);
        die(json_encode(['error' => 'E-mail ou palavra-passe incorretos.'])); // Mensagem agnóstica
    }
} else {
    http_response_code(400);
    die(json_encode(['error' => 'Ação não suportada.']));
}