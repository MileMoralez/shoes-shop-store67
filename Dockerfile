# ចម្លងកូដចូលទៅក្នុង Container
COPY . /var/www/html

# បង្កើត File .env និងបង្ខំឱ្យវាចម្លងតម្លៃពី Environment Variables របស់ Render ចូលទៅក្នុងប្រព័ន្ធ Laravel ផ្ទាល់


# ផ្ដល់សិទ្ធិឱ្យ Folder storage របស់ Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# ដំឡើង Composer ផ្លូវការ
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

WORKDIR /var/www/html

EXPOSE 80

CMD php artisan config:clear && php artisan cache:clear && php artisan migrate --force && apache2-foreground