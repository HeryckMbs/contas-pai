#!/bin/bash

composer install && php artisan migrate --force && php artisan db:seed && php artisan serve --host=0.0.0.0 --port=80 
