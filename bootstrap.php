<?php
use OpenTribes\Core\Silex\Environment;

error_reporting(-1);
ini_set('display_errors',1);
require_once __DIR__ . '/vendor/autoload.php';

$environment = new Environment();
if(isset($_SERVER['REMOTE_ADDR'])){
    $environment->setIp($_SERVER['REMOTE_ADDR']);
}

$hasEnvVar = isset($_ENV['env']);
if ($hasEnvVar){
    $environment->set($_ENV['env']);
}

if ((null !== $env = getenv('env')) && !$hasEnvVar) {
    $environment->set($env);
}

if (isset($argv)) {
    if (0 < ($env = array_intersect($argv, [Environment::PRODUCTION, Environment::DEVELOP, Environment::TEST]))) {
        $environment->set(array_shift($env));
    }
}

$app = new \Silex\Application();
$app['env'] = $environment->get();
$app->register(new \OpenTribes\Core\Silex\Module());

return $app;
