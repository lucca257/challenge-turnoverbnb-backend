FROM php:8.1-fpm-alpine

RUN apk add --no-cache shadow openssl bash mysql-client nodejs npm git \
    && docker-php-ext-install pdo pdo_mysql

# Setup GD extension
RUN apk add --no-cache \
      freetype \
      libjpeg-turbo \
      libpng \
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
    && docker-php-ext-configure gd \
      --with-freetype=/usr/include/ \
      # --with-png=/usr/include/ \ # No longer necessary as of 7.4; https://github.com/docker-library/php/pull/910#issuecomment-559383597
      --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd \
    && apk del --no-cache \
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
    && rm -rf /tmp/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Setup working directory
WORKDIR /var/www

COPY --chown=1000:www-data ./ .

RUN rm -rf html && ln -s public html

RUN composer install \
    && chown -R 1000:www-data vendor

RUN chmod -R 777 /var/www/storage

EXPOSE 9000

CMD ./docker/app/entrypoint.sh

