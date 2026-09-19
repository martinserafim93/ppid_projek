# Nginx Server
FROM php:8.5-fpm-bookworm

# Install dependencies untuk PHP extensions
RUN rm -rf /var/lib/apt/lists/* && \
    apt-get clean && \
    apt-get update --fix-missing && \
    apt-get install -y --no-install-recommends \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libmariadb-dev \
        libicu-dev \
        libonig-dev \
        libzip-dev \
        unzip \
        git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
        gd \
        pdo_mysql \
        mysqli \
        intl \
        mbstring \
        zip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copy php.ini
COPY php.ini /usr/local/etc/php/conf.d/custom.ini
