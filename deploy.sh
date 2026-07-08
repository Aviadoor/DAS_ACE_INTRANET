#!/bin/bash

# 1. Instalar dependencias de PHP usando el composer interno de Azure
echo "Instalando dependencias de Composer..."
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php artisan down
php composer.phar install --no-dev --optimize-autoloader

# 2. Instalar y compilar NPM (Estilos)
echo "Compilando Node/NPM..."
npm install
npm run build

# 3. Configurar Nginx para que apunte a /public
echo "Configurando Nginx para Laravel /public..."
sed -i "s|root /home/site/wwwroot;|root /home/site/wwwroot/public;|g" /etc/nginx/sites-available/default
service nginx reload

# 4. Caché y Optimizaciones de Laravel
echo "Optimizando Laravel..."
php artisan optimize
php artisan up
