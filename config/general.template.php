<?php

return array(
    'debug' => true,
    'mustache.path' => realpath(__DIR__ . '/../templates'),
    'mustache.assets' => array(realpath(__DIR__ . '/../templates/assets')),
    'activationCodeLength' => 8,
    'mustache.options' => array(
        'cache' => realpath(__DIR__ . '/../cache'),
        'helpers' => array(
            'baseUrl' => '/'
        )
    ),
    'map.options' => array(
        'viewportWidth' => 896,
        'viewportHeight' => 592,
        'width' => 100,
        'height' => 100,
        'tileHeight' => 74,
        'tileWidth' => 128
    ),
    'directions'=>[
        'e'=>[
            'name'=>'East',
            'degree'=>[
                'min'=>-22.5,
                'max'=>22.5
            ]
        ],
        'es'=>[
            'name'=>'East-South',
            'degree'=>[
                'min'=>22.5,
                'max'=>67.5
            ]
        ],
        's'=>[
            'name'=>'South',
            'degree'=>[
                'min'=>67.5,
                'max'=>112.5
            ]
        ],
        'sw'=>[
            'name'=>'South-West',
            'degree'=>[
                'min'=>112.5,
                'max'=>157.5
            ]
        ],
        'w'=>[
            'name'=>'West',
            'degree'=>[
                'min'=>157.5,
                'max'=>-157.5
            ]
        ],
        'wn'=>[
            'name'=>'West-North',
            'degree'=>[
                'min'=>-157.5,
                'max'=>-112.5
            ]
        ],
        'n'=>[
            'name'=>'North',
            'degree'=>[
                'min'=>-112.5,
                'max'=>-67.5
            ]
        ],
        'ne'=>[
            'name'=>'North-East',
            'degree'=>[
                'min'=>-67.5,
                'max'=>-22.5
            ]
        ]
    ]
);
