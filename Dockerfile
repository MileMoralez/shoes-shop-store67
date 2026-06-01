FROM php:8.2-apache

# ដំឡើង extensions ដែលចាំបាច់សម្រាប់ Laravel
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql gd

# បើក Apache rewrite module
RUN a2enmod rewrite

# កំណត់ផ្លូវទៅកាន់ public folder របស់ Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# ចម្លងកូដចូលទៅក្នុង Container
COPY . /var/www/html

# ផ្ដល់សិទ្ធិឱ្យ Folder storage របស់ Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# ដំឡើង Composer ផ្លូវការ
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

WORKDIR /var/www/html

EXPOSE 80