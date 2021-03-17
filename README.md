[![Build Status](https://travis-ci.com/lafraga93/yapcip-challenge.svg?branch=main)](https://travis-ci.com/lafraga93/yapcip-challenge)
[![BCH compliance](https://bettercodehub.com/edge/badge/lafraga93/yapcip-challenge?branch=main)](https://bettercodehub.com/)

# challenge
A simple RESTFul API that simulates a money transactions between users

### Up Docker Containers
`cd docker && docker-compose down && docker-compose up -d && cd ../`

### Setup
`./docker/scripts/setup.sh`

> O script irá instalar as dependências PHP, rodar as migrations e popular as tabelas do banco de dados

### Documentação
* [Modelagem de Dados](https://github.com/lafraga93/yapcip-challenge/wiki/Modelagem-de-Dados)
* [Endpoints](https://github.com/lafraga93/yapcip-challenge/wiki/Endpoints)
* [Notificações](https://github.com/lafraga93/yapcip-challenge/wiki/Notifica%C3%A7%C3%B5es)

### Rodar suíte de testes de unidade
`docker exec -it challenge-php vendor/bin/phpunit`
