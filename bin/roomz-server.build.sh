#!/bin/bash

# Starts the entire application
cd ..
npm run build
php artisan serve
