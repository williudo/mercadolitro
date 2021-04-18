<p align="center">
  <img width="250" src="https://github.com/williudo/mercadolitro/blob/master/docs/MercadoLitroPequeno.png?raw=true">
</p>

# MercadoLitro API

Neste repositório foi feito uma API em Laravel que simula um marketplace de bebidas.  
Inspirada no Mercado Livre, mas claro, muito menor.


## Índice

Para testar este projeto, basta seguir os tópicos a seguir:

1. [`Configurar o arquivo hosts do sistema operacional`](#hosts-config)
2. [`Docker`](#docker-config)
2. [`Migrations e Seeders`](#db-config)
3. [`Documentação da API`](#doc-config)
4. [`Testes e Debugs`](#tests-config)


## <a name="hosts-config"></a> Configurar o arquivo hosts do sistema operacional

A url local utilizada para este projeto é http://mercadolitro.local  
Será necessário configurar no arquivos hosts do sistema operacional, para ser acessível.  
Caso não saiba como fazer, basta acessar esse link:  

[`https://suporte.hostgator.com.br/hc/pt-br/articles/115000391994-Como-funciona-o-arquivo-hosts-`](https://suporte.hostgator.com.br/hc/pt-br/articles/115000391994-Como-funciona-o-arquivo-hosts-)

## <a name="docker-config"></a> Docker

Nesta aplicação, há 4 containers, sendo eles:

1. Servidor Nginx
2. PHP-FPM v7.4+
3. MySql v5.7
4. Redis (utilizado no laravel em filas e cache)

Com o docker instalado, rode o commando abaixo na raiz do projeto, mas iniciar os containers:  
```
docker-compose up -d --build
```

## <a name="db-config"></a>Migrations e Seeders:

Foi criado as migrations para versionamento das tabelas do banco de dados, e seeders para popular o banco automaticamente.  
Com isso, será possível testar todos os endepoints.   

No windows, acessar o terminal do docker via aplicativo e rodar:
```
php artisan migrate
php artisan db:seed

```
No linux é necessário primeiro, acessar o bash do container:
```
Dado que já sabe o container_id do php-fpm:
docker exec -it <container_id> /bin/bash
php artisan migrate
php artisan db:seed
```
## <a name="doc-config"></a> Documentação da API

Após seguir todos os passos acima, a aplicação já estará disponível em: [http://mercadolitro.local](http://mercadolitro.local)  
As rotas que exigem autenticação, é necessário passar no header um access_token no padrão JWT. O mesmo o usuário obtém, logando em `/api/login`.

Todos os usuários que foram criados pelo comando de seed executado no tópico anterior, possuem a senha: "1qaz2wsx".  
Abaixo consta um resumo dos endpoints desta API, mas para melhor testar, criei uma collection do POSTMAN, que está disponível neste link: 

[https://documenter.getpostman.com/view/10597917/TzJsexjq](https://documenter.getpostman.com/view/10597917/TzJsexjq) 

Resumo:
- Autenticação:
  - login: `POST` `/api/login`
  - logout: `GET` `/api/logout`
  - refresh: `PUT` `/api/refresh`
  
- Usuários:
  - listar usuários: `GET` `/api/users`
  - criar usuário: `POST` `/api/users/add`
  - editar usuário: `PUT` `/api/users/edit/{id}`
  - excluir usuário (soft delete): `DELETE` `/api/users/delete/{id}` 
  
- Produtos:
  - listar produtos: `GET` `/api/products`
  - criar produto: `POST` `/api/products/add`
  - editar produto: `POST` `/api/products/edit/{id}`
  - excluir produto (soft delete): `DELETE` `/api/products/delete/{id}`
  
- Pedidos:
  - listar pedidos: `GET` `/api/orders`
  - enviar pedido: `PUT` `/api/orders/ship/{id}`
  - cancelar pedido (soft delete): `DELETE` `/api/orders/cancel/{id}`

## <a name="tests-config"></a>Testes e Debugs

Para rodar o teste, e também gerar o coverage do php unit, basta executar o comando:  

No windows, acessar o terminal do docker via aplicativo e rodar:
```
php artisan test
```
No linux é necessário primeiro, acessar o bash do container:
```
Dado que já sabe o container_id do php-fpm:

docker exec -it <container_id> /bin/bash
php artisan test
```
#### Teste executados e coverage
![tests](https://github.com/williudo/mercadolitro/blob/master/docs/tests.png?raw=true)   
![coverage](https://github.com/williudo/mercadolitro/blob/master/docs/coverage_phpunit.png?raw=true)
