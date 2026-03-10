#!/bin/bash
set -e

# Railway/Render provides PORT env var
PORT=${PORT:-8080}

# Update Apache to listen on the correct port
sed -i "s/Listen 80$/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/*.conf

# Create .env file from environment variables
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

# Set permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create SQLite database
touch /var/www/html/database/database.sqlite
chown www-data:www-data /var/www/html/database/database.sqlite
chmod 664 /var/www/html/database/database.sqlite

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
php artisan migrate --force || true

# Seed database
php artisan db:seed --force || true

# Start Apache
exec apache2-foreground
