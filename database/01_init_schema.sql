-- database/01_init_schema.sql

-- 1. Criação da Base de Dados
CREATE DATABASE IF NOT EXISTS app_uno 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE app_uno;

-- 2. Tabela de Utilizadores (Design Focado em Segurança e Privacidade)
CREATE TABLE IF NOT EXISTS users (
    -- Prevenção de IDOR: Uso de UUIDv4 em formato binário (16 bytes) para performance ou CHAR(36).
    -- Optamos por CHAR(36) inicialmente para facilitar a depuração, mas podemos alterar para BINARY(16) se a escala exigir optimização extrema de índices.
    id CHAR(36) PRIMARY KEY,
    
    -- Blind Index para pesquisa de Email. O PHP irá gerar um HMAC-SHA256 do email para gravar aqui.
    -- Isto permite fazer SELECT id FROM users WHERE email_blind_index = ? sem expor o email.
    email_blind_index VARCHAR(64) NOT NULL UNIQUE,
    
    -- Dados sensíveis encriptados (AES-256-GCM gerado pelo PHP).
    -- O formato pode ser: base64(IV + Ciphertext + Tag). TEXT é usado para suportar o tamanho do base64.
    email_encrypted TEXT NOT NULL,
    
    -- Hash da password (gerado via password_hash() do PHP com Argon2id)
    password_hash VARCHAR(255) NOT NULL,
    
    -- Controlo de estado
    is_active TINYINT(1) DEFAULT 1,
    
    -- Auditoria e rastreio
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Índices de Performance
-- O email_blind_index já é UNIQUE, logo já tem um índice associado.
CREATE INDEX idx_users_status ON users(is_active);

ALTER TABLE users

ADD COLUMN username VARCHAR(50) NOT NULL UNIQUE AFTER id,

ADD COLUMN name_encrypted TEXT NOT NULL AFTER email_encrypted;