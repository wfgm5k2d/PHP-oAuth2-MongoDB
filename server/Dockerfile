FROM php:8.3-fpm

# Установка зависимостей и расширений
RUN apt-get update && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev git && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html

CMD composer install && php-fpm
