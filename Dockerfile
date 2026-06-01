# ចម្លងកូដចូលទៅក្នុង Container
COPY . /var/www/html

# បង្កើត File .env ចេញពី .env.example ដើម្បីឱ្យ Laravel មានកន្លែងអានទិន្នន័យ
RUN cp .env.example .env

# ផ្ដល់សិទ្ធិឱ្យ Folder storage របស់ Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# ដំឡើង Composer ផ្លូវការ
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

WORKDIR /var/www/html

EXPOSE 80

CMD php artisan key:generate && php artisan config:clear && php artisan cache:clear && php artisan migrate --force && apache2-foreground