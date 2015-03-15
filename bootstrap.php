<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = new \Silex\Application();

$app->register(new \OpenTribes\Core\Silex\Module());

return $app;
