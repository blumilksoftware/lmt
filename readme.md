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
task build
```

Run containers:

```
task run
```

Enter the app container with `task shell`, then install php and node dependencies:

```
composer install
npm install
```
Run `php artisan key:generate`:

```
php artisan key:generate
```

Run `php artisan storage:link`:

```
php artisan storage:link
```

Run `task dev` to build stylesheets:

```
task dev
```

Run `task lint` to check for lint issues:

```
task lint
```

Run `task lintf` to fix lint issues:

```
task lintf
```

The website should be available at [localhost:8051](localhost:8051) and [lmt.blumilk.localhost](lmt.blumilk.localhost)
if we use a Blumilk local traefik proxy.

| service   | container name    | default external port |
|-----------|-------------------|-----------------------|
| app       | lmt-app-local     | 8051                  |
| mailpit   | lmt-mailpit-local | 8052                  |                  
| database  | lmt-db-local      | 8055                  |  
