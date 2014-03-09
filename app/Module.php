<?php

namespace OpenTribes\Core;

use Igorw\Silex\ConfigServiceProvider;
use Mustache\Silex\Provider\MustacheServiceProvider;
use OpenTribes\Core\Controller;
use OpenTribes\Core\Controller\Account;
use OpenTribes\Core\Domain\ValidationDto\ActivateUser as ActivateUserValidatorDto;
use OpenTribes\Core\Domain\ValidationDto\Registration as RegistrationValidatorDto;
use OpenTribes\Core\Mock\Validator\ActivateUser as ActivateUserValidator;
use OpenTribes\Core\Repository;
use OpenTribes\Core\Repository\DBALUser as UserRepository;
use OpenTribes\Core\Service;
use OpenTribes\Core\Service\CodeGenerator;
use OpenTribes\Core\Service\PasswordHasher;
use OpenTribes\Core\Validator;
use OpenTribes\Core\Validator\Registration as RegistrationValidator;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;

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
        $app[Service::PASSWORD_HASHER] = $app->share(function() {
            return new PasswordHasher();
        });
        $app[Service::ACTIVATION_CODE_GENERATOR] = $app->share(function() {
            /**
             * TODO: move the length to config file
             */
            return new CodeGenerator(8);
        });
        $app[Repository::USER] = $app->share(function() use($app) {
            return new UserRepository($app['db']);
        });
        $app['validationDto.registration'] = $app->share(function() {
            return new RegistrationValidatorDto;
        });
        $app[Validator::REGISTRATION] = $app->share(function() use($app) {
            return new RegistrationValidator($app['validationDto.registration'], $app['validator']);
        });
        $app['validationDto.activate'] = $app->share(function() use($app) {
            return new ActivateUserValidatorDto;
        });
        $app[Validator::ACTIVATE] = $app->share(function() use($app) {
            return new ActivateUserValidator($app['validationDto.activate']);
        });
        $app[Controller::ACCOUNT] = $app->share(function() use($app) {
            return new Account($app['mustache'], $app[Repository::USER], $app[Service::PASSWORD_HASHER], $app[Validator::REGISTRATION], $app[Service::ACTIVATION_CODE_GENERATOR], $app[Validator::ACTIVATE]);
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
        $app->match('/account/login', Controller::ACCOUNT . ':loginAction')
                ->method('GET|POST')
                ->value('template', 'pages/login');
        $app->match('/account/create', Controller::ACCOUNT . ':createAction')
                ->method('GET|POST')
                ->value('template', 'pages/registration');
        $app->get('/account/activate/{username}/{activationKey}', Controller::ACCOUNT . ':activateAction')
                ->value('template', 'pages/activation');

        $app->on(KernelEvents::VIEW, function($event) use($app) {
            $response = $event->getControllerResult();

            $request = $event->getRequest();
            if ($request->attributes->has('template')) {
                $template = $request->attributes->get('template');
                $body     = $app['mustache']->render($template, $response);
                $response = new Response($body);
            }
            $event->setResponse($response);
        });
        $app->after(function() use($app) {

            $app[Repository::USER]->sync();
        });
    }

}
