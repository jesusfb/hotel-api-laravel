#!/bin/sh

# FIX FOR NGINX
mkdir /run/openrc
touch /run/openrc/softlevel
mkdir -p /run/nginx

cd /var/www

php artisan migrate:fresh --seed
php artisan cache:clear
php artisan route:cache
php artisan key:generate
sudo chmod o+w ./storage/ -R

/usr/bin/supervisord -c /etc/supervisord.conf
