<?php

namespace OpenTribes\Core\Silex\Provider;


use OpenTribes\Core\Silex\Repository;
use OpenTribes\Core\Silex\Service;
use OpenTribes\Core\Silex\UseCase;
use OpenTribes\Core\Silex\Validator;
use OpenTribes\Core\UseCase\ListDirectionsUseCase;
use OpenTribes\Core\UseCase\LoginUseCase;
use OpenTribes\Core\UseCase\RegistrationUseCase;
use Silex\Application;
use Silex\ServiceProviderInterface;

class UseCaseServiceProvide implements ServiceProviderInterface{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {
        $app[UseCase::LOGIN] = $app->share(function () use ($app) {
            return new LoginUseCase(
                $app[Repository::USER],
                $app[Validator::LOGIN],
                $app[Service::PASSWORD_HASH]);
        });
        $app[UseCase::REGISTRATION] = $app->share(function () use ($app) {
            return new RegistrationUseCase(
                $app[Repository::USER],
                $app[Validator::REGISTRATION],
                $app[Service::PASSWORD_HASH]);
        });
        $app[UseCase::LIST_DIRECTIONS] = $app->share(function() use($app){
            return new ListDirectionsUseCase($app[Repository::DIRECTION]);
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