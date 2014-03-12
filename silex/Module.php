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
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\ServiceProviderInterface;
use stdClass;
use Swift_Message;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
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
            return new Account($app[Repository::USER], $app[Service::PASSWORD_HASHER], $app[Validator::REGISTRATION], $app[Service::ACTIVATION_CODE_GENERATOR], $app[Validator::ACTIVATE]);
        });
    }

    private function registerProviders(&$app) {

        $app->register(new ValidatorServiceProvider);
        $app->register(new ServiceControllerServiceProvider());
        $app->register(new SessionServiceProvider());
        $app->register(new DoctrineServiceProvider());
        $app->register(new MustacheServiceProvider());
        $app->register(new TranslationServiceProvider());
        $app->register(new SwiftmailerServiceProvider());
        $configFile = realpath(__DIR__ . "/../config/" . $this->env . ".php");
        $app->register(new ConfigServiceProvider($configFile));
    }

    private function createRoutes(&$app) {

        $app->get('/', function() use($app) {

            $response          = new stdClass();
            $response->failed  = false;
            $response->proceed = false;
            return $response;
        })->value('template', 'pages/landing');

        $app->mount('/account', $this->getAccountRoutes($app));
        /**
         * TODO: this general stuffs will be moved outside of core module
         */
        $app->on(KernelEvents::VIEW, function($event) use($app) {
            $appResponse = $event->getControllerResult();
            $request     = $event->getRequest();
            $requestType = $event->getRequestType();
            if ($requestType === HttpKernelInterface::SUB_REQUEST) {
                $response = new JsonResponse($appResponse);
            }
            if ($request->attributes->has('subRequests')) {
                $subRequests = $request->attributes->get('subRequests');
                $tmpResponse = $appResponse;

                foreach ($subRequests as $values) {
                    $uri         = $values['url'];
                    $method      = $values['method'];
                    $param       = $values['param'];
                    $subRequest  = Request::create($uri, $method, $param);
                    $subResponse = $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
                    $content     = json_decode($subResponse->getContent());
                    $appResponse = (object) array_merge((array) $appResponse, (array) $content);
                }
                $appResponse = (object) array_merge((array) $appResponse, (array) $tmpResponse);
            }
            if ($requestType === HttpKernelInterface::MASTER_REQUEST) {
                if ($request->attributes->has('template')) {
                    $template = $request->attributes->get('template');
                    $body     = $app['mustache']->render($template, $appResponse);
                    $response = new Response($body);
                }

                if ($appResponse->proceed && !$appResponse->failed && $request->attributes->has('successHandler')) {
                    $handler  = $request->attributes->get('successHandler');
                    $result   = $handler($appResponse);
                    if ($result)
                        $response = $result;
                }
            }
            $event->setResponse($response);
        });
    }

    private function getAccountRoutes(&$app) {
        $account = $app['controllers_factory'];

        $account->post('/login', Controller::ACCOUNT . ':loginAction')
                ->value('template', 'pages/landing')
                ->value('successHandler', function($appResponse) use ($app) {
                    if ($app['session']->isStarted())
                        $app['session']->set('username', $appResponse->username);

                    return new RedirectResponse('/');
                })
                ->value('subRequests', array(
                    array(
                        'url'    => '/',
                        'method' => 'GET',
                        'param'  => array())
        ));
        $account->match('/create', Controller::ACCOUNT . ':createAction')
                ->method('GET|POST')
                ->value('successHandler', function($appResponse) use ($app) {
                    
                    $request              = $app['request'];
                   
                    $appResponse->baseUrl = $request->getHttpHost();
                    
                    $htmlBody             = $app['mustache']->render('mails/html/register', $appResponse);
                    $textBody             = $app['mustache']->render('mails/text/register', $appResponse);
                    $message              = Swift_Message::newInstance()
                            ->setSubject($app['subjects']['registration'])
                            ->setFrom(array($app['noreply']))
                            ->setTo(array($appResponse->email))
                            ->setBody($htmlBody, 'text/html')
                            ->setBody($textBody, 'text/plain');
                  
                             //$app['mailer']->send($message);
                   
               
                })
                ->value('template', 'pages/registration');
                
        $account->match('/activate', Controller::ACCOUNT . ':activateAction')
                ->method('GET|POST')
                ->value('template', 'pages/activation');
        $account->get('/activate/{username}/{activationKey}', Controller::ACCOUNT . ':activateAction')
                ->value('template', 'pages/activation');

        $account->after(Controller::ACCOUNT . ':after');

        return $account;
    }

}
