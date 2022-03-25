FROM composer:latest as build
WORKDIR /app
COPY . /app
RUN composer install

FROM php:8.0-apache
RUN apt-get update && apt-get install -y git curl zip unzip libpq-dev
# install php extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql bcmath
# install php extensions for postgres
RUN docker-php-ext-install pdo_pgsql

EXPOSE 8080
COPY --from=build /app /var/www/ 
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY .env.example /var/www/.env
RUN chmod 777 -R /var/www/storage/ && \
    echo "Listen 8080" >> /etc/apache2/ports.conf && \
    chown -R www-data:www-data /var/www/ && \
    a2enmod rewrite
