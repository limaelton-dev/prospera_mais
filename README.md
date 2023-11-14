# Documentação da API

## Autenticação

### Login
**Endpoint:** `/login`  
**Método:** `POST`  
**Parâmetros:**
- `email` (string, obrigatório): O e-mail do usuário.
- `password` (string, obrigatório): A senha do usuário.

**Respostas:**
- **Sucesso (200 OK):**
  - Retorna o token de acesso no formato JSON.

- **Erro (401 Unauthorized):**
  - Retorna uma mensagem de erro indicando credenciais inválidas.

---

### Registro de Usuário
**Endpoint:** `/register`  
**Método:** `POST`  
**Parâmetros:**
- `name` (string, obrigatório): Nome do usuário.
- `email` (string, obrigatório): E-mail do usuário.
- `password` (string, obrigatório): Senha do usuário.

**Respostas:**
- **Sucesso (200 OK):**
  - Retorna uma mensagem indicando que o usuário foi registrado com sucesso.

---

## Operações na Carteira

### Listar Carteiras do Usuário
**Endpoint:** `/wallets`  
**Método:** `GET`  
**Parâmetros:**
- Requer autenticação.

**Respostas:**
- **Sucesso (200 OK):**
  - Retorna a lista de carteiras associadas ao usuário no formato JSON.

- **Erro (404 Not Found):**
  - Retorna uma mensagem indicando que não há carteiras para o usuário.

---

### Detalhes da Carteira
**Endpoint:** `/wallets/{id}`  
**Método:** `GET`  
**Parâmetros:**
- `id` (int, obrigatório): ID da carteira.
- Requer autenticação.

**Respostas:**
- **Sucesso (200 OK):**
  - Retorna os detalhes da carteira, incluindo transações associadas, no formato JSON.

- **Erro (404 Not Found):**
  - Retorna uma mensagem indicando que a carteira não foi encontrada.

---

### Criar Nova Carteira
**Endpoint:** `/wallets`  
**Método:** `POST`  
**Parâmetros:**
- `name` (string, obrigatório): Nome da carteira.
- `balance` (numeric, obrigatório): Saldo inicial da carteira.
- `description` (string, opcional): Descrição da carteira.
- Requer autenticação.

**Respostas:**
- **Sucesso (201 Created):**
  - Retorna os detalhes da carteira recém-criada no formato JSON.

---

### Atualizar Carteira
**Endpoint:** `/wallets/{id}`  
**Método:** `PUT`  
**Parâmetros:**
- `id` (int, obrigatório): ID da carteira.
- `name` (string, obrigatório): Novo nome da carteira.
- `description` (string, opcional): Nova descrição da carteira.
- Requer autenticação.

**Respostas:**
- **Sucesso (200 OK):**
  - Retorna os detalhes atualizados da carteira no formato JSON.

- **Erro (404 Not Found):**
  - Retorna uma mensagem indicando que a carteira não foi encontrada.

---

### Excluir Carteira
**Endpoint:** `/wallets/{id}`  
**Método:** `DELETE`  
**Parâmetros:**
- `id` (int, obrigatório): ID da carteira.
- Requer autenticação.

**Respostas:**
- **Sucesso (204 No Content):**
  - Retorna uma resposta vazia indicando que a carteira foi excluída com sucesso.

- **Erro (404 Not Found):**
  - Retorna uma mensagem indicando que a carteira não foi encontrada.

---

## Transações na Carteira

### Retirar Fundos
**Endpoint:** `/wallets/{id}/withdraw`  
**Método:** `POST`  
**Parâmetros:**
- `amount` (numeric, obrigatório): Valor a ser retirado.
- `description` (string, opcional): Descrição da transação.
- Requer autenticação.

**Respostas:**
- **Sucesso (200 OK):**
  - Retorna uma mensagem indicando que a retirada foi bem-sucedida, junto com os detalhes da carteira atualizados no formato JSON.

- **Erro (404 Not Found):**
  - Retorna uma mensagem indicando que a carteira não foi encontrada.

- **Erro (422 Unprocessable Entity):**
  - Retorna uma mensagem indicando que os fundos são insuficientes.

---

### Depositar Fundos
**Endpoint:** `/wallets/{id}/deposit`  
**Método:** `POST`  
**Parâmetros:**
- `amount` (numeric, obrigatório): Valor a ser depositado.
- `description` (string, opcional): Descrição da transação.
- Requer autenticação.

**Respostas:**
- **Sucesso (201 Created):**
  - Retorna uma mensagem indicando que o depósito foi bem-sucedido, junto com os detalhes da carteira atualizados no formato JSON.

- **Erro (404 Not Found):**
  - Retorna uma mensagem indicando que a carteira não foi encontrada.

---

### Transferir Fundos
**Endpoint:** `/wallets/{id}/transfer`  
**Método:** `POST`  
**Parâmetros:**
- `amount` (numeric, obrigatório): Valor a ser transferido.
- `to_wallet_id` (int, obrigatório): ID da carteira de destino.
- `description` (string, opcional): Descrição da transação.
- Requer autenticação.

**Respostas:**
- **Sucesso (200 OK):**
  - Retorna uma mensagem indicando que a transferência foi bem-sucedida, junto com os detalhes da carteira de origem atualizados no formato JSON.

- **Erro (404 Not Found):**
  - Retorna uma mensagem indicando que a carteira de origem ou de destino não foi encontrada.

- **Erro (422 Unprocessable Entity):**
  - Retorna uma mensagem indicando que os fundos são insuficientes para a transferência.
