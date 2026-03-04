<?php
// /shared/config/db.php
// Camada Shared: Ligação segura à Base de Dados com PDO.

function getDBConnection() {
    // NOTA OPERACIONAL: Num ambiente real, estas credenciais VÊM de variáveis de ambiente (.env) fora do webroot.
    $host = '127.0.0.1';
    $db   = 'uno_app';
    $user = 'root'; // Ajustar conforme o ambiente
    $pass = 'naotemsenhaA1@';     // Ajustar conforme o ambiente
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Excepções seguras, não emitem output em claro se logadas correctamente
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false, // Prevenção forte contra SQL Injection (força uso de prepared statements nativos)
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        // Falha segura: não revela dados da BD ao cliente.
        error_log($e->getMessage());
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Database connection failed.']);
        exit;
    }
}