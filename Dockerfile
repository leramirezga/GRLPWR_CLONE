 # Dockerfile
 FROM php:7.2.7-apache
# php pluggins
 RUN docker-php-ext-install pdo_mysql
 RUN a2enmod rewrite
# php x-debug
 RUN apt-get update &&\
     apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git &&\
     rm -rf /var/lib/apt/lists/*

 RUN pecl install xdebug-2.6.1 && docker-php-ext-enable xdebug
 RUN echo 'zend_extension="/usr/local/lib/php/extensions/no-debug-non-zts-20151012/xdebug.so"' >> /usr/local/etc/php/php.ini
 RUN echo 'xdebug.remote_port=9000' >> /usr/local/etc/php/php.ini
 RUN echo 'xdebug.remote_enable=1' >> /usr/local/etc/php/php.ini
 RUN echo 'xdebug.remote_connect_back=1' >> /usr/local/etc/php/php.ini

 RUN curl -sS https://getcomposer.org/installer | php \
         && mv composer.phar /usr/local/bin/ \
         && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

 WORKDIR /var/www/html