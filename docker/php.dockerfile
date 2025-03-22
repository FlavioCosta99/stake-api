FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    nodejs \
    libpng-dev libpq-dev libjpeg62-turbo-dev libfreetype6-dev \
    zip libzip-dev \
    unzip \
    git \
    curl \
    libonig-dev \
    apt-transport-https libicu-dev \
    wget ca-certificates \
    gnupg \
    lsb-release

RUN apt-get clean

RUN docker-php-ext-install pdo pgsql pdo_pgsql zip exif pcntl gd intl calendar
RUN docker-php-ext-configure intl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

USER www

EXPOSE 9000
CMD ["php-fpm"]