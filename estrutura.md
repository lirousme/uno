<!-- estrutura.md -->

Estrutura do Banco de Dados

Banco: uno_app

Tabela: users

id (INT, PK, AUTO_INCREMENT)

username (VARCHAR(50), UNIQUE, NOT NULL) - Índice: idx_username

password_hash (VARCHAR(255), NOT NULL)

created_at (DATETIME, DEFAULT CURRENT_TIMESTAMP)

Estrutura de Diretórios do Site

/
├── .htaccess
├── index.php
├── estrutura.md
├── database.sql
├── shared/
│   ├── config/
│   │   └── db.php
│   └── security/
│       └── session.php
└── views/
├── dashboard/
│   └── index.php
└── login/
├── index.php
├── api/
│   ├── login.php
│   └── register.php
├── components/
│   ├── form_login.html
│   └── form_register.html
└── ui/
└── main.js