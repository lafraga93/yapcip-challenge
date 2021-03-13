#!/bin/bash

echo ""
echo "[...] - Criar arquivos de configuração"

cp .env-example .env
clear

echo ""
echo "[ X ] - Criar arquivos de configuração"
echo "[ X ] - Subir containers Docker"
echo "[...] - Instalar dependências do projeto via composer"

docker exec challenge-php composer install --prefer-dist --no-progress --quiet --no-interaction --no-suggest
clear

echo ""
echo "[ X ] - Criar arquivos de configuração"
echo "[ X ] - Subir containers Docker"
echo "[ X ] - Instalar dependências do projeto via composer"
echo "[...] - Executar database migrations e seeds"

docker exec challenge-php php artisan migrate
docker exec challenge-php php artisan db:seed
clear

echo ""
echo "[ X ] - Criar arquivos de configuração"
echo "[ X ] - Subir containers Docker"
echo "[ X ] - Instalar dependências do projeto via composer"
echo "[ X ] - Executar database migrations e seeds"

echo ""
echo "Enjoy! Projeto configurado com sucesso!"
echo ""