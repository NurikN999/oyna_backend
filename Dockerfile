FROM php:8.1-fpm-alpine

# Install pdo, pdo_mysql, curl, composer, and shadow
RUN docker-php-ext-install pdo pdo_mysql && \
    apk add --no-cache curl shadow && \
    curl -sS https://getcomposer.org/installer | php -- \
         --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .
RUN composer install --no-plugins --no-scripts --ignore-platform-reqs

# Change the UID and GID of www-data to 1000
RUN usermod -u 1000 www-data && \
    groupmod -g 1000 www-data

# Change the ownership and permissions of the storage and bootstrap/cache directories
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache
