<?php

require_once __DIR__ . '/vendor/autoload.php';

use OpenTribes\Core\Silex\Module as CoreModule;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

$app = new Application;
$app->before(function(Request $request) use ($app) {
    $app['mustache.options'] = array_merge_recursive($app['mustache.options'], array(
        'helpers' => array(
           'baseUrl' => $request->getBaseUrl() . '/'
  
        )
    ));
});

$app->register(new CoreModule($env));

return $app;
