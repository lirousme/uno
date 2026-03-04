<?php
// Caminho: shared/db/connection.php
// Responsabilidade: Instanciar a ligação PDO de forma segura.

$host = '127.0.0.1';
$db   = 'uno_db';
$user = 'root'; // Ajustar de acordo com o ambiente
$pass = 'naotemsenhaA1@';     // Ajustar de acordo com o ambiente
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false, // Previne SQL Injection em edge cases
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Nunca expor detalhes do erro de DB ao frontend
    error_log($e->getMessage());
    die('Erro interno no servidor de base de dados.');
}