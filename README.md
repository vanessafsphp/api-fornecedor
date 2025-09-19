# API de Criação/Listagem de Fornecedor - Laravel 12

Este projeto implementa a refatoração da funcionalidade de criação e listagem de um sistema legado PHP nativo (7.4) para uma API REST moderna, utilizando Laravel 12 com arquitetura limpa e boas práticas.

## 1. Instalação e Configuração

### Pré-requisitos

* **PHP 8.2+**
* **Composer**
* **MySQL/MariaDB**
* **Laravel 12**

### 1.1. Setup Inicial

1.  **Clone o Repositório:**
    ```bash
    git clone https://github.com/vanessafsphp/api-fornecedor.git
    cd api-fornecedor
    ```

2.  **Instale as Dependências:**
    ```bash
    composer install
    ```

3.  **Configure o Ambiente (`.env`):**
    * Crie o arquivo `.env` (copie de `.env.example`).
    ```bash
    cp .env.example .env
    ```
    * Gere a chave de aplicação do Laravel.
    ```bash
    php artisan key:generate
    ```
    * Configure as credenciais de banco de dados. Ex.:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=api-fornecedor
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Executar as Migrations:**
    As *migrations* criarão as tabelas do banco de dados `api-fornecedor` (conforme exemplo acima), que são padrão do Laravel e também a tabela `fornecedores` responsável por armazenar os dados relacionados a cada Fornecedor.
    ```bash
    php artisan migrate
    ```

5.  **Popular Dados de Teste (Seeder):**
    Para popular a tabela com 100 registros fictícios (usando `FornecedorFactory`):
    ```bash
    php artisan db:seed
    ```

6.  **Inicie o Servidor:**
    ```bash
    php artisan serve
    ```
    A API estará acessível em `http://127.0.0.1:8000/`.

7.  **Autenticação para Teste:**
    * A aplicação está utilizando o Sanctum para autenticação via token.
    * Para criar um usuário de teste e gerar token:
    ```bash
    php artisan tinker
    >>> $user = User::factory()->create();
    >>> $token = $user->createToken('api-token')->plainTextToken;
    ```
    * Como usar o token gerado nas requests via Postman ou Insomnia, adicionar ao Header:
    ```bash
    Authorization: Bearer {token}
    ```

---

## 2. Endpoints da API

Os *endpoints* que substituem a lógica do arquivo `fornecedor_legacy.php` (`action=list` e `action=create`) são:

| Método | Rota | Descrição | Equivalente Legado |
| :--- | :--- | :--- | :--- |
| **GET** | `/api/v1/fornecedores?busca={$termo}` | Lista fornecedores. Filtra opcionalmente por nome (`busca`). Limite de 50 registros. | `action=list` |
| **POST** | `/api/v1/fornecedores` | Cria um novo fornecedor. Necessário enviar os dados em formato `JSON` via Body | `action=create` |

### Exemplo de Requisição (POST)

```http
POST [http://127.0.0.1:8000/api/v1/fornecedores](http://127.0.0.1:8000/api/v1/fornecedores)
Authorization: Bearer {token}
Content-Type: application/json

{
    "nome": "Nova Empresa",
    "cnpj": "11.111.111/0001-00", 
    "email": "contato@novaempresa.com"
}
```

### Exemplo de Requisição (GET)

```http
GET [http://127.0.0.1:8000/api/v1/fornecedores](http://127.0.0.1:8000/api/v1/fornecedores)
Authorization: Bearer {token}
Accept: application/json

{
	"data": [
		{
			"id": 1,
			"nome": "Cremin Inc",
			"cnpj": "40406051006101",
			"email": "edwina99@example.com",
			"criado_em": "18/09/2025 13:11:12"
		},
		{
			"id": 2,
			"nome": "Schinner Ltd",
			"cnpj": "28421672857475",
			"email": "cdicki@example.net",
			"criado_em": "18/09/2025 13:11:12"
		},
		{
			"id": 3,
			"nome": "Gaylord-Hill",
			"cnpj": "99836220871168",
			"email": "lhamill@example.org",
			"criado_em": "18/09/2025 13:11:12"
		},
        {...},
    ],
	"links": {
		"first": "http://localhost:8000/api/v1/fornecedores?page=1",
		"last": "http://localhost:8000/api/v1/fornecedores?page=2",
		"prev": null,
		"next": "http://localhost:8000/api/v1/fornecedores?page=2"
	},
	"meta": {
		"current_page": 1,
		"from": 1,
		"last_page": 2,
		"links": [
			{
				"url": null,
				"label": "&laquo; Previous",
				"page": null,
				"active": false
			},
			{
				"url": "http://localhost:8000/api/v1/fornecedores?page=1",
				"label": "1",
				"page": 1,
				"active": true
			},
			{
				"url": "http://localhost:8000/api/v1/fornecedores?page=2",
				"label": "2",
				"page": 2,
				"active": false
			},
			{
				"url": "http://localhost:8000/api/v1/fornecedores?page=2",
				"label": "Next &raquo;",
				"page": 2,
				"active": false
			}
		],
		"path": "http://localhost:8000/api/v1/fornecedores",
		"per_page": 50,
		"to": 50,
		"total": 100
	}
}
```

---

## 3. Testes Automatizados

O projeto inclui `Testes de Feature` (mínimo: sucesso, falha de validação, busca filtrada, limite de busca) para garantir que a nova API seja eficiente e funcionalmente equivalente ao sistema legado.
```bash
php artisan test
```

---

## 4. Arquivos complementares
* `Script do código legado` - encontra-se na pasta `script` deste repositório.
* `Plano de Migração` - encontra-se em formato `.docx` na raiz deste repositório.