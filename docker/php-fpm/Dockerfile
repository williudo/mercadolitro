FROM php:7.4-fpm

MAINTAINER Willian Rodrigues <willian.crodrigues90@gmail.com>

RUN apt-get update && apt-get install -y &&  apt-get install -y git && apt-get install -y libxml2-dev
RUN apt-get install nano
RUN apt-get install htop
RUN docker-php-ext-install soap
RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install redis && docker-php-ext-enable redis

# install xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo "zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20160303/xdebug.so" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# relevant to this answer
RUN echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_host=docker.for.win.localhost" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

#install some base extensions
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip
RUN echo "extension=pdo_mysql" > /usr/local/etc/php/php.ini-production
RUN apt-get install -y --no-install-recommends libbz2-dev zlib1g-dev && docker-php-ext-install zip bz2
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 80
