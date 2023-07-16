# For use in Docker Container to seed DB with test data
cd /var/www/html
php artisan migrate
php artisan db:seed