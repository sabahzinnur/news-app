FROM php:7.4-fpm

RUN apt-get update \
    && apt-get install -y -qq --no-install-recommends \
    apt-utils \
    libpq-dev \
    libmcrypt-dev \
    libxml2-dev \
    libgd-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    mcrypt \
    unzip \
    git \
    zip

RUN docker-php-ext-install \
    tokenizer \
    pdo_pgsql \
    pgsql \
    opcache \
    bcmath \
    ctype \
    iconv \
    exif \
    soap \
    json \
    intl \
    xml \
    zip \
    gd

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j "$(nproc)" gd

RUN pecl install xdebug-2.9.4 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure exif --enable-exif


# Composer and it dependecies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
