FROM php:7.4-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip

RUN pecl install xdebug-3.1.6 && docker-php-ext-enable xdebug
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.client_port=9000" >> /usr/local/etc/php/php.ini
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -L https://phar.phpunit.de/phpunit-9.phar -o /usr/local/bin/phpunit && chmod +x /usr/local/bin/phpunit
WORKDIR /var/www/html
EXPOSE 9000
CMD ["php", "-S", "0.0.0.0:80"]