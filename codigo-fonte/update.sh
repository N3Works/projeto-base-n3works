#!/bin/bash
if [-d "vendor"]; then
    echo "Atualizando o composer"
    php composer.phar update
else
    echo "Instalando o composer"
    php composer.phar install
fi

php artisan optimize
php composer.phar dump-autoload
php artisan migrate
php artisan queue:restart
php artisan queue:work --queue=filePdf &