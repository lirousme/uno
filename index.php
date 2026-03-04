<?php
// /index.php
// Ponto de entrada (Router/Redirecionador base) do sistema UNO

// Carrega o gestor de sessões
require_once __DIR__ . '/shared/security/session.php';

// Inicia a sessão de forma segura para verificar o estado
start_secure_session();

// Verifica o estado de autenticação e redireciona
if (!empty($_SESSION['user_id'])) {
    // Se estiver logado, vai para o dashboard
    header("Location: views/dashboard/");
    exit;
} else {
    // Se for visitante, vai para o login
    header("Location: views/login/");
    exit;
}