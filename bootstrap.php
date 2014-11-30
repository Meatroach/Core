<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = new \Silex\Application();
$env = new \OpenTribes\Core\Silex\Environment();

$app->register(new \OpenTribes\Core\Silex\Module($env->get()));

return $app;
