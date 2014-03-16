<?php

namespace OpenTribes\Core\Silex;

use Igorw\Silex\ConfigServiceProvider;
use Mustache\Silex\Provider\MustacheServiceProvider;
use OpenTribes\Core\Mock\Validator\ActivateUser as ActivateUserValidator;
use OpenTribes\Core\Silex\Controller;
use OpenTribes\Core\Silex\Controller\Account;
use OpenTribes\Core\Silex\Controller\Assets;
use OpenTribes\Core\Silex\Repository;
use OpenTribes\Core\Silex\Repository\DBALUser as UserRepository;
use OpenTribes\Core\Silex\Service;
use OpenTribes\Core\Silex\Service\CodeGenerator;
use OpenTribes\Core\Silex\Service\PasswordHasher;
use OpenTribes\Core\Silex\Validator;
use OpenTribes\Core\Silex\Validator\Registration as RegistrationValidator;
use OpenTribes\Core\ValidationDto\ActivateUser as ActivateUserValidatorDto;
use OpenTribes\Core\ValidationDto\Registration as RegistrationValidatorDto;
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
        $app[Service::ACTIVATION_CODE_GENERATOR] = $app->share(function() use($app) {
            return new CodeGenerator($app['activationCodeLength']);
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
        $app[Controller::ASSETS] = $app->share(function() use($app) {
            return new Assets($app['mustache.assets']);
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
        $this->loadConfigurations($app);
    }

    private function loadConfigurations(&$app) {
        $files = array(
            'general.php',
            'database.php',
            'email.php'
        );
        foreach ($files as $file) {
            $path = realpath(__DIR__ . '/../config/' . $this->env . '/' . $file);

            $app->register(new ConfigServiceProvider($path));
        }
    }

    private function createRoutes(&$app) {

        $app->get('/', function() use($app) {

                    $response          = new stdClass();
                    $response->failed  = false;
                    $response->proceed = false;
                    return $response;
                })->value('template', 'pages/landing')
                ->before(function(Request $request) {
                    if ($request->getSession()->get('username')) {
                        return new RedirectResponse('/game');
                    }
                });

        $app->mount('/assets', $this->getAssetsRoutes($app));
        $app->mount('/account', $this->getAccountRoutes($app));
        $app->mount('/game', $this->getGameRoutes($app));
        $app->on(KernelEvents::VIEW, function($event) use($app) {
            $appResponse = $event->getControllerResult();
            $request     = $event->getRequest();
            $requestType = $event->getRequestType();
            $response    = $appResponse;
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

                if (is_object($appResponse) && $appResponse->proceed && !$appResponse->failed && $request->attributes->has('successHandler')) {
                    $handler  = $request->attributes->get('successHandler');
                    $result   = $handler($appResponse);
                    if ($result)
                        $response = $result;
                }
            }
            $event->setResponse($response);
        });
    }

    private function getGameRoutes(&$app) {
        $game = $app['controllers_factory'];
        $game->get('/', function(Request $request) {
            $response           = new stdClass();
            $response->proceed  = false;
            $response->username = $request->getSession()->get('username');
            return $response;
        })->value('template', 'pages/game/landing');
        return $game;
    }

    private function getAssetsRoutes(&$app) {
        $assets = $app['controllers_factory'];

        $assets->assert('file', '.+');
        $assets->get('{type}/{file}', Controller::ASSETS . ':load');

        return $assets;
    }

    private function getAccountRoutes(&$app) {
        $account = $app['controllers_factory'];

        $account->post('/login', Controller::ACCOUNT . ':loginAction')
                ->value('template', 'pages/landing')
                ->value('successHandler', function($appResponse) use ($app) {

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

                    $request = $app['request'];

                    $appResponse->baseUrl = $request->getHttpHost();

                    $htmlBody = $app['mustache']->render('mails/html/register', $appResponse);
                    $textBody = $app['mustache']->render('mails/text/register', $appResponse);
                    $message  = Swift_Message::newInstance()
                            ->setSubject($app['subjects']['registration'])
                            ->setFrom(array($app['fromMails']['registration']))
                            ->setTo(array($appResponse->email))
                            ->setBody($htmlBody, 'text/html')
                            ->setBody($textBody, 'text/plain');
                    if (!$app['swiftmailer.options']['disable_delivery'])
                        $app['mailer']->send($message);
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
