<?php

return array(
    'debug'         => true,
    'mustache.path' => realpath(__DIR__ . '/../templates'),
    'db.options'    => array(
        'driver' => 'pdo_sqlite',
        'path'   => realpath(__DIR__ . '/../storage/ot.db'),
        'memory'=>true
    )
);
