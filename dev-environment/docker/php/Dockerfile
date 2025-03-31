FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    unzip \
    git \
    curl \
    pkg-config \
    libssl-dev \
    && docker-php-ext-install intl zip pdo pdo_mysql

RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

RUN apt-get install -y librabbitmq-dev && \
    pecl install amqp && \
    docker-php-ext-enable amqp

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www