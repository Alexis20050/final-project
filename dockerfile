FROM php:8.4-apache

# Install system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libpq-dev libzip-dev libonig-dev libxml2-dev libpng-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip mbstring xml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache rewrite
RUN a2enmod rewrite

# Use port 10000 (Render default)
RUN sed -i 's/Listen 80/Listen 10000/g' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/g' /etc/apache2/sites-available/000-default.conf

# Set document root to Laravel's public folder
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Allow .htaccess override
RUN printf '<Directory /var/www/html/public>\n\
AllowOverride All\n\
Require all granted\n\
</Directory>\n' > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Create a temporary .env file with a dummy key so that Artisan commands run during build
RUN echo "APP_ENV=production" > .env && \
    echo "APP_KEY=base64:dummykeyfordockerbuildonly1234567890==" >> .env

# Install PHP dependencies – skip scripts to avoid package:discover failure
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Now manually run package:discover (it will succeed because we have a .env)
RUN php artisan package:discover

# Copy the rest of the application
COPY . .

# Install Node dependencies and build assets
RUN npm install && npm run build

# Generate Laravel caches (requires the dummy .env, but that's fine for build)
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Prepare directories and fix permissions
RUN mkdir -p storage/framework/cache storage/framework/sessions \
    storage/framework/views bootstrap/cache public/uploads \
    && chown -R www-data:www-data storage bootstrap/cache public/uploads \
    && chmod -R 775 storage bootstrap/cache public/uploads

# Create entrypoint script – it will generate a real APP_KEY at runtime
RUN printf '#!/bin/bash\n\
set -e\n\
# Generate fresh app key if not already set in .env\n\
if ! grep -q "^APP_KEY=" .env 2>/dev/null || [ -z "$(grep "^APP_KEY=" .env | cut -d"=" -f2)" ]; then\n\
    php artisan key:generate --force --no-interaction\n\
fi\n\
# Create storage symlink\n\
php artisan storage:link || true\n\
# Run migrations\n\
php artisan migrate --force || true\n\
# Start Apache\n\
apache2-foreground\n' > /usr/local/bin/entrypoint.sh \
    && chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 10000
CMD ["entrypoint.sh"]