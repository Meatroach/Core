<?php

return array(
    'db.options' => array(
        'driver' => 'pdo_sqlite',
        
        'memory'=>true,
        'path'   => realpath(__DIR__ . '/../../storage/ot.db'),
    )
);
