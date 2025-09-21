#!/bin/bash

# Build FrankenPHP based container
npm install
npm run build
composer install --no-dev --optimize-autoloader
docker-compose -f franken-docker-compose.yaml build frankenphp

# Start FrankenPHP based test environment
docker-compose -f franken-docker-compose.yaml up
