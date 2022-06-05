#!/bin/bash


echo "***** SETTING ENV *****"
cp .env.example .env
php artisan key:generate

#echo "*****RUNNING MIGRATION *****"
#php artisan migrate

php-fpm
