FROM php:8.1-fpm-alpine

RUN apk add --no-cache shadow openssl bash mysql-client nodejs npm git \
    && docker-php-ext-install pdo pdo_mysql

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

