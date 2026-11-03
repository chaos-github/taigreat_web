#!/bin/sh
set -e

cd /var/www/html

if [ ! -f vendor/autoload.php ]; then
    echo "Installing PHP dependencies..."
    if [ "${APP_ENV:-local}" = "production" ]; then
        composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
    else
        composer install --no-interaction --prefer-dist --optimize-autoloader
    fi
fi

mkdir -p \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
find storage bootstrap/cache -type d -exec chmod 750 {} \;
find storage bootstrap/cache -type f -exec chmod 640 {} \;

if [ "${1:-}" != "php-fpm" ]; then
    exec docker-php-entrypoint "$@"
fi

echo "Waiting for MySQL..."
until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); } catch (Exception \$e) { fwrite(STDERR, \$e->getMessage() . PHP_EOL); exit(1); }"; do
    sleep 2
done

if [ ! -f .env ]; then
    cp .env.example .env
fi

if ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --ansi --force
fi

if [ "${APP_ENV:-local}" = "production" ]; then
    php artisan security:check --no-interaction
else
    php artisan migrate --force --ansi
fi

exec docker-php-entrypoint "$@"
