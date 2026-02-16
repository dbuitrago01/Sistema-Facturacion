FROM php:8.2-fpm

# =========================
# 1. DEPENDENCIAS DEL SISTEMA
# =========================
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    curl \
    nodejs \
    npm \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        gd \
        zip \
        pdo \
        pdo_mysql \
        pdo_pgsql

# =========================
# 2. COMPOSER
# =========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# =========================
# 3. WORKDIR
# =========================
WORKDIR /var/www

# =========================
# 4. COPIAR PROYECTO
# =========================
COPY . .

# =========================
# 5. PERMISOS
# =========================
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# =========================
# 6. DEPENDENCIAS PHP
# =========================
RUN composer install --no-dev --optimize-autoloader

# =========================
# 7. VITE (ESTO ES LO CRÍTICO)
# =========================
RUN npm install
RUN npm run build

# =========================
# 8. STORAGE
# =========================
RUN mkdir -p /var/www/storage/framework/sessions \
    && chown -R www-data:www-data /var/www/storage \
    && chmod -R 775 /var/www/storage

# =========================
# 9. NGINX
# =========================
COPY nginx.conf /etc/nginx/nginx.conf

EXPOSE 10000

# =========================
# 10. START
# =========================
CMD php artisan config:clear \
    && php artisan cache:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && service nginx start \
    && php-fpm
