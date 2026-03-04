<?php
// shared/db/connection.php
// Wrapper do PDO. As configurações devem vir do ENV (simulado aqui).

function get_db_connection() {
    $host = '127.0.0.1';
    $db   = 'app_uno';
    $user = 'root'; // ATENÇÃO: Em produção usar utilizador c/ mínimos privilégios
    $pass = ''; 
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Excepções geridas pela aplicação, não expostas ao utilizador
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false, // Previne SQLi garantindo Prepares Reais no DB
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        // PONTO CEGO PROTEGIDO: O erro real é registado em log local, o utilizador vê apenas uma mensagem opaca.
        error_log($e->getMessage());
        http_response_code(500);
        die(json_encode(['error' => 'Falha interna de conexão ao servidor de dados.']));
    }
}