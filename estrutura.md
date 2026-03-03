<!-- /estrutura.md -->

Estrutura do Projecto: Uno

Este documento mapeia a arquitectura e a base de dados do projecto, servindo como a "fonte de verdade" para o desenvolvimento contínuo.

1. Arquitectura de Pastas

/
├── database/                   # Scripts SQL para criação e migração do DB
│   └── 01_init_schema.sql      # Schema inicial (Users, etc.)
├── shared/                     # Recursos globais e reutilizáveis (Obrigatório)
│   ├── ui/                     # Componentes visuais globais (header, modals, toasts)
│   ├── utils/                  # Helpers, formatadores e validações gerais
│   ├── security/               # CSRF, rate limiting, sanitização, criptografia (Wrappers)
│   ├── http/                   # Networking (cliente fetch, handlers de erro globais)
│   └── config/                 # Carregamento de variáveis de ambiente (.env)
└── views/                      # Páginas da aplicação (Isolamento de Domínio)
    └── [nome_da_view]/
        ├── components/         # Partials HTML/PHP específicos desta view
        ├── ui/                 # JS de interface específico
        ├── api/                # Endpoints PHP e JS de rede específicos
        ├── state/              # Gestão de estado local
        ├── services/           # Lógica de negócio da view
        └── validators/         # Validação específica de entrada de dados


2. Base de Dados (app_uno)

Motor: MySQL (InnoDB)
Encoding: utf8mb4 / utf8mb4_unicode_ci

Tabelas

users

Tabela fundamental para a gestão de identidade. Focada na protecção extrema dos dados.

Coluna

Tipo

Descrição / Regra de Segurança

id

CHAR(36)

Chave primária. UUIDv4 para evitar IDOR.

username

VARCHAR(50)

UNIQUE. Handle/identificador público do utilizador (ex: @joao). Mantido em claro para permitir URLs de perfil e pesquisas públicas.

email_blind_index

VARCHAR(64)

UNIQUE. Hash HMAC determinístico gerado no PHP para permitir queries de login sem expor o email em claro.

email_encrypted

TEXT

Email real encriptado via AES-256-GCM no PHP. Apenas o servidor consegue decifrar durante a sessão.

name_encrypted

TEXT

Nome real (PII) encriptado via AES-256-GCM no PHP para garantir privacidade.

password_hash

VARCHAR(255)

Hash Argon2id.

is_active

TINYINT(1)

Flag de activação/banimento.

created_at

TIMESTAMP

Registo de criação.

updated_at

TIMESTAMP

Registo de actualização automática.

3. Stack Tecnológico & Padrões

Front-end: HTML + Vanilla JavaScript (ESM) + TailwindCSS + Font Awesome.

Back-end: PHP (Server-Side Includes para views, API JSON para dados).

Base de Dados: MySQL.

Segurança Criptográfica: O MySQL não guarda chaves. O PHP realiza operações simétricas e de hashing. Chaves residem apenas no ambiente (.env) e fora da raiz web.