<?php

namespace OpenTribes\Core\Silex\Provider;

use OpenTribes\Core\Silex\Controller;
use OpenTribes\Core\Silex\Repository;
use OpenTribes\Core\Silex\Repository\DBALUserRepository;
use OpenTribes\Core\Silex\Service;
use OpenTribes\Core\Silex\Validator;
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
    }

    private function registerUseCases(Application $app)
    {
        $app['usecase.login'] = $app->share(function () use ($app) {
            return new LoginUseCase($app[Repository::USER], $app[Validator::LOGIN], $app[Service::PASSWORD_HASH]);
        });
        $app['usecase.registration'] = $app->share(function () use ($app) {
            return new RegistrationUseCase($app[Repository::USER], $app[Validator::REGISTRATION],
                $app[Service::PASSWORD_HASH]);
        });
    }

    private function registerController(Application $app)
    {

        $app[Controller::INDEX] = $app->share(function () use ($app) {
            return new Controller\IndexController($app['usecase.login']);
        });
        $app[Controller::ACCOUNT] = $app->share(function () use ($app) {
            return new Controller\AccountController($app['usecase.registration'], $app[Repository::USER]);
        });
        $app[Controller::CITY] = $app->share(function () use ($app) {
            return new Controller\CityController();
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