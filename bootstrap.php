<?php

require_once __DIR__ . '/vendor/autoload.php';

use OpenTribes\Core\Silex\Enviroment as Env;
use OpenTribes\Core\Silex\Module as CoreModule;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

$app = new Application;
//$env = Env::get();
$app->before(
    function (Request $request) use ($env, $app) {
        if ($env === Env::TEST && $request->cookies->has('username')) {
            $username = $request->cookies->get('username');
            /**
             * @var Session $session
             */
            $session =  $app['session'];
            $session->set('username', $username);
        }
    }
);
$app->register(new CoreModule($env));

return $app;
