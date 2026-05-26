FROM php:8.2-apache

# Install required packages
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libssl-dev \
    libzstd-dev \
    pkg-config \
    ca-certificates

RUN docker-php-ext-install zip



# Enable Apache rewrite module
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html/interior-project

# Copy project files
COPY . /var/www/html/interior-project

# Set Apache document root to Laravel public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/interior-project/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Fix Git ownership issue
RUN git config --global --add safe.directory /var/www/html/interior-project

# Install Laravel dependencies
RUN composer install --ignore-platform-req=ext-mongodb

# Set permissions
RUN chown -R www-data:www-data /var/www/html/interior-project

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]