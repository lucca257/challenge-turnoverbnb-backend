#!/bin/bash
echo "***** SETTING UP ENV *****"
cp .env.example .env
php artisan key:generate

echo "***** RUNNING MIGRATIONS *****"
php artisan migrate

php-fpm
