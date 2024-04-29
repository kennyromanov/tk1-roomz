#!/bin/bash

cd ..
composer install
npm i
php artisan migrate
php artisan db:seed
