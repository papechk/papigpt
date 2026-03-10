#!/bin/bash
set -e

# Railway/Render provides PORT env var
PORT=${PORT:-8080}

# Update Apache to listen on the correct port
sed -i "s/Listen 80$/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/*.conf

# Create .env file if it doesn't exist
if [ ! -f /var/www/html/.env ]; then
    cat > /var/www/html/.env << EOF
APP_NAME=${APP_NAME:-PapiGPT}
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY:-}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost}
DB_CONNECTION=${DB_CONNECTION:-sqlite}
SESSION_DRIVER=${SESSION_DRIVER:-file}
CACHE_STORE=${CACHE_STORE:-file}
QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}
LOG_CHANNEL=stack
LOG_LEVEL=error
EOF
    chown www-data:www-data /var/www/html/.env
fi

# Generate app key if not set
if ! grep -q "APP_KEY=base64:" /var/www/html/.env; then
    php artisan key:generate --force
fi

# Create SQLite database if using sqlite and file doesn't exist
if [ "$DB_CONNECTION" = "sqlite" ]; then
    touch /var/www/html/database/database.sqlite
    chown www-data:www-data /var/www/html/database/database.sqlite
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
