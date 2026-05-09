FROM node:20 AS node-builder
WORKDIR /var/www
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

FROM php:8.2-cli
WORKDIR /var/www
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpng-dev libjpeg-dev libfreetype6-dev libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip gd
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .
COPY --from=node-builder /var/www/public/build /var/www/public/build
RUN composer install --no-dev --optimize-autoloader
EXPOSE 10000
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000
