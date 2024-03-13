PHP_SERVICE_NAME=app

CURRENT_USER_ID = $(shell id --user)
CURRENT_USER_GROUP_ID = $(shell id --group)

build:
	docker compose build --pull

run:
	docker compose up -d

stop:
	docker compose stop

restart: stop run

shell:
	docker compose exec --user ${CURRENT_USER_ID} ${PHP_SERVICE_NAME} bash

.PHONY:  build run stop restart shell
