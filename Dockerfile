# Dockerfile
FROM php:5.5-apache

RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite

ADD ./web /var/www
ADD ./web/public /var/www/html
