# syntax=docker/dockerfile:1
ARG PHP_FPM_TAG=8.3-fpm
FROM php:${PHP_FPM_TAG}

# Install system dependencies for PHP extensions (Debian-based)
RUN set -eux; \
    apt-get update; \
    DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
      $PHPIZE_DEPS \
      git unzip ca-certificates curl pkg-config \
      libicu-dev libzip-dev zlib1g-dev \
      libonig-dev \
      libpng-dev libjpeg-dev libfreetype6-dev \
      libxml2-dev; \
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
    apt-get clean; rm -rf /var/lib/apt/lists/*

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

# Configure PHP-FPM pool settings for better performance
RUN set -eux; \
    sed -ri 's|^;?listen = .*$|listen = 9000|' /usr/local/etc/php-fpm.d/www.conf; \
    sed -ri 's|^;?pm = .*$|pm = dynamic|' /usr/local/etc/php-fpm.d/www.conf; \
    sed -ri 's|^;?pm.max_children = .*$|pm.max_children = 50|' /usr/local/etc/php-fpm.d/www.conf; \
    sed -ri 's|^;?pm.start_servers = .*$|pm.start_servers = 5|' /usr/local/etc/php-fpm.d/www.conf; \
    sed -ri 's|^;?pm.min_spare_servers = .*$|pm.min_spare_servers = 5|' /usr/local/etc/php-fpm.d/www.conf; \
    sed -ri 's|^;?pm.max_spare_servers = .*$|pm.max_spare_servers = 20|' /usr/local/etc/php-fpm.d/www.conf

WORKDIR /app

EXPOSE 9000

CMD ["php-fpm"]
