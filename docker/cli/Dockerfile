FROM php:7.4-cli

LABEL maintainer="Sacha Telgenhof <me@sachatelgenhof.com>"

ENV COMPOSER_HOME $HOME/.composer

# System libraries & components
RUN apt-get update && apt-get install -y git zip zlib1g-dev libicu-dev g++

# We only want the xdebug module
RUN pecl install -f xdebug-2.9.4 \
    && rm -rf /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# PHP Extensions
RUN docker-php-ext-install intl

# Composer
RUN mkdir -p $COMPOSER_HOME/vendor/bin
RUN curl -sSL https://getcomposer.org/installer | \
    php -- --install-dir=$COMPOSER_HOME/vendor/bin --filename=composer

# Setup PATH to prioritize local composer bin and global composer bin ahead of system PATH.
ENV PATH vendor/bin:$COMPOSER_HOME/vendor/bin:$PATH

# PHP Configuration
RUN echo "memory_limit=-1" >> $PHP_INI_DIR/php.ini

# Packages
RUN composer global require hirak/prestissimo --no-plugins --no-scripts

CMD /bin/bash
