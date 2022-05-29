FROM php:7.4-fpm-alpine3.16

WORKDIR /app

RUN apk update && apk add git

RUN docker-php-ext-install sockets && docker-php-ext-enable sockets
