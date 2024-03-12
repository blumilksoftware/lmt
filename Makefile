.PHONY:  build run node php

NODE_SERVICE_NAME=node
PHP_SERVICE_NAME=php
build:
	docker compose build --no-cache --pull

run:
	docker compose up -d

node:
	docker compose exec ${NODE_SERVICE_NAME} ash

node:
	docker compose exec ${PHP_SERVICE_NAME} ash

restart: stop run