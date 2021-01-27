FROM php:7.2-fpm

ADD . /var/web
WORKDIR /var/web

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libmcrypt-dev \
    curl \
    git \
    libcurl4 \
    libcurl4-openssl-dev \
    zlib1g-dev \
    libicu-dev \
    libmemcached-dev \
    memcached \
    default-mysql-client \
    libmagickwand-dev \
    unzip \
    libzip-dev \
    libgd-dev \
    zip \
    nano


RUN apt-get update

RUN apt-get install -y libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
    libfreetype6-dev

# Install PHP extensions
RUN docker-php-ext-install gd

RUN apt-get update

RUN docker-php-ext-install pdo_mysql exif pcntl bcmath xml zip

RUN apt-get -y install nginx \
    && rm /etc/nginx/sites-enabled/default \
    && cp /var/web/nginx.conf /etc/nginx/conf.d/default.conf

ADD https://getcomposer.org/download/1.6.2/composer.phar /usr/bin/composer
RUN chmod +rx /usr/bin/composer

COPY .env.example .env

RUN composer install

RUN service nginx restart

EXPOSE 80
