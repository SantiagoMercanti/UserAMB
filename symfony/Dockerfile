FROM php:8.3-apache

# Herramientas para Composer (git/unzip) y soporte ZIP en PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zlib1g-dev \
 && docker-php-ext-configure zip \
 && docker-php-ext-install zip

# Extensiones necesarias p/ MySQL y performance
RUN docker-php-ext-install pdo pdo_mysql opcache

# Habilitar mod_rewrite para Symfony
RUN a2enmod rewrite

# VHost apuntando a /public
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Composer dentro del contenedor
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# (opcional pero útil en Docker)
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

# Dev: mostrar errores
RUN echo "error_reporting=E_ALL\ndisplay_errors=On\n" > /usr/local/etc/php/conf.d/dev.ini
