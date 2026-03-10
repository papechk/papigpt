#!/bin/bash
set -e

# Railway/Render provides PORT env var
PORT=${PORT:-8080}

# Update Apache to listen on the correct port
sed -i "s/Listen 80$/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/*.conf

# Determine database configuration
# Render provides DB_* env vars when a PostgreSQL database is linked
DB_CONN=${DB_CONNECTION:-sqlite}

if [ "$DB_CONN" = "pgsql" ] && [ -n "$DB_HOST" ]; then
    # PostgreSQL mode — use the env vars provided by Render
    cat > /var/www/html/.env << EOF
APP_NAME=${APP_NAME:-PapiGPT}
APP_ENV=production
APP_KEY=${APP_KEY:-}
APP_DEBUG=false
APP_URL=${RENDER_EXTERNAL_URL:-https://papigpt.onrender.com}

DB_CONNECTION=pgsql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_STORE=database
QUEUE_CONNECTION=sync

LOG_CHANNEL=stack
LOG_LEVEL=error
EOF
else
    # SQLite fallback (local/no-DB deployments)
    cat > /var/www/html/.env << EOF
APP_NAME=${APP_NAME:-PapiGPT}
APP_ENV=production
APP_KEY=${APP_KEY:-}
APP_DEBUG=false
APP_URL=${RENDER_EXTERNAL_URL:-https://papigpt.onrender.com}

DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite

SESSION_DRIVER=file
SESSION_LIFETIME=120

CACHE_STORE=file
QUEUE_CONNECTION=sync

LOG_CHANNEL=stack
LOG_LEVEL=error
EOF

    # Create SQLite database file
    touch /var/www/html/database/database.sqlite
    chown www-data:www-data /var/www/html/database/database.sqlite
    chmod 664 /var/www/html/database/database.sqlite
fi

# Set permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate app key if not set
if ! grep -q "APP_KEY=base64:" /var/www/html/.env; then
    php artisan key:generate --force
fi

# Clear any cached config
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run migrations
php artisan migrate --force

# Seed database (only inserts missing data — seeder is idempotent)
php artisan db:seed --force || true

# Start Apache
exec apache2-foreground
