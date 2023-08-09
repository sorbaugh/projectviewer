# Use the official PHP image
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    postgresql-client \
    libpq-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql intl zip pdo_pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN npm install -g yarn

# Set the working directory to /var/www
WORKDIR /var/www

# Expose port 9000 to connect to the PHP-FPM server
EXPOSE 80

# Start PHP-FPM server
CMD ["php-fpm"]
