# challenge
A simple RESTFul API that simulates a money transactions between users

### Up Docker Containers
`cd docker && docker-compose down && docker-compose up -d && cd ../`

### Setup
`./docker/scripts/setup.sh`

> Irá innstalar as dependências PHP, rodar as migrations e popular as tabelas do banco de dados

### Documentação
* [Modelagem de Dados]()
* [Endpoints]()
* [Notificações]()
* [Melhorias]()

### Rodar suíte de testes de unidade
`docker exec -it challenge-php vendor/bin/phpunit`
