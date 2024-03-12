## lmt
### legnicki meetup technologiczny

![./screenshot.png](./screenshot.png)

### Installation

Install PHP dependencies

    composer install

Copy `.env.example` to `.env` and set your environment variables

    cp .env.example .env

Run container: 
```
make run
```

The website should be available at `localhost:8051` and `lmt.blumilk.localhost`  if we use a Blumilk local traefik proxy
