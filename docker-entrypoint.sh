#!/bin/bash
set -e

# Railway provides PORT env var
PORT=${PORT:-8080}

# Update Apache to listen on the correct port
sed -i "s/Listen 80$/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/*.conf

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations
php artisan migrate --force 2>/dev/null || true

# Seed if database is empty
php artisan db:seed --force 2>/dev/null || true

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache
exec apache2-foreground
