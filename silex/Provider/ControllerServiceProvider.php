<?php

namespace OpenTribes\Core\Silex\Provider;


use OpenTribes\Core\Mock\Repository\MockUserRepository;
use OpenTribes\Core\Mock\Service\PlainHasher;
use OpenTribes\Core\Mock\Validator\MockLoginValidator;
use OpenTribes\Core\Silex\Controller;
use OpenTribes\Core\Silex\Repository;
use OpenTribes\Core\Silex\Service;
use OpenTribes\Core\Silex\Validator;
use OpenTribes\Core\UseCase\LoginUseCase;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ControllerServiceProvider implements ServiceProviderInterface{
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
        $this->registerController($app);
    }
    private function registerValidators(Application $app){
        $app[Validator::LOGIN] = $app->share(function() use($app){
           return new MockLoginValidator();
        });
    }
    private function registerServices(Application $app){
        $app[Service::PASSWORD_HASHER] = $app->share(function() use($app){
            return new PlainHasher();
        });
    }
    private function registerRepositories(Application $app){
        $app[Repository::USER] = $app->share(function()  use($app){
           return new MockUserRepository();
        });
    }
    private function registerController(Application $app){

        $app[Controller::INDEX] = $app->share(function() use($app) {
            $loginUseCase = new LoginUseCase($app[Repository::USER],$app[Validator::LOGIN],$app[Service::PASSWORD_HASHER]);
            return new Controller\IndexController($loginUseCase);
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