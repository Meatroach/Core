<?php
namespace OpenTribes\Core\Silex\Provider;

use Silex\ControllerProviderInterface;
use Silex\Application;
use Opentribes\Core\Silex\Controller;

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
