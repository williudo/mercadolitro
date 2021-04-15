FROM php:8-fpm

MAINTAINER Willian Rodrigues <willian.crodrigues90@gmail.com>

RUN apt-get update && apt-get install -y &&  apt-get install -y git && apt-get install -y libxml2-dev
RUN apt-get install nano
RUN apt-get install htop
RUN docker-php-ext-install soap
RUN docker-php-ext-install pdo pdo_mysql
#install some base extensions
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip
RUN echo "extension=pdo_mysql" > /usr/local/etc/php/php.ini-production
RUN apt-get install -y --no-install-recommends libbz2-dev zlib1g-dev && docker-php-ext-install zip bz2
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 80
