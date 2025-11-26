#!/bin/bash

npm install
npm run build
composer install --no-dev --optimize-autoloader
docker-compose --file docker-compose.nginx.yaml --env-file=.env build app
docker-compose --file docker-compose.nginx.yaml --env-file=.env up
