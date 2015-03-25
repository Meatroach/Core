<?php

require_once __DIR__ . '/vendor/autoload.php';
$environment = new \OpenTribes\Core\Silex\Environment();
$app = new \Silex\Application();
$app['env'] = $environment->get();
$app->register(new \OpenTribes\Core\Silex\Module());

return $app;
