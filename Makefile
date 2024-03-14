include .env

SHELL := /bin/bash

DOCKER_COMPOSE_FILE = docker-compose.yml
DOCKER_COMPOSE_APP_CONTAINER = app

CURRENT_USER_ID = $(shell id --user)
CURRENT_USER_GROUP_ID = $(shell id --group)
CURRENT_DIR = $(shell pwd)
PHP_SERVICE_NAME=app

build:
	docker compose build --pull

run:
	docker compose up -d

tailwind:
	npx tailwindcss -i ./styles.css -o ./public/output.css

stop:
	docker compose stop

restart: stop run

shell:
	@docker compose exec --user ${CURRENT_USER_ID} ${PHP_SERVICE_NAME} bash

encrypt-prod-secrets:
	@$(MAKE) encrypt-secrets SECRETS_ENV=prod

decrypt-prod-secrets:
	@$(MAKE) decrypt-secrets SECRETS_ENV=prod AGE_SECRET_KEY=${SOPS_AGE_PROD_SECRET_KEY}

decrypt-secrets:
	@docker compose --file ${DOCKER_COMPOSE_FILE} exec --user "${CURRENT_USER_ID}:${CURRENT_USER_GROUP_ID}" --env SOPS_AGE_KEY=${AGE_SECRET_KEY} ${DOCKER_COMPOSE_APP_CONTAINER} \
		bash -c "echo 'Decrypting ${SECRETS_ENV} secrets' \
			&& cd ./environment/prod/deployment/${SECRETS_ENV} \
			&& sops --decrypt --input-type=dotenv --output-type=dotenv --output .env.${SECRETS_ENV}.secrets.decrypted .env.${SECRETS_ENV}.secrets \
			&& echo 'Done'"

encrypt-secrets:
	@docker compose --file ${DOCKER_COMPOSE_FILE} exec --user "${CURRENT_USER_ID}:${CURRENT_USER_GROUP_ID}" ${DOCKER_COMPOSE_APP_CONTAINER} \
		bash -c "echo 'Encrypting ${SECRETS_ENV} secrets' \
			&& cd ./environment/prod/deployment/${SECRETS_ENV} \
			&& sops --encrypt --input-type=dotenv --output-type=dotenv --output .env.${SECRETS_ENV}.secrets .env.${SECRETS_ENV}.secrets.decrypted \
			&& echo 'Done'"

.PHONY:  build run tailwind stop restart shell
