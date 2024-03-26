FROM php:8.2-fpm

# Установка необходимых пакетов
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip mysqli

WORKDIR /var/www/html


