FROM php:8.3-cli-alpine

WORKDIR /app

RUN apk add --no-cache \
    bash \
    git \
    unzip \
    linux-headers \
    $PHPIZE_DEPS

RUN docker-php-ext-install sockets pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --optimize-autoloader

COPY . .

CMD ["php", "lab2_producer_template.php"]