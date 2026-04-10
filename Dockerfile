FROM php:8.5-apache

RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite

COPY . /var/www/html/
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN chown -R www-data:www-data /var/www/html/var /var/www/html/public

EXPOSE 80