FROM php:8.2.0-fpm

RUN apt-get update && docker-php-ext-install sqlite3

ADD ./php.ini /usr/local/etc/php/php.ini