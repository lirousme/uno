Caminho: estrutura.md

Árvore da Base de Dados (MySQL)

DB: uno_database

Tabelas:
├── users
│   ├── id (INT, PK, AI)
│   ├── email (VARCHAR, UNIQUE)
│   ├── password_hash (VARCHAR)
│   ├── created_at (TIMESTAMP)
│   └── updated_at (TIMESTAMP)
│
└── directories
    ├── id (INT, PK, AI)
    ├── user_id (INT, FK -> users.id)
    ├── parent_id (INT, FK -> directories.id, NULLABLE)
    ├── name (VARBINARY(255)) -- Encriptado (AES)
    ├── created_at (TIMESTAMP)
    └── updated_at (TIMESTAMP)

Relações:
- directories.user_id -> users.id (ON DELETE CASCADE)
- directories.parent_id -> directories.id (ON DELETE CASCADE)

Índices:
- idx_user_parent (user_id, parent_id) -- Optimiza a listagem da hierarquia inicial


Árvore de Directórios do Projecto

/
├── auto_commit.bat
├── estrutura.md
├── index.php
├── shared/
│   ├── api/
│   │   └── logout.php
│   ├── db/
│   │   └── connection.php
│   └── security/
│       ├── session.php
│       └── crypto.php         <-- NOVO: Rotinas de encriptação
└── views/
    ├── login/
    │   ├── api/
    │   │   └── auth.php
    │   ├── components/
    │   │   ├── header.php
    │   │   ├── login_form.php
    │   │   └── register_form.php
    │   ├── ui/
    │   │   └── login.js
    │   └── index.php
    └── dashboard/
        ├── api/
        │   └── directories.php <-- NOVO: Endpoint CRUD de directórios
        ├── components/
        │   ├── sidebar.php         <-- NOVO: Lista adjacente
        │   ├── modal_create.php    <-- NOVO: HTML do modal de criação
        │   └── modal_edit.php      <-- NOVO: HTML do modal de edição/exclusão
        ├── ui/
        │   └── dashboard.js    <-- NOVO: Lógica de interface
        └── index.php           <-- ACTUALIZADO: Agregador de componentes
