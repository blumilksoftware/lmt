NODE_SERVICE_NAME=node
.PHONY: build run node

build:
	docker compose build --no-cache --pull

run:
	docker compose up -d

node:
	docker compose exec ${NODE_SERVICE_NAME} ash

dev:
	docker-compose exec ${NODE_SERVICE_NAME} npm run dev

staging-node:
	docker compose -f docker-compose.staging.yml exec ${NODE_SERVICE_NAME} ash

restart: stop run
