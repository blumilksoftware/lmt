FROM registry.blumilk.pl/internal-public/secops-tools-bin:v1.2.0@sha256:be2755b1afeeae009abdeeb61b7214776776df5b50c818c1546072563139d12c AS secops-tools-bin
FROM composer:2.8.12@sha256:5248900ab8b5f7f880c2d62180e40960cd87f60149ec9a1abfd62ac72a02577c AS composer
FROM node:24.11.0-bookworm-slim@sha256:76d0ed0ed93bed4f4376211e9d8fddac4d8b3fbdb54cc45955696001a3c91152 AS node

FROM php:8.3.26-fpm-bookworm@sha256:441301e421a9750686fcfcf43983e6e1971651003695857f2a633b808ce12d63 AS base

COPY --from=composer /usr/bin/composer /usr/bin/composer

# For other versions check: http://nginx.org/packages/mainline/debian/pool/nginx/n/nginx/
# renovate: datasource=github-tags depName=nginx/nginx extractVersion=^release-(?<version>.*)$
ARG NGINX_VERSION="1.29.3"

RUN apt-get update \
    && apt-get install --assume-yes gpg \
    && curl https://nginx.org/keys/nginx_signing.key | gpg --dearmour --output /etc/apt/trusted.gpg.d/apt.nginx.org.gpg > /dev/null \
    && echo "deb https://nginx.org/packages/mainline/debian bookworm nginx" | tee /etc/apt/sources.list.d/nginx.list \
    && apt-get update && apt-get install --assume-yes \
        nginx=${NGINX_VERSION}-1~bookworm \
        libzip-dev \
        libjpeg-dev \
        libpng-dev \
        libwebp-dev \
        libpq-dev \
        libicu-dev \
        supervisor \
        cron \
        exif \
     && docker-php-ext-configure \
         gd --with-jpeg --with-webp \
    && docker-php-ext-install \
        zip \
        gd \
        intl \
        exif \
        pdo_pgsql

COPY ./environment/.docker/app/entrypoint.sh /entrypoint.sh
COPY ./environment/.docker/app/nginx.conf /etc/nginx/nginx.conf

WORKDIR /application

ENTRYPOINT ["/entrypoint.sh"]

FROM base AS local

COPY --from=secops-tools-bin /usr/local/bin/age /usr/local/bin/age-keygen /usr/local/bin/sops /usr/local/bin/

RUN mv "${PHP_INI_DIR}/php.ini-development" "${PHP_INI_DIR}/php.ini"

ARG USER_NAME=host-user
ARG USER_ID=1000
ARG PHP_FPM_GROUP=www-data

RUN adduser \
        --disabled-password \
        --uid ${USER_ID} \
        ${USER_NAME} \
    && usermod \
        --append \
        --groups \
        ${PHP_FPM_GROUP} \
        ${USER_NAME}

# Add node, npm, npx binaries
COPY --from=node --chown=${USER_NAME}:root /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node --chown=${USER_NAME}:root /usr/local/bin/node /usr/local/bin/node
RUN ln --symbolic /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && chown --no-dereference ${USER_NAME}:root /usr/local/bin/npm \
    && ln --symbolic /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx \
    && chown --no-dereference ${USER_NAME}:root /usr/local/bin/npx

# renovate: datasource=github-tags depName=xdebug/xdebug
ARG XDEBUG_VERSION=3.4.7
ARG INSTALL_XDEBUG=false

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    pecl install xdebug-${XDEBUG_VERSION} \
    && docker-php-ext-enable xdebug \
;fi

FROM composer AS vendor-build

WORKDIR /app_composer_dependencies

COPY composer.json composer.lock ./

RUN composer install \
        --no-interaction \
        --no-plugins \
        --no-scripts \
        --no-dev \
        --prefer-dist \
        --ignore-platform-reqs

FROM node AS frontend-build

ARG ENVIRONMENT_ARG
ENV ENVIRONMENT=${ENVIRONMENT_ARG}

WORKDIR /app_frontend_dependencies

# last position is target directory
COPY package.json \
    package-lock.json \
    vite.config.js \
    ./

COPY ./environment/${ENVIRONMENT}/app/vite.${ENVIRONMENT}.env .env

RUN npm clean-install

COPY resources/js ./resources/js/
COPY resources/css ./resources/css/
COPY resources/views ./resources/views/

COPY --from=vendor-build /app_composer_dependencies/vendor/livewire ./vendor/livewire


RUN npm run build

FROM base AS production

ARG ENVIRONMENT_ARG
ENV ENVIRONMENT=${ENVIRONMENT_ARG}

RUN docker-php-ext-install \
    opcache

RUN mv "${PHP_INI_DIR}/php.ini-production" "${PHP_INI_DIR}/php.ini"

COPY ./environment/${ENVIRONMENT}/app/php.ini ${PHP_INI_DIR}/conf.d/zzz-overrides-php.ini
COPY ./environment/${ENVIRONMENT}/app/php-fpm.conf /usr/local/etc/php-fpm.d/zzz-overrides.conf
COPY ./environment/${ENVIRONMENT}/app/supervisord.conf /etc/supervisor/custom-supervisord.conf

# Copy Frontend build
COPY --chown=www-data:www-data --from=frontend-build /app_frontend_dependencies/public/build ./public/build/

# Copy Composer dependencies
COPY --chown=www-data:www-data --from=vendor-build /app_composer_dependencies/vendor ./vendor/

# Copy App files
COPY --chown=www-data:www-data . .

# Remove unnecessary files
RUN rm --recursive --force \
    vite.config.js \
    .dockerignore \
    environment/.docker \
    environment/dev

RUN composer dump-autoload --optimize

EXPOSE 80

ARG PROJECT_BUILD_VERSION_ARG
ENV PROJECT_BUILD_VERSION=${PROJECT_BUILD_VERSION_ARG}
