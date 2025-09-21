FROM dunglas/frankenphp

RUN install-php-extensions \
    pcntl \
    pdo \
    gd \
    curl \
    mbstring \
    pdo_mysql \
    redis \
    intl

COPY . /app

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
