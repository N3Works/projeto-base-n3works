<?php
return [
    'host'     => getenv('DB_PORT_3306_TCP_ADDR'),
    'port'     => getenv('DB_PORT_3306_TCP_PORT'),
    'dbname'   => getenv('DB_ENV_MYSQL_DATABASE'),
    'user'     => 'root',
    'password' => getenv('DB_ENV_MYSQL_ROOT_PASSWORD'),
];