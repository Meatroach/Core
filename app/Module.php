<?php

namespace OpenTribes\Core;

use Igorw\Silex\ConfigServiceProvider;
use Mustache\Silex\Provider\MustacheServiceProvider;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use OpenTribes\Core\Domain\Context\Guest\Registration as RegistrationContext;
use OpenTribes\Core\Domain\Request\Registration as RegistrationRequest;
use OpenTribes\Core\Domain\Response\Registration as RegistrationResponse;
use OpenTribes\Core\Mock\Repository\User as UserRepository;
use OpenTribes\Core\Mock\Validator\Registration as RegistrationValidator;
use OpenTribes\Core\Domain\ValidationDto\Registration as RegistrationValidatorDto;
use OpenTribes\Core\Mock\Service\PlainHash;
use OpenTribes\Core\Mock\Service\TestGenerator;

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
        $app['repository.user'] = $app->share(function() {
            return new UserRepository();
        });
        $app['validationDto.registration'] = $app->share(function() {
            return new RegistrationValidatorDto;
        });
        $app['validator.registration'] = $app->share(function() use($app) {
            return new RegistrationValidator($app['validationDto.registration']);
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
        $app->match('/account/create', function(Request $request) use($app) {
            $username                = $request->get('username');
            $email                   = $request->get('email');
            $emailConfirm            = $request->get('emailConfirm');
            $password                = $request->get('password');
            $passwordConfirm         = $request->get('passwordConfirm');
            $termsAndConditions      = (bool) $request->get('termsAndConditions');
            $request                 = new RegistrationRequest($username, $email, $emailConfirm, $password, $passwordConfirm, $termsAndConditions);
            $context                 = new RegistrationContext($app['repository.user'], $app['validator.registration'], $app['service.passwordHasher'], $app['service.activationCodeGenerator']);
            $response                = new RegistrationResponse;
            $result                  = $context->process($request, $response);
            $response->isSuccessfull = $result;

            return $app['mustache']->render('pages/registration', $response);
        })->method('GET|POST');
    }

}
