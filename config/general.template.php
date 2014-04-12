<?php

return array(
    'debug'         => true,
    'mustache.path' => realpath(__DIR__ . '/../templates'),
    'mustache.assets' => array(realpath(__DIR__ . '/../templates/assets')),
    'activationCodeLength' => 8,
    'mustache.options'     => array(
        'helpers' => array(
            'baseUrl' => '/'
        )
    ),
    'map.options'=>array(
        'viewportWidth'  => 1024,
        'viewportHeight' => 680,
        'width'          => 100,
        'height'         => 100,
        'tileHeight'     => 74,
        'tileWidth'      => 128
    )
);
