# Usa una imagen base de PHP con Apache
FROM php:8.0-apache

# Instala extensiones de PHP y dependencias necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql mysqli zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Habilita mod_rewrite para Apache
RUN a2enmod rewrite

# Define el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de composer primero para aprovechar la caché de capas
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

COPY .env /var/www/html/.env

# Copia los archivos de la aplicación
COPY . .

# Configura permisos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Copia la configuración personalizada de Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Expone el puerto de Apache
EXPOSE 80
