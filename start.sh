#!/bin/bash
set -e

# Update Apache port for dynamic $PORT injected by Railway
PORT="${PORT:-80}"
echo "Configuring Apache to listen on port ${PORT}..."
sed -i "s/Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/*.conf

# Fix AH00534: More than one MPM loaded
# Remove all MPM symlinks and ensure exclusively mpm_prefork is enabled
rm -f /etc/apache2/mods-enabled/mpm_*.load /etc/apache2/mods-enabled/mpm_*.conf
a2enmod mpm_prefork

# Ensure writable directories exist with full read/write permissions
mkdir -p /var/www/html/writable/cache \
         /var/www/html/writable/logs \
         /var/www/html/writable/session \
         /var/www/html/writable/debugbar \
         /var/www/html/public/uploads/avatars \
         /var/www/html/public/uploads/products

chmod -R 777 /var/www/html/writable /var/www/html/public/uploads

# Run database migrations and seed data if database is connected
if [ -n "$MYSQLHOST" ] || [ -n "$MYSQL_URL" ] || [ -n "$DATABASE_URL" ]; then
    echo "Database detected, running migrations..."
    php spark migrate --all --force || echo "Migration command completed or database unreachable."
    echo "Seeding default data (if not already seeded)..."
    php spark db:seed FourBeansSeeder || echo "Seeder finished or skipped."
fi

# Verify Apache configuration syntax
apache2ctl configtest || true

echo "Starting Apache web server on port ${PORT}..."
exec apache2-foreground
