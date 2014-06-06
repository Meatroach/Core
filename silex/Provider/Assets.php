<?php
namespace OpenTribes\Core\Silex\Provider;

use Opentribes\Core\Silex\Controller;
use Silex\Application;
use Silex\ControllerProviderInterface;

class Assets implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $assets = $app['controllers_factory'];

        $assets->assert('file', '.+');
        $assets->get('{type}/{file}', Controller::ASSETS . ':load');

        return $assets;
    }
}
