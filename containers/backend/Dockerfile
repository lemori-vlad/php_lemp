ARG PHP_VERSION
ARG COMPOSER_VERSION

FROM composer:${COMPOSER_VERSION} AS composer

FROM php:${PHP_VERSION} AS backend

# Working dir
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y  \
    git \
    zip \
    unzip
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#enable extensions for working with db
RUN docker-php-ext-install mysqli pdo pdo_mysql  \
    && docker-php-ext-enable pdo_mysql

# composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

