<?php

require_once __DIR__ . '/vendor/autoload.php';

$environment = new \OpenTribes\Core\Silex\Environment();
if(isset($_SERVER['REMOTE_ADDR'])){
    $environment->setIp($_SERVER['REMOTE_ADDR']);
}
if(isset($_ENV['env'])){
    $environment->set($_ENV['env']);
}
error_reporting(-1);
ini_set('display_errors',1);
$app = new \Silex\Application();
$app['env'] = $environment->get();
$app->register(new \OpenTribes\Core\Silex\Module());

return $app;
