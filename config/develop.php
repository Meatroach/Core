<?php

return array(
    'debug'               => true,
    'mustache.path'       => realpath(__DIR__ . '/../templates'),
    'db.options'          => array(
        'driver' => 'pdo_sqlite',
        'path'   => realpath(__DIR__ . '/../storage/ot.db'),
    ),
    'subjects'=>array(
        'registration'=>'Welcome to OpenTribes'
    ),
    'noreply'=>'noreply@domain',
    'swiftmailer.options' => array(
        'host'       => 'host',
        'port'       => '25',
        'username'   => 'username',
        'password'   => 'password',
        'encryption' => null,
        'auth_mode'  => null
    )
);
