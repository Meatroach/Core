<?php

namespace OpenTribes\Core\Silex\Provider;


use OpenTribes\Core\Silex\Validator;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ValidatorServiceProvider implements ServiceProviderInterface{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {
        $app[Validator::LOGIN] = $app->share(function () use ($app) {
            return new Validator\SymfonyLoginValidator($app['validator']);
        });
        $app[Validator::REGISTRATION] = $app->share(function () use ($app) {
            return new Validator\SymfonyRegistrationValidator($app['validator']);
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