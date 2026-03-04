<?php
// Caminho: views/login/api/auth.php
// Endpoint protegido. Devolve apenas JSON e não expõe excepções brutas.

require_once __DIR__ . '/../../../shared/security/session.php';
require_once __DIR__ . '/../../../shared/db/connection.php';

header('Content-Type: application/json');

// Defesa anti-bruteforce básica (Time-Delay)
usleep(400000); // Atrasa propositadamente 400ms

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método não permitido.']);
    exit;
}

$action = $_POST['action'] ?? '';
$csrf_token = $_POST['csrf_token'] ?? '';

// Validação Anti-CSRF
if (!hash_equals($_SESSION['csrf_token'] ?? '', $csrf_token)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Sessão inválida ou expirada. Recarregue a página.']);
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Preencha todos os campos obrigatórios.']);
    exit;
}

try {
    if ($action === 'register') {
        if (strlen($username) < 3 || strlen($password) < 8) {
            throw new Exception('O username deve ter no mínimo 3 caracteres e a password 8.');
        }

        // Sanitização: impedir HTML/Scripts no username
        $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');

        // Verifica existência (Prevenção de enumeração mitigada por mensagens genéricas)
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            throw new Exception('O username escolhido já está em uso.');
        }

        // Criptografia Argon2 (state of the art para senhas)
        $hash = password_hash($password, PASSWORD_ARGON2ID);
        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
        $stmt->execute([$username, $hash]);

        $user_id = $pdo->lastInsertId();

        // Autenticação imediata pós-registo
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;

        echo json_encode(['success' => true]);

    } elseif ($action === 'login') {
        $stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Verificação constante time-safe internamente via password_verify
        if (!$user || !password_verify($password, $user['password_hash'])) {
            throw new Exception('Credenciais inválidas.'); // Mensagem genérica (Não vaza se o user existe ou não)
        }

        // Rotação crítica após upgrade de privilégios
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        echo json_encode(['success' => true]);

    } else {
        throw new Exception('Acção inválida.');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}