.PHONY:  build run node php

PHP_SERVICE_NAME=php
build:
	docker compose build --no-cache --pull

run:
	docker compose up -d

php:
	docker compose exec ${PHP_SERVICE_NAME} ash

restart: stop run
