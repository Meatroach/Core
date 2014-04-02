<?php

return array(
    'db.options' => array(
        /**
         * pdo_mysql | pdo_sqlite
         */
        'driver'   => 'pdo_sqlite',
        'host'     => 'localhost',
        'dbname'   => 'opentribes',
        'user'     => 'username',
        'password' => 'password',
        'charset'  => 'utf8',
        'memory'   => true,
        'path'     => realpath(__DIR__.'/../storage/ot.db')
    )
);
