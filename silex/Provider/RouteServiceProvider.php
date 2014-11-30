<?php

namespace OpenTribes\Core\Silex\Provider;


use OpenTribes\Core\Silex\Controller;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class RouteServiceProvider implements ControllerProviderInterface{
    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        /**
         * @var ControllerCollection $collection
         */
        $collection = $app['controllers_factory'];
        $collection
            ->match('/', Controller::INDEX . ':indexAction')
            ->method('GET')
            ->value('template', 'pages/landing');
        $collection
            ->match('/account/create', Controller::ACCOUNT . ':indexAction')

            ->method('POST|GET')
            ->value('template', 'pages/registration');
        return $collection;
    }

} 