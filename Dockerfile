FROM php:8.1-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer