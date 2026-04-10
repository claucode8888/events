FROM php:8.5-apache

RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite

COPY . /var/www/html/

# Crear las carpetas si no existen
RUN mkdir -p /var/www/html/var /var/www/html/public

# Configurar document root
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Dar permisos
RUN chown -R www-data:www-data /var/www/html/var /var/www/html/public

EXPOSE 80