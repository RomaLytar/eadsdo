# Используем официальный PHP образ с PHP-FPM и необходимыми расширениями
FROM php:8.1-fpm

# Устанавливаем системные зависимости
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Устанавливаем PHP-расширения
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Устанавливаем рабочую директорию
WORKDIR /var/www

# Копируем существующую директорию приложения
COPY . .

# Устанавливаем зависимости PHP
RUN composer install

# Даём права на запись для storage и bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Открываем порт 9000 и запускаем PHP-FPM сервер
EXPOSE 9000
CMD ["php-fpm"]
