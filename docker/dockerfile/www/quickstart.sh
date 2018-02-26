#!/bin/bash

/bin/chmod 777 -R /var/www/html/artisan
/bin/chmod guo+wr -R /var/www/html/storage

# Instalação
if [ ! -d "/var/www/html/vendor" ]; then

  /bin/sed -i 's/index.php/index.html/g' /var/www/html/public/.htaccess
  /bin/echo "<pre>" > /var/www/html/public/index.html

  /usr/local/bin/php /var/www/html/composer.phar self-update 2>> /var/www/html/public/index.html
  /usr/local/bin/php /var/www/html/composer.phar install -d /var/www/html  2>> /var/www/html/public/index.html

  /bin/sed -i 's/index.html/index.php/g' /var/www/html/public/.htaccess
  /bin/rm -f /var/www/html/public/index.html

fi

/usr/local/bin/php -f /var/www/html/artisan migrate
