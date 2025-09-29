FROM serversideup/php:8.4-fpm-nginx

USER root

ENV PHP_MAX_EXECUTION_TIME=30 \
    PHP_OPCACHE_ENABLE=1 \
    AUTORUN_ENABLED=true \
    AUTORUN_LARAVEL_CONFIG_CACHE=true \
    AUTORUN_LARAVEL_ROUTE_CACHE=true \
    AUTORUN_LARAVEL_VIEW_CACHE=true \
    AUTORUN_LARAVEL_MIGRATION=true \
    AUTORUN_LARAVEL_STORAGE_LINK=true

RUN install-php-extensions intl
USER www-data

COPY --chown=www-data:www-data . /var/www/html
VOLUME /var/www/html/storage/app
