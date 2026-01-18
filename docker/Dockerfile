FROM php:8.2-fpm-alpine

WORKDIR /var/www

RUN apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev \
        libzip-dev \
        libxml2-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        oniguruma-dev \
    && apk add --no-cache \
        icu-libs \
        libzip \
        libxml2 \
        libpng \
        libjpeg-turbo \
        freetype \
        nodejs \
        npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        dom \
        exif \
        gd \
        intl \
        mbstring \
        opcache \
        pdo_mysql \
        simplexml \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

COPY docker/php-fpm/dev/php.ini $PHP_INI_DIR/php.ini

CMD ["php-fpm"]
