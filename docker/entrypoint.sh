#!/bin/bash

# Wait for database
echo "Waiting for database to be ready..."
until pg_isready -h db -U ${DB_USERNAME:-root}; do
  sleep 2
done

# Install dependencies if vendor/autoload.php doesn't exist
if [ ! -f "vendor/autoload.php" ]; then
    echo "Installing composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Create .env if it doesn't exist
if [ ! -f ".env" ]; then
    echo "Creating .env file..."
    cp .env.example .env
    php artisan key:generate
fi

# Run migrations and seeders
echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --force

# Execution
exec "$@"
