## Instalação

```bash
$ git clone https://github.com/adevecchi/rest-api-slim-php.git
$ cd rest-api-slim-php
$ composer install
$ php -S localhost:8080 -t public
```

**Configurando usuário de acesso para o MySQL**

Acessar o arquivo ***config/mysql.ini***

Seu conteúdo é mostrado abaixo:

```ini
db_host=localhost
db_name=dvq_mob
db_utf8=utf8
db_user=<seu_nome_de_usuario_aqui>
db_pass=<sua_senha_de_usuario_aqui>
```
Apenas deve ser alterado ***db_user*** e ***db_pass*** com os seus valores de acesso para o MySQL.

O usuário de acesso do MySQL deve ter permissão para criar novo Banco de Dados e Tabelas, que será utilizado
para fazer a importação dos dados de uma API externa.

E a Aplicação Cliente de Exemplo vai acessar os dados importados para o MySQL.

### Importando os dados da API externa:

Entre com a URL na barra de endereço do browser conforme mostrado abaixo:

```text
localhost:8080/api/create/mysql/database
```

Isso vai ter como retorno a seguinte informação (Para usuário com as devidas permissões):

```json
{
    "code": 200,
    "status": "OK"
}
```

Contexto
========
1. Importe usuários e posts de uma API e guarde em um banco de dados MySQL
1. Possua uma tela para listar os usuários, com ações de adicionar, editar e excluir
1. Também é necessário ter uma tela de detalhes de usuário, para listar os posts de cada um deles
1. Tenha APIs que retornem os dados do banco de dados no formato JSON
   * Todos os usuários: **/users**
   * Usuário específico: **/users/{id}**
   * Posts de um usuário: **/users/{id}/posts**

## Fonte dos dados - APIs

**Usuários:**
http://jsonplaceholder.typicode.com/users

**Posts:**
http://jsonplaceholder.typicode.com/posts

Captura de tela
---------------

![Tela de index.html](https://github.com/adevecchi/rest-api-slim-php/blob/master/public/assets/images/screenshot/index.png)

![Tela de add.html](https://github.com/adevecchi/rest-api-slim-php/blob/master/public/assets/images/screenshot/add.png)

![Tela de edit.html](https://github.com/adevecchi/rest-api-slim-php/blob/master/public/assets/images/screenshot/edit.png)

![Tela de delete](https://github.com/adevecchi/rest-api-slim-php/blob/master/public/assets/images/screenshot/delete.png)

![Tela de details.html](https://github.com/adevecchi/rest-api-slim-php/blob/master/public/assets/images/screenshot/details-1.png)

![Tela de details.html](https://github.com/adevecchi/rest-api-slim-php/blob/master/public/assets/images/screenshot/details-2.png)

Endpoints
---------

- Todos usuários: `GET /users`

![Endpoint](https://github.com/adevecchi/rest-api-slim-php/blob/master/public/assets/images/screenshot/get-users.png)

- Usuário específico: `GET /users/{id}`

![Endpoint](https://github.com/adevecchi/rest-api-slim-php/blob/master/public/assets/images/screenshot/get-users-id.png)

- Posts de um usuário: `GET /users/{id}/posts`

![Endpoint](https://github.com/adevecchi/rest-api-slim-php/blob/master/public/assets/images/screenshot/get-users-id-posts.png)

