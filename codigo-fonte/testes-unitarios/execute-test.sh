#!/bin/bash

#cria a base para testes
php create-database.php

#muda o contexto da base para testes
DB_ENV_MYSQL_DATABASE=pgc_teste

#roda o artisian para criar o banco de dados 
cd ..
artisan migrate
composer dump-autoload
artisan db:seed --class=TesteBaseSeeder
#executa os testes unitários
phpunit

#dropa a base de dados de testes 
cd testes-unitarios
php drop-database.php
