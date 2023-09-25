## Base de datos
BD: controlgastos\
Usuario: controlgastos\
Contraseña: XXXXXX

```
CREATE USER 'controlgastos'@'localhost' IDENTIFIED BY 'xxxxxx';
GRANT ALL PRIVILEGES ON controlgastos.*  TO 'controlgastos'@'localhost';
FLUSH PRIVILEGES;
```

## Instalación en sistema
```
cd /var/www/controlgastos/
composer install
npm install

/* Ojo si se necesita actualizar el comando npm */
npm install -g npm

cp .env.example .env
php artisan key:generate

npm run build

/* Para caso de Debian y Ubuntu */
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache

/* O para caso de de Arch y Manjaro */
sudo chmod +R 777 storage/
sudo chmod +R 777 bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
```

## Virtual Host en Apache
```
<VirtualHost *:80>
    ServerName   your-domain.com
    DocumentRoot "/var/www/html/your-domain.com/public/"
    ErrorLog     "/var/www/html/your-domain.com/error.log"
    CustomLog    "/var/www/html/your-domain.com/access.log" combined

    <Directory "/var/www/html/your-domain.com/public">
        Options +Indexes +FollowSymLinks
        DirectoryIndex index.php
        AllowOverride None
        Require all granted

        <IfModule mod_rewrite.c>
            <IfModule mod_negotiation.c>
                Options -MultiViews
            </IfModule>

            RewriteEngine On

            # Handle Front Controller...
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^ index.php [L]

            # Handle Authorization Header
            RewriteCond %{HTTP:Authorization} .
            RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
        </IfModule>
    </Directory>

</VirtualHost>
```



