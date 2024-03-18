## lmt
### legnicki meetup technologiczny

![./screenshot.png](./screenshot.png)

### Docker environment:
Copy `.env.example` to `.env` and set your environment variables:
```
cp .env.example .env
```

Build APP containers:
```
make build
```

Run containers:
```
make run
```

Enter the APP container with `make shell`, then install php, node dependencies and compile css:
```
composer install
npm install
```

Run `make tailwind` to build stylesheets:
```
  make tailwind
```

The website should be available at [localhost:8051](localhost:8051) and [lmt.blumilk.localhost](lmt.blumilk.localhost) if we use a Blumilk local traefik proxy.

| service           | container name            | default external port |
|-------------------|---------------------------|-----------------------|
| app               | lmt-dev-app-container     | 8051                  |
| mailpit           | lmt-dev-mailpit-container | 8052                  |
