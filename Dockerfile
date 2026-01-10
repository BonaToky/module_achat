FROM php:8.2-fpm

# Installer les dépendances et PDO MySQL
RUN apt-get update && apt-get install -y \
        default-mysql-client \
        libonig-dev \
        libzip-dev \
        unzip \
        && docker-php-ext-install pdo pdo_mysql mbstring zip


