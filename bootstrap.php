<?php

require_once __DIR__ . '/vendor/autoload.php';
error_reporting(-1);
ini_set('display_errors',1);
$app = new \Silex\Application();

$app->register(new \OpenTribes\Core\Silex\Module());

return $app;
