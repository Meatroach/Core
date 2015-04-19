<?php

namespace OpenTribes\Core\Silex\Provider;

use OpenTribes\Core\Mock\Repository\MockCityRepository;
use OpenTribes\Core\Mock\Repository\MockDirectionRepository;
use OpenTribes\Core\Silex\Controller;
use OpenTribes\Core\Silex\Repository;
use OpenTribes\Core\Silex\Repository\DBALUserRepository;
use OpenTribes\Core\Silex\Service;
use OpenTribes\Core\Silex\UseCase;
use OpenTribes\Core\Silex\Validator;
use OpenTribes\Core\UseCase\ListDirectionsUseCase;
use OpenTribes\Core\UseCase\LoginUseCase;
use OpenTribes\Core\UseCase\RegistrationUseCase;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ControllerServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        $this->registerRepositories($app);
        $this->registerServices($app);
        $this->registerValidators($app);
        $this->registerUseCases($app);
        $this->registerController($app);
    }

    private function registerValidators(Application $app)
    {
        $app[Validator::LOGIN] = $app->share(function () use ($app) {
            return new Validator\SymfonyLoginValidator($app['validator']);
        });
        $app[Validator::REGISTRATION] = $app->share(function () use ($app) {
            return new Validator\SymfonyRegistrationValidator($app['validator']);
        });
    }

    private function registerServices(Application $app)
    {
        $app[Service::PASSWORD_HASH] = $app->share(function () use ($app) {
            return new Service\DefaultPasswordHashService();
        });
    }

    private function registerRepositories(Application $app)
    {
        $app[Repository::USER] = $app->share(function () use ($app) {
            return new DBALUserRepository($app['db']);
        });
        $app[Repository::CITY] = $app->share(function()use($app){
           return new MockCityRepository();
        });
        $app[Repository::DIRECTION] = $app->share(function()use($app){
           return new MockDirectionRepository();
        });
    }

    private function registerUseCases(Application $app)
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

    private function registerController(Application $app)
    {

        $app[Controller::INDEX] = $app->share(function () use ($app) {
            return new Controller\IndexController($app[UseCase::LOGIN]);
        });
        $app[Controller::ACCOUNT] = $app->share(function () use ($app) {
            return new Controller\AccountController($app[UseCase::REGISTRATION], $app[Repository::USER]);
        });
        $app[Controller::CITY] = $app->share(function () use ($app) {
            return new Controller\CityController(
                $app[UseCase::LIST_DIRECTIONS],
                $app[Repository::USER],
                $app[Repository::CITY]);
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
        // TODO: Implement boot() method.
    }

} 