FROM php:8.2.1-fpm

RUN apt-get update
RUN apt-get install libicu-dev sqlite3 libsqlite3-dev libzip-dev zlib1g-dev -y

ADD ./php.ini /usr/local/etc/php/php.ini