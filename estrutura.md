<!-- /estrutura.md -->

Estrutura do Sistema (App Web)

1. Árvore de Banco de Dados (MySQL)

DATABASE: uno_app

TABLE: users
  - id (INT, PK, AUTO_INCREMENT)
  - username (VARCHAR 50, UNIQUE, NOT NULL)
  - password_hash (VARCHAR 255, NOT NULL)
  - created_at (DATETIME, DEFAULT CURRENT_TIMESTAMP)
  > INDEX: idx_username (username)

TABLE: directories
  - id (INT, PK, AUTO_INCREMENT)
  - user_id (INT, FK -> users.id, NOT NULL)
  - parent_id (INT, FK -> directories.id, NULLABLE)
  - name (VARCHAR 100, NOT NULL)
  - created_at (DATETIME, DEFAULT CURRENT_TIMESTAMP)
  - updated_at (DATETIME, DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)
  > INDEX: idx_user_parent (user_id, parent_id)
  > RELATION: FK_directories_users (user_id -> users.id) ON DELETE CASCADE
  > RELATION: FK_directories_parent (parent_id -> directories.id) ON DELETE CASCADE


2. Árvore de Directórios do Site

/ (Raiz)
/index.php (Raiz do projecto)
├── estrutura.md
├── shared/
│   ├── config/
│   │   └── db.php                  # Conexão PDO segura centralizada
│   └── utils/
│       └── response.php            # Helper para formatar JSON de forma segura
├── views/
│   ├── login/
│   │   ├── index.php               # Ponto de entrada (verifica sessão)
│   │   ├── components/
│   │   │   └── form.php            # Partial HTML do formulário
│   │   ├── ui/
│   │   │   └── login.js            # Controller DOM da view
│   │   ├── api/
│   │   │   ├── auth.js             # Fetch wrappers para auth
│   │   │   ├── endpoint_login.php  # Backend logic
│   │   │   └── endpoint_register.php
│   │
│   ├── dashboard/
│   │   ├── index.php               # Ponto de entrada (protegido)
│   │   ├── components/
│   │   │   ├── sidebar.php         # Lista adjacente
│   │   │   ├── modal_create.php    # Modal HTML criar dir
│   │   │   └── modal_edit.php      # Modal HTML editar/apagar dir
│   │   ├── ui/
│   │   │   └── dashboard.js        # Controller DOM do dashboard
│   │   ├── api/
│   │   │   ├── dir_api.js          # Fetch wrappers
│   │   │   └── endpoint_dirs.php   # REST API (GET, POST, PUT, DELETE)
