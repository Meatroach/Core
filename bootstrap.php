<?php

require_once __DIR__ . '/vendor/autoload.php';

$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR']:'127.0.0.1';
$env = isset($_ENV['env'])?$_ENV['env']:'';
$environment = new \OpenTribes\Core\Silex\Environment($ip,$env);
error_reporting(-1);
ini_set('display_errors',1);
$app = new \Silex\Application();
$app['env'] = $environment->get();
$app->register(new \OpenTribes\Core\Silex\Module());

return $app;
