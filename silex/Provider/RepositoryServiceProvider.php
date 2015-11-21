<?php

namespace OpenTribes\Core\Silex\Provider;


use OpenTribes\Core\Test\Mock\Repository\MockCityRepository;
use OpenTribes\Core\Silex\Repository;
use Silex\Application;
use Silex\ServiceProviderInterface;

class RepositoryServiceProvider implements ServiceProviderInterface {
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {
        $app[Repository::USER] = $app->share(function () use ($app) {
            return new Repository\DBALUserRepository($app['db']);
        });
        $app[Repository::CITY] = $app->share(function()use($app){
            return new MockCityRepository();
        });
        $app[Repository::DIRECTION] = $app->share(function()use($app){
            return new Repository\ConfigDirectionsRepository($app['directions']);
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {

    }

}