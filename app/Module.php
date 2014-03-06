<?php

namespace OpenTribes\Core;

use Igorw\Silex\ConfigServiceProvider;
use Mustache\Silex\Provider\MustacheServiceProvider;
use OpenTribes\Core\Controller\Account;
use OpenTribes\Core\Domain\ValidationDto\Registration as RegistrationValidatorDto;
use OpenTribes\Core\Mock\Service\PlainHash;
use OpenTribes\Core\Mock\Service\TestGenerator;
use OpenTribes\Core\Validator\Registration as RegistrationValidator;
use OpenTribes\Core\Repository\DBALUser as UserRepository;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\ServiceProviderInterface;

/**
 * Description of Module
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Module implements ServiceProviderInterface {

    private $env;

    public function __construct($enviroment) {
        $this->env = $enviroment;
    }

    public function boot(Application $app) {
        ;
    }

    public function register(Application $app) {

        $this->registerProviders($app);
        $this->createDependencies($app);
        $this->createRoutes($app);
    }

    private function createDependencies(&$app) {
        $app['service.passwordHasher'] = $app->share(function() {
            return new PlainHash;
        });
        $app['service.activationCodeGenerator'] = $app->share(function() {
            return new TestGenerator;
        });
        $app['repository.user'] = $app->share(function() use($app) {
            return new UserRepository($app['db']);
        });
        $app['validationDto.registration'] = $app->share(function() {
            return new RegistrationValidatorDto;
        });
        $app['validator.registration'] = $app->share(function() use($app) {
            return new RegistrationValidator($app['validationDto.registration'],$app['validator']);
        });
        $app['controller.account'] = $app->share(function() use($app) {
            return new Account($app['mustache'], $app['repository.user'], $app['service.passwordHasher'],$app['validator.registration'],$app['service.activationCodeGenerator']);
        });
    }

    private function registerProviders(&$app) {

        $app->register(new ValidatorServiceProvider);
        $app->register(new ServiceControllerServiceProvider());
        $app->register(new SessionServiceProvider());
        $app->register(new DoctrineServiceProvider());
        $app->register(new MustacheServiceProvider());
        $app->register(new TranslationServiceProvider());
        $configFile = realpath(__DIR__ . "/../config/" . $this->env . ".php");
        $app->register(new ConfigServiceProvider($configFile));
    }

    private function createRoutes(&$app) {

        $app->get('/', function() use($app) {
            return $app['mustache']->render('layout', array());
        });
        $app->match('/account/login', 'controller.account:loginAction')->method('GET|POST');
        $app->match('/account/create', 'controller.account:createAction')->method('GET|POST');

        $app->after(function() use($app) {
            $app['repository.user']->sync();
        });
    }

}
