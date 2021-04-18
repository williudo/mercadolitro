# MercadoLitro API

Neste repositório foi feito uma API em Laravel que simula um marketplace.  
Inspirada no Mercado Livre, mas claro, muito menor, as rotas está separado em 4 pastas:


## Requisitos

Para rodar este projeto, é necessário somente duas coisas:

1. `Internet` :laughing:
2. [`Docker instalado`](https://www.docker.com/products/docker-desktop)

## Composer

Baixe as dependências do laravel `/frontend` e lumen `/backend-challenge` executando em cada uma das pastas o comando no terminal: `composer install` 

## Configurações MYSQL

Para rodar a aplicação e os testes, será necessário criar dois banco de dados.
Pode escolher o nome que preferir, basta acessar a pasta [`/backend-laravel`](https://github.com/williudo/laravel-backend-frontend/tree/master/backend-challenge) e colocar as configurações de conexão do banco principal em `.env`, e colocar as configurações de conexão do banco de testes em `.env.testing`<br>

#### Migrations:
Após criado os bancos de dados, acesse a pasta do [`/backend-laravel`](https://github.com/williudo/laravel-backend-frontend/tree/master/backend-challenge) e rode o comando no terminal parar criar as tabelas: `php artisan migrate` 

#### Factories:
Ainda na pasta do backend [`/backend-laravel`](https://github.com/williudo/laravel-backend-frontend/tree/master/backend-challenge), precisamos popular a tabela de usuários rodando o seguinte comando no terminal: `php artisan db:seed`.

Será criado 5 usuários aleatórios, na tabela `users`, todos com a senha `1qaz2wsx`. Acesse o banco de dados para utilizar algum dos e-mails para login

## Tests
Se você tem instalado o phpunit e o tem cadastrado em suas variáveis de ambiente, basta acessar a pasta [`/backend-laravel`](https://github.com/williudo/laravel-backend-frontend/tree/master/backend-challenge) e rodar o comando: `phpunit`

![tests](https://user-images.githubusercontent.com/14855959/73621012-307c5900-4613-11ea-9dc4-ab33ca44ee7b.png)

## Rodando os projetos

Se você utilizar o apache, coloque no diretório de sua preferência e altere a variavél de ambiente `APP_URL` no arquivo `.env` dos dois projetos

## API Endpoints

- Autenticação:
  - login: `POST` `/login`
  - logout: `GET` `/logout`
  - refresh: `PUT` `/refresh`
  
- Usuários:
  - listar usuários: `GET` `/users`
  - Criar usuário: `POST` `/users/add`
  - Editar usuário: `POST` `/users/edit/{id}`
  - Excluir usuário (soft delete): `GET` `/users/delete/{id}` 
  
- Produtos:
  - listar produtos: `GET` `/products`
  - Criar produto: `POST` `/products/add`
  - Editar produto: `POST` `/products/edit/{id}`
  - Excluir produto (soft delete): `GET` `/products/delete/{id}`

## Dúvidas e sugestões

- Email: [willian.crodrigues90@gmail.com](mailto:willian.crodrigues90@gmail.com) 
- Github: [github.com/williudo](https://github.com/williudo/)
