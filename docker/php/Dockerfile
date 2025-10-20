# syntax=docker/dockerfile:1
ARG PHP_FPM_TAG=8.3-fpm-alpine
FROM php:${PHP_FPM_TAG}

# Install system dependencies for PHP extensions
RUN set -eux; \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS icu-dev libzip-dev oniguruma-dev libpng-dev freetype-dev libjpeg-turbo-dev; \
    apk add --no-cache bash icu-libs libzip oniguruma libpng freetype libjpeg-turbo git unzip; \
    docker-php-ext-configure gd --with-jpeg --with-freetype; \
    docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        mbstring \
        bcmath \
        zip \
        intl \
        gd \
        opcache; \
    pecl install redis && docker-php-ext-enable redis; \
    apk del .build-deps

# Copy Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# PHP config tweaks via environment or defaults
ENV PHP_MEMORY_LIMIT=512M \
    PHP_UPLOAD_MAX_FILESIZE=20M \
    PHP_POST_MAX_SIZE=21M \
    TZ=UTC

# Apply runtime PHP INI settings
RUN { \
      echo "memory_limit=${PHP_MEMORY_LIMIT}"; \
      echo "upload_max_filesize=${PHP_UPLOAD_MAX_FILESIZE}"; \
      echo "post_max_size=${PHP_POST_MAX_SIZE}"; \
      echo "date.timezone=${TZ}"; \
    } > /usr/local/etc/php/conf.d/laravel.ini

WORKDIR /app

# Expose PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]
