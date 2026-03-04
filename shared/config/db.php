<?php
// /shared/config/db.php

/**
 * Ficheiro partilhado responsável pela conexão PDO à base de dados.
 * Implementa boas práticas: tratamento rigoroso de erros e desativação de prepared statements emulados.
 */

$host = '127.0.0.1'; // Usar IP previne overhead de resolução DNS (localhost)
$db   = 'uno_app';
$user = 'root';      // Mudar em produção e usar variáveis de ambiente
$pass = 'naotemsenhaA1@';          // Mudar em produção e usar variáveis de ambiente
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Exceções em caso de erro (não expor ao utilizador no front)
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retornar arrays associativos por padrão
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Prevenção extra contra SQL Injection (força prepared statements reais)
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Em produção, este erro deve ir para um ficheiro de log e não ser exibido na página.
    error_log("Erro de Conexão DB: " . $e->getMessage());
    http_response_code(500);
    exit('Erro interno do servidor. A equipa técnica já foi notificada.');
}