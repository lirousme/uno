<?php
// /index.php (Raiz do projecto)
// Ponto de entrada global que redirecciona o utilizador de forma segura.

session_start();

// Se o utilizador tiver uma sessão activa, envia para o dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: /views/dashboard/index.php");
    exit;
} else {
    // Se não tiver sessão, envia para a página de login
    header("Location: /views/login/index.php");
    exit;
}