# Stage 1: install dependencies
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs
COPY . .
RUN composer dump-autoload --optimize --no-dev

# Stage 2: runtime
FROM serversideup/php:8.3-fpm-nginx

ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    AUTORUN_ENABLED=true \
    SSL_MODE=off

COPY --chown=www-data:www-data --from=vendor /app /var/www/html
