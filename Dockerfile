# Create OS instance
FROM php:8.2-apache

# Install MySQL extensions and MySQL Client
RUN apt-get update && apt-get install -y libzip-dev zlib1g-dev git && \
    docker-php-ext-install pdo_mysql zip

# Set working directory
WORKDIR /var/www/html/

# Get and install Composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

# Copy code into container
COPY . /var/www/html/

# Set the appropriate permissions
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod +x /var/www/html/scripts/dbtestdata.sh

# Enable Apache modules
RUN a2enmod rewrite

# Install dependencies
RUN composer install

# Update Apache port configuration
RUN sed -i 's/80/8000/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Update Apache virtual host configuration
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Expose port to connect on
EXPOSE 8000