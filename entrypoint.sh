#!/bin/sh
echo "Iniciando o servidor..."

# Migrate database, if necessary
php artisan migrate

# Serve the Laravel application
php artisan serve --host=0.0.0.0 --port=80
