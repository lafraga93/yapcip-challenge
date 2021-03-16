# challenge
A simple RESTFul API that simulates a money transactions between users

### Up Docker Containers
`cd docker && docker-compose down && docker-compose up -d && cd ../`

### Setup Project
`./docker/scripts/setup.sh`

>Esse script irá gerar os arquivos de configuração necessários, instalar as dependências PHP via composer, rodar as migrations e popular as tabelas do banco de dados para que seja possível executar os testes de integração

---

### Documentação
* [Endpoints]()
* [Fluxo de notificação]()

### Unit Tests
`docker exec -it challenge-php vendor/bin/phpunit`
