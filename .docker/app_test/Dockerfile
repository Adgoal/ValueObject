FROM php:7.3-cli

RUN apt-get update && apt-get install -y git unzip

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1

RUN mkdir /.composer_cache
ENV COMPOSER_CACHE_DIR /.composer_cache

RUN mkdir /packages
COPY . /packages/ValueObject
WORKDIR /packages/ValueObject

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer -vvv global require hirak/prestissimo
RUN composer install
