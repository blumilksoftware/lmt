### PHP DEPENDENCIES ###
FROM composer:2.8.5@sha256:e0c9ac329256c25b0dee572df37d986570fb26bb6baaa7d0abe69b84181701e1 AS vendor

WORKDIR /app_composer_dependencies

COPY composer.json composer.lock ./

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --ignore-platform-reqs

### FRONTEND ###
FROM node:21.7.3-bookworm-slim@sha256:dfc05dee209a1d7adf2ef189bd97396daad4e97c6eaa85778d6f75205ba1b0fb AS frontend

WORKDIR /app_frontend_dependencies

COPY package.json package-lock.json ./

RUN npm clean-install

### APPLICATION ###
FROM php:8.4.3-fpm-bookworm@sha256:5148d67c6a67e00736c7a1be2e3b5287e370fd64d24f7777f5e39bf4c45b9175 AS app

COPY --from=vendor /usr/bin/composer /usr/local/bin/composer

# For other versions check: http://nginx.org/packages/mainline/debian/pool/nginx/n/nginx/
ARG NGINX_VERSION="1.25.4-1~bookworm"

RUN apt-get update \
    && apt-get install --assume-yes gpg \
    && curl https://nginx.org/keys/nginx_signing.key | gpg --dearmour --output /etc/apt/trusted.gpg.d/apt.nginx.org.gpg > /dev/null \
    && echo "deb https://nginx.org/packages/mainline/debian bookworm nginx" | tee /etc/apt/sources.list.d/nginx.list \
    && apt-get update && apt-get install --assume-yes \
        nginx=${NGINX_VERSION} \
        7zip \
        libzip-dev \
        supervisor \
        cron

RUN mv "${PHP_INI_DIR}/php.ini-production" "${PHP_INI_DIR}/php.ini"

COPY ./environment/prod/app/php.ini "${PHP_INI_DIR}/conf.d/zzz-overrides-php.ini"
COPY ./environment/prod/app/php-fpm.conf "/usr/local/etc/php-fpm.d/zzz-overrides.conf"
COPY ./environment/prod/app/nginx.conf "/etc/nginx/nginx.conf"
COPY ./environment/prod/app/supervisord.conf "/etc/supervisor/custom-supervisord.conf"
COPY ./environment/prod/app/entrypoint.sh /entrypoint.sh

WORKDIR /application

# Copy Frontend build
COPY --chown=www-data:www-data --from=frontend /app_frontend_dependencies/public/build ./public/build/

# Copy Composer dependencies
COPY --chown=www-data:www-data --from=vendor /app_composer_dependencies/vendor ./vendor/

# Copy App files
COPY --chown=www-data:www-data . .

RUN composer dump-autoload --optimize

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]

ARG DEPLOYMENT_PROJECT_VERSION_ARG
ENV DEPLOYMENT_VERSION=${DEPLOYMENT_PROJECT_VERSION_ARG}
