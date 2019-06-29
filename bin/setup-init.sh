#!/usr/bin/env bash

if [[ ! -f phpunit.xml ]]; then
    cp phpunit.xml.dist phpunit.xml
fi

if [[ ! -f .env.local ]]; then
    cp .env .env.local
fi

composer install --prefer-dist -n -o

php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load -n

echo "Application is ready for work"