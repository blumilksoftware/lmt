## lmt

### legnicki meetup technologiczny

![./screenshot.png](./screenshot.png)

### Docker environment:

Copy `.env.example` to `.env` and set your environment variables:

```
cp .env.example .env
```

Build app containers:

```
make build
```

Run containers:

```
make run
```

Enter the app container with `make shell`, then install php and node dependencies:

```
composer install
npm install
```

Run `php artisan storage:link`:

```
php artisan storage:link
```

Run `make dev` to build stylesheets:

```
make dev
```

Run `make lint` to check for lint issues:

```
make lint
```

Run `make lintf` to fix lint issues:

```
make lintf
```

The website should be available at [localhost:8051](localhost:8051) and [lmt.blumilk.localhost](lmt.blumilk.localhost)
if we use a Blumilk local traefik proxy.

| service | container name            | default external port |
|---------|---------------------------|-----------------------|
| app     | lmt-dev-app-container     | 8051                  |
| mailpit | lmt-dev-mailpit-container | 8052                  |
