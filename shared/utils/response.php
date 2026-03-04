<?php
// /shared/utils/response.php
// Camada Shared: Utilitário para respostas consistentes e seguras da API

function sendJson($data, $statusCode = 200) {
    header('Content-Type: application/json; charset=utf-8');
    // Prevenção de cache para endpoints mutáveis/sensíveis
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}