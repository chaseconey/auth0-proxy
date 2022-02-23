FROM php:8.0-apache

WORKDIR /var/www/html/

RUN apt update && \
  apt install -y g++ libicu-dev libpq-dev libzip-dev zip zlib1g-dev && \
  docker-php-ext-install intl opcache pdo pdo_mysql mysqli && \
  a2enmod rewrite && \
  service apache2 restart

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


COPY . .
COPY build/docker/vhost.conf /etc/apache2/sites-enabled/000-default.conf
COPY build/docker/start.sh /start.sh

RUN chmod +x /start.sh
RUN cd /var/www/html && composer install

CMD ["/bin/sh", "-c", "/start.sh"]