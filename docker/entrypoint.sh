#!/bin/sh


echo "Aguardando banco de dados..."
until php -r "try { new PDO('mysql:host=${DB_HOST};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}'); echo '✅ Banco disponível'; exit(0); } catch (Exception \$e) { exit(1); }"; do
  sleep 3
done


php artisan migrate --force
php artisan db:seed --force || true   

# Sobe cron e aplicação
crond
exec php artisan serve --host=0.0.0.0 --port=8000
