#!/bin/bash
set -e

cd /var/www/html

# Generate .env kalau belum ada (Coolify biasanya inject ENV langsung, tapi Laravel tetap butuh file .env untuk sebagian fitur)
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generate APP_KEY kalau belum diset lewat environment variable
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    php artisan key:generate --force
fi

# Pastikan folder storage & database ada dan writable
mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache
touch database/database.sqlite || true
chown -R www-data:www-data storage bootstrap/cache database
chmod -R 775 storage bootstrap/cache database

# Symlink storage -> public/storage (idempotent)
php artisan storage:link || true

# Jalankan migration otomatis saat container start (aman untuk dijalankan berulang)
php artisan migrate --force

# Cache config, route, view untuk performa production
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
