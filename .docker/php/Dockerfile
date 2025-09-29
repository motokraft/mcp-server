FROM php:8.2-fpm
COPY ./php/php.ini "$PHP_INI_DIR/php.ini"

RUN apt-get update

RUN apt-get -y install git libzip-dev libpng-dev

RUN docker-php-ext-install opcache
RUN docker-php-ext-install zip
RUN docker-php-ext-install gd

RUN docker-php-ext-enable opcache
RUN mkdir -p /tmp/opcache

RUN chown -R www-data:www-data /tmp/opcache
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer