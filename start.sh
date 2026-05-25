#!/bin/bash
mkdir -p database
touch database/database.sqlite
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data
mkdir -p storage/logs
chmod -R 775 storage bootstrap/cache
php artisan migrate:fresh --force
php artisan storage:link --force || true
php artisan serve --host=0.0.0.0 --port=$PORT
