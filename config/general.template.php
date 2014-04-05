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
        'width'=>900,
        'height'=>900
    )
);
