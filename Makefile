NODE_SERVICE_NAME=node
.PHONY:  build run node

build:
	docker compose build --no-cache --pull

run:
	docker compose up -d

tailwind:
	npx tailwindcss -i ./styles.css -o ./public/output.css

restart: stop run