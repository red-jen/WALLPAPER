web: php -S 0.0.0.0:8080 -t public/
release: php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache
