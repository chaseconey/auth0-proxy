#!/bin/sh
##
## Script run by on container start -- see Dockerfile
##

# Cache in Laravel
php artisan config:cache

# Make sqlite db available if chosen
touch database/database.sqlite

# Run Migrations
php artisan migrate --force

# Execute original docker start script
apache2-foreground