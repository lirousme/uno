<?php
// /views/dashboard/api/endpoint_dirs.php
// Back-end: REST API unificada para Directórios
// Regras: Segurança de IDOR (só acede a dir do próprio user_id), CSRF em mutações.

session_start();
require_once __DIR__ . '/../../../shared/config/db.php';
require_once __DIR__ . '/../../../shared/utils/response.php';

// Auth Guard
if (!isset($_SESSION['user_id'])) sendJson(['error' => 'Não autorizado'], 401);
$userId = $_SESSION['user_id'];

$method = $_SERVER['REQUEST_METHOD'];
$pdo = getDBConnection();

// CSRF Check para mutações
if (in_array($method, ['POST', 'PUT', 'DELETE'])) {
    $headers = getallheaders();
    $clientToken = $headers['X-Csrf-Token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $clientToken)) {
        sendJson(['error' => 'Acesso negado. Violação CSRF.'], 403);
    }
}

$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        // GET Raízes (ou de um parent_id específico se for implementada navegação interior)
        $parentId = $_GET['parent_id'] ?? null;
        
        if ($parentId) {
            // Lógica futura: validar se o parentId pertence ao user antes de listar
            $stmt = $pdo->prepare('SELECT id, name, created_at FROM directories WHERE user_id = ? AND parent_id = ? ORDER BY name ASC');
            $stmt->execute([$userId, $parentId]);
        } else {
            $stmt = $pdo->prepare('SELECT id, name, created_at FROM directories WHERE user_id = ? AND parent_id IS NULL ORDER BY name ASC');
            $stmt->execute([$userId]);
        }
        
        sendJson($stmt->fetchAll());
        break;

    case 'POST':
        // CRIAR
        $name = trim($input['name'] ?? '');
        $parentId = $input['parent_id'] ?? null; // Nullable
        
        // Sanitização rigorosa do input
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        
        if (empty($name)) sendJson(['error' => 'Nome é obrigatório'], 400);

        // Prevenção de IDOR: se enviar parent_id, verificar se pertence a este user
        if ($parentId) {
            $stmtCheck = $pdo->prepare('SELECT id FROM directories WHERE id = ? AND user_id = ?');
            $stmtCheck->execute([$parentId, $userId]);
            if (!$stmtCheck->fetch()) sendJson(['error' => 'Directório pai inválido ou não autorizado'], 403);
        }

        $stmt = $pdo->prepare('INSERT INTO directories (user_id, parent_id, name) VALUES (?, ?, ?)');
        $stmt->execute([$userId, $parentId, $name]);
        sendJson(['success' => true, 'id' => $pdo->lastInsertId()]);
        break;

    case 'PUT':
        // EDITAR (Renomear)
        $id = $input['id'] ?? null;
        $name = trim($input['name'] ?? '');
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        if (!$id || empty($name)) sendJson(['error' => 'Dados inválidos'], 400);

        // Prevenção IDOR incluída no WHERE
        $stmt = $pdo->prepare('UPDATE directories SET name = ? WHERE id = ? AND user_id = ?');
        $stmt->execute([$name, $id, $userId]);
        
        if ($stmt->rowCount() === 0) sendJson(['error' => 'Operação não executada. Permissão negada ou sem alterações.'], 400);
        sendJson(['success' => true]);
        break;

    case 'DELETE':
        // APAGAR (O ON DELETE CASCADE no MySQL trata de apagar as subpastas)
        $id = $input['id'] ?? null;
        if (!$id) sendJson(['error' => 'ID obrigatório'], 400);

        // Prevenção IDOR
        $stmt = $pdo->prepare('DELETE FROM directories WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
        sendJson(['success' => true]);
        break;

    default:
        sendJson(['error' => 'Method not allowed'], 405);
}