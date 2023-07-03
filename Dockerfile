# Create OS instance
FROM php:8.2-fpm-alpine3.18

# Install MySQL extensions and MySQL Client
RUN apk add --no-cache libzip-dev && \
    docker-php-ext-install pdo_mysql zip

# Set working directory
WORKDIR /var/www/html/

# Get and install Composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

# Copy code into container
COPY . .

# Install dependencies
RUN composer install

# Expose port to connect on
EXPOSE 8000