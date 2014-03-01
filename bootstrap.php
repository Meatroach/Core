<?php

require_once __DIR__ . '/vendor/autoload.php';

use Silex\Application;
use OpenTribes\Core\Module as CoreModule;

$app = new Application;

$app->register(new CoreModule($env));

return $app;
