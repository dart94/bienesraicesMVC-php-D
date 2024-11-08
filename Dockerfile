# Imagen base de PHP con Apache
FROM php:8.0-apache

# Instala extensiones de PHP y dependencias necesarias
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install mysqli pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Habilita mod_rewrite para Apache
RUN a2enmod rewrite

# Configura Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Cambia el DocumentRoot de Apache
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Define el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de composer primero para aprovechar la caché de capas
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copia la configuración personalizada de Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Copia los archivos del proyecto y ajusta permisos
COPY . .
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Variables de entorno para producción
ENV APP_ENV=production
ENV APP_DEBUG=false

# Expone el puerto de Apache
EXPOSE 80