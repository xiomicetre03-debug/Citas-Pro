#!/bin/bash
set -e
mkdir -p database
touch database/database.sqlite
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data
mkdir -p storage/logs
chmod -R 777 storage bootstrap/cache
php artisan migrate:fresh --force --no-interaction
php artisan storage:link --force 2>/dev/null || true
exec php artisan serve --host=0.0.0.0 --port=$PORT
