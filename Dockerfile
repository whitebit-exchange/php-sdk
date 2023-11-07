# Set the base image for subsequent instructions
FROM php:8.2-cli

RUN apt-get update

RUN apt-get install -qq  \
    git  \
    curl  \
    libmcrypt-dev  \
    libjpeg-dev  \
    libpng-dev  \
    libfreetype6-dev  \
    libbz2-dev \
    libzip-dev \
    zip

RUN apt-get clean

RUN pecl install pcov && \
    docker-php-ext-enable pcov

RUN docker-php-ext-install zip

RUN curl --silent --show-error "https://getcomposer.org/installer" | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app