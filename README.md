# Sistema de Login e Gerenciamento de Usuários

Este é um projeto de um sistema de login e gerenciamento de usuários construído em PHP, utilizando uma arquitetura moderna e containerizado com Docker.

---

## ✨ Features

- **Autenticação de Usuário:** Registro, login e logout.
- **Gerenciamento de Conta:**
  - Ativação de conta por e-mail.
  - Recuperação de senha por e-mail.
- **API Endpoints:** Rotas bem definidas para todas as funcionalidades.
- **Ambiente Containerizado:** Fácil de configurar e executar com Docker.

---

## 🛠️ Tecnologias Utilizadas

- **Backend:** PHP 8.3
- **Servidor Web:** Nginx
- **Banco de Dados:** Postgre
- **Cache/Sessões:** Redis
- **Containerização:** Docker
- **Gerenciador de Dependências:** Composer

---

## 🚀 Instalação e Setup

Siga os passos abaixo para configurar o ambiente de desenvolvimento.

### Pré-requisitos

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

### 1. Clone o Repositório

```bash
git clone <https://github.com/NathanGuedes/Sistema-de-Login.git>
cd Sistema-de-Login-Postgre
```

### 2. Crie o Arquivo de Ambiente

Crie um arquivo `.env` na raiz do projeto com o `.env-example`. Você pode copiar o exemplo abaixo e ajustar os valores conforme necessário.

### 3. Build e Inicie os Containers

Execute o comando abaixo para construir as imagens e iniciar os containers Docker.

```bash
docker-compose up -d --build
```

### 4. Instale as Dependências do Composer

Após os containers estarem em execução, instale as dependências do PHP com o Composer.

```bash
docker-compose exec php composer install
```

### 5. Acesse a Aplicação

Após a conclusão da instalação, a aplicação estará disponível em [http://localhost:8080](http://localhost:8080) (ou a porta que você definiu em `NGINX_PORT`).

---

## ⚙️ Endpoints da Aplicação

Abaixo estão os principais endpoints definidos em `app/Routes/web.php`.

### Autenticação
- `GET /register`: Exibe a página de registro.
- `POST /register`: Processa o registro de um novo usuário.
- `GET /login`: Exibe a página de login.
- `POST /login`: Autentica o usuário.
- `POST /logout`: Desconecta o usuário.

### Gerenciamento de Conta
- `GET /email/activation/send`: Envia o e-mail de ativação de conta.
- `GET /email/activation/{token}`: Confirma a ativação da conta a partir do token.
- `GET /forgot/password/email`: Exibe o formulário para solicitar a recuperação de senha.
- `POST /forgot/password/email/send`: Envia o e-mail de recuperação de senha.
- `GET /forgot/password/email/recovery/{token}`: Exibe o formulário para alterar a senha.
- `POST /password/update`: Atualiza a senha do usuário.

### Geral
- `GET /`: Página inicial.
