FROM php:8.2-fpm

RUN apt-get update
RUN apt-get install -y libfreetype-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

# RUN apt-get install -y apt-utils
# RUN apt-get install -y libpq-dev libzip-dev

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
# RUN docker-php-ext-install -j$(nproc) zip
# RUN docker-php-ext-install -j$(nproc) pgsql
# RUN docker-php-ext-install -j$(nproc) pdo_pgsql
RUN docker-php-ext-install pdo pdo_pgsql 
