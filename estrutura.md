Banco de Dados (MySQL)

Banco: uno_db

Tabela: users

id (INT, PK, Auto Increment)

username (VARCHAR(50), Unique)

password_hash (VARCHAR(255))

created_at (TIMESTAMP)

Índices: PRIMARY (id), UNIQUE idx_username (username)

Tabela: sessions

id (VARCHAR(128), PK)

user_id (INT, FK -> users.id)

ip_address (VARCHAR(45))

user_agent (TEXT)

last_activity (TIMESTAMP)

Índices: PRIMARY (id), FOREIGN KEY (user_id), INDEX idx_user_id (user_id), INDEX idx_last_activity (last_activity)

Diretórios do Site

/
├── database.sql
├── estrutura.md
├── index.php
├── shared/
│   ├── api/
│   │   └── logout.php
│   ├── db/
│   │   └── connection.php
│   └── security/
│       └── session.php
└── views/
├── dashboard/
│   └── index.php
└── login/
├── index.php
├── api/
│   └── auth.php
├── components/
│   ├── header.php
│   ├── login_form.php
│   └── register_form.php
└── ui/
└── login.js