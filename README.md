## Instalação:

### Requisitos:

- Composer.
- PHP.
- MySQL.
- Servidor Apache.

### Criação de diretório virtual (Linux):

Abaixo segue os comandos para criação do diretório virtual:

**Comandos:**

```bash
# cria diretório virtual
$ sudo mkdir -p /var/www/html/teste.com.br

# Concede permissões
$ sudo chown -R $USER:$USER /var/www/html/teste.com.br

$ sudo chmod -R 755 /var/www/html/teste.com.br

# Cria novo arquivo Virtual Hosts
$ sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/teste.com.br.conf

# Abrir arquivo teste.com.br.conf para edição
$ sudo nano /etc/apache2/sites-available/teste.com.br.conf
```

Com o arquivo ***teste.com.br.conf*** aberto, apagar seu conteúdo e entrar com o que segue abaixo:

```text
<VirtualHost *:80>
	ServerAdmin admin@teste.com.br
	ServerName teste.com.br
	ServerAlias www.teste.com.br
	DocumentRoot /var/www/html/teste.com.br
	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined
	<Directory /var/www/html/teste.com.br/>
		Options Indexes FollowSymLinks
		AllowOverride All
		Require all granted
	</Directory>
</VirtualHost>
```
```bash
# Ativar o Virtual Host
$ sudo a2ensite teste.com.br.conf

# Reiniciar o Servidor Apache
$ sudo systemctl restart apache2

# Configurar arquivo de host local
$ sudo namo /etc/hosts
```
Com o arquivo ***hosts*** aberto, adicionar ao final do arquivo o que segue abaixo:

```text
127.0.0.2   teste.com.br
```

## Instalação dos arquivos:

Deve-se baixar o arquivo .zip ou realizar a clonagem do repositório.

Tendo os arquivos em sua maquina, deve-se copiar ou mover os arquivos para o diretório ***/var/www/html/teste.com.br***

A estrutua do diretório deve ficar como mostrado abaixo:

```text
teste.com.br
|---api/
|---assets/
|---.gitignore
|---.htaccess
|---add.html
|---details.html
|---edit.html
|---index.html
|---LICENSE
|---README.md
```

**Instalando as dependencias com composer:**

Acessar o diretório ***teste.com.br/api*** e usar o seguinte comando:

```bash
$ composer install
```

**Configurando usuário de acesso do Banco de Dados MySQL**

Acessar o diretório ***teste.com.br/api/app/config*** e abrir o arquivo mysql.ini

Seu conteúdo é mostrado abaixo:

```text
db_host=localhost
db_name=mobly_teste
db_utf8=utf8
db_user=<seu_nome_de_usuario_aqui>
db_pass=<sua_senha_de_usuario_aqui>
```
Apenas deve ser alterado ***db_user*** e ***db_pass*** com os seus valores de acesso para o MySQL

## Documentação:

Antes de executar a Aplicação, deve ser realizado a importação dos dados de usuários e posts.

Para realizar a importação, entre com a URL na barra de endereço do browser:

```text
teste.com.br/api/database/mysql
```

Após o acesso ao endereço acima, pode-se acessar a Aplicação na seguinte URL:

```text
teste.com.br
```

### Endpoints:

- Importar usuários e posts: `GET /api/database/mysql`

- Todos usuários: `GET /api/users`

- Usuário específico: `GET /api/users/{id}`

- Posts de um usuário: `GET /api/users/{id}/posts`


PROBLEMA
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


Observações
------------
* Inicialmente foi implementado o preencimento automatico de latitude e longitude, porem este recurso só funciona em conexões seguras (https), por este motivo foi removido.
* Não foi implementado validações de entradas de usuário no formulário no front-end e nem no back-end, sendo que em produção isto é obrigatório.

Captura de telas da solução
---------------------------
![Tela de index.html](https://github.com/adevecchi/rest-api-slim-php/blob/master/assets/images/screenshot/index.png)

![Tela de add.html](https://github.com/adevecchi/rest-api-slim-php/blob/master/assets/images/screenshot/add.png)

![Tela de edit.html](https://github.com/adevecchi/rest-api-slim-php/blob/master/assets/images/screenshot/edit.png)

![Tela de delete](https://github.com/adevecchi/rest-api-slim-php/blob/master/assets/images/screenshot/delete.png)

![Tela de details.html](https://github.com/adevecchi/rest-api-slim-php/blob/master/assets/images/screenshot/details1.png)

![Tela de details.html](https://github.com/adevecchi/rest-api-slim-php/blob/master/assets/images/screenshot/details2.png)
