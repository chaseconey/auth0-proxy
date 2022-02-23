#!/bin/sh
##
## Script run by on container start -- see Dockerfile
##

# Cache in Laravel
cd /var/www/php
php artisan config:cache

# Run Migrations
php artisan migrate --force

# Execute original docker start script
apache2-foreground