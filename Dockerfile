FROM php:8.1-apache

RUN apt-get update && \
    apt-get install --yes --force-yes libgd-dev zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev libwebp-dev


RUN docker-php-ext-install mysqli
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp &&\
    docker-php-ext-install gd