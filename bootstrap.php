<?php

require_once __DIR__ . '/vendor/autoload.php';

use OpenTribes\Core\Silex\Module as CoreModule;
use Silex\Application;


$app = new Application;


$app->register(new CoreModule($env));

return $app;
