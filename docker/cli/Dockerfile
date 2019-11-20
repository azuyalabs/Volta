FROM php:7.3-cli

# We only want the xdebug module
RUN pecl install -f xdebug-2.7.2 \
    && rm -rf /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
