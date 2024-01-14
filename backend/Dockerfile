FROM php:8.2-cli

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql pgsql\
    && apt-get update \
    && apt-get install -y zip unzip \
    && composer install


EXPOSE 8000

# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]


