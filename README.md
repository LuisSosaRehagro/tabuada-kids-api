# Tabuada Kids — API (Backend)

API REST do projeto **Tabuada Kids**, uma aplicação web educacional que ajuda crianças a memorizar a tabuada de multiplicação de forma divertida e progressiva.

## Sobre o Projeto

O backend é responsável por toda a lógica de negócio, autenticação e persistência de dados do Tabuada Kids. Ele expõe uma API REST consumida pelo frontend em Next.js.

**Funcionalidades:**
- Autenticação separada para pais e filhos via JWT
- Cadastro de múltiplos perfis de filhos por conta pai
- Registro de sessões de jogo (quiz) com acertos por tabuada
- Cálculo dinâmico de status por tabuada (Iniciante / Estudante / PRO)
- Painel de progresso do pai com percentual de acertos por tabuada

## Stack

| Camada | Tecnologia |
|---|---|
| Framework | Laravel 12 (PHP 8.3+) |
| Autenticação | JWT (tymon/jwt-auth) |
| Banco de Dados | PostgreSQL via Supabase |
| Arquitetura | Hexagonal (Ports and Adapters) |

## Arquitetura

O projeto segue a **Arquitetura Hexagonal**, separando claramente as responsabilidades:

```
app/
├── Domain/           # Entidades, Value Objects, Interfaces (Ports)
├── Application/      # Use Cases e DTOs
└── Infrastructure/   # Controllers, Repositories Eloquent, Middlewares
```

## Como Rodar Localmente

### Pré-requisitos
- PHP 8.3+
- Composer
- Banco de dados PostgreSQL (ou conta no Supabase)

### Passo a passo

```bash
# 1. Clone o repositório
git clone https://github.com/LuisSosaRehagro/tabuada-kids-api.git
cd tabuada-kids-api

# 2. Instale as dependências
composer install

# 3. Copie o arquivo de variáveis de ambiente
cp .env.example .env

# 4. Edite o .env com suas credenciais de banco de dados
# DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
# JWT_SECRET (gere com: php artisan jwt:secret)

# 5. Gere a chave da aplicação
php artisan key:generate

# 6. Inicie o servidor
php artisan serve --port=8000
```

A API estará disponível em `http://localhost:8000`

## Principais Endpoints

| Método | Rota | Descrição |
|---|---|---|
| POST | `/api/auth/parent/register` | Cadastro do pai |
| POST | `/api/auth/parent/login` | Login do pai |
| POST | `/api/auth/child/login` | Login da criança |
| POST | `/api/children` | Criar perfil de filho |
| GET | `/api/children` | Listar filhos do pai |
| POST | `/api/sessions` | Registrar sessão de jogo |
| GET | `/api/progress/{childId}` | Progresso do filho |

## Variáveis de Ambiente

Copie `.env.example` para `.env` e configure:

```env
DB_CONNECTION=pgsql
DB_HOST=seu-host
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=seu-usuario
DB_PASSWORD=sua-senha
DB_SSLMODE=require

JWT_SECRET=   # Gere com: php artisan jwt:secret
```

## Licença

MIT
