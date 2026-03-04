/estrutura.md

Árvore de Ficheiros

/
├── index.php                     # Ponto de entrada (Redirecciona para Login ou Dashboard)
├── database.sql                  # Estrutura do DB
├── estrutura.md                  # Mapa da arquitectura (Este ficheiro)
├── shared/                       # Recursos Globais Reutilizáveis
│   ├── api/                      # Endpoints globais (ex: logout)
│   │   └── logout.php
│   ├── db/                       # Camada de Acesso a Dados
│   │   └── connection.php
│   └── security/                 # Políticas e funções de Segurança
│       └── session.php
└── views/                        # Páginas / Domínios da Aplicação
├── dashboard/                # View do painel de controlo principal
│   └── index.php
└── login/                    # View de Autenticação
├── index.php             # HTML/UI renderizado server-side
├── api/                  # Endpoints restritos ao login
│   └── auth.php
└── ui/                   # Módulos JS específicos do Login
└── login.js