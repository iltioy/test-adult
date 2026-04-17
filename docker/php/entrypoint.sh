#!/bin/sh
set -e

cd /var/www/html

if [ ! -d vendor ]; then
    echo ">>> Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

mkdir -p storage/smarty/compile storage/smarty/cache public/assets/css
chmod -R 777 storage

echo ">>> Compiling SCSS..."
php bin/compile-scss.php

exec "$@"
