FROM php:8.2-fpm

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

COPY . .

RUN apt-get update && apt-get -y upgrade \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get install -y \
        curl \
        nginx \
        nodejs \
        npm \
        zip unzip \
        libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && rm -rf /var/lib/apt/lists/* 
    
COPY nginx.conf /etc/nginx/sites-available
RUN ln -s /etc/nginx/sites-available/nginx.conf /etc/nginx/sites-enabled/

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

RUN npm i \
    && npm run build

RUN composer update \
    && composer install --no-interaction --optimize-autoloader    

EXPOSE 80
# CMD php-fpm --daemonize && nginx -g "daemon off;"