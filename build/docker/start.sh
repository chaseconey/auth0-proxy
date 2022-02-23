#!/bin/sh
##
## Script run by on container start -- see Dockerfile
##

# Cache in Laravel
php artisan config:cache

# Run Migrations
php artisan migrate --force

# Make sqlite db available if chosen
touch database/database.sqlite

# Execute original docker start script
apache2-foreground