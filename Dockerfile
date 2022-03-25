FROM php:8.0-apache
#install system depencies
RUN apt-get update && apt-get install -y git curl zip unzip libpq-dev
# install php extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql bcmath
# install php extensions for postgres
RUN docker-php-ext-install pdo_pgsql
# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# copy project files
COPY . /var/www/
# setup working directory
WORKDIR /var/www/
# run composer install
RUN composer install
# run composer dump-autoload
RUN composer dump-autoload -o
# generate env file
RUN touch .env
# copy .env.example to .env
COPY .env.example .env


# setup apache
# copy apache config
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
# Prepare fake SSL certificate
RUN apt-get install -y ssl-cert
#install openssl
RUN apt-get install -y openssl
# generate self-signed certificate

RUN mkdir /etc/apache2/certificate
#change directory to /etc/apache2/certificate
WORKDIR /etc/apache2/certificate
RUN openssl req -new -newkey rsa:4096 -x509 -sha256 -days 365 -nodes -out apache-certificate.crt -keyout apache.key
# RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/apache2/ssl/apache.key -out /etc/apache2/ssl/apache.crt -subj "/C=US/ST=Denial/L=Springfield/O=Dis/CN=www.example.com"
# enable ssl
# enable mod_rewrite
RUN a2enmod rewrite
RUN a2enmod ssl
# enable headers
RUN a2enmod headers
# restart apache
RUN service apache2 restart
# expose port 80
EXPOSE 80
