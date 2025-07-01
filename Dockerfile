FROM php:8.2-cli

# Установки системных зависимостей для работы laravel и PHP расширений с официальной доки 
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    unzip \
    libpq-dev \
    libonig-dev \
    libssl-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    opcache \
    intl \
    zip \
    bcmath \
    soap \
    && pecl install redis xdebug \
    && docker-php-ext-enable redis xdebug\
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


# чтобы использовать команды laravel без полного пути
ENV PATH="/root/.composer/vendor/bin:$PATH"

WORKDIR /var/www

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8000 --no-reload"]
