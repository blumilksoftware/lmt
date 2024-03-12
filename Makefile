.PHONY:  build run node

build:
	docker compose build --no-cache --pull

run:
	docker compose up -d

restart: stop run
