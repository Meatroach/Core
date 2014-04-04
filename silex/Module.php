<?php

namespace OpenTribes\Core\Silex;

use DateTime;
use Igorw\Silex\ConfigServiceProvider;
use Mustache\Silex\Provider\MustacheServiceProvider;
use OpenTribes\Core\Mock\Service\LocationCalculator;
use OpenTribes\Core\Mock\Validator\ActivateUser as ActivateUserValidator;
use OpenTribes\Core\Silex\Controller;
use OpenTribes\Core\Silex\Controller\Account;
use OpenTribes\Core\Silex\Controller\Assets;
use OpenTribes\Core\Silex\Controller\City;
use OpenTribes\Core\Silex\Repository;
use OpenTribes\Core\Silex\Repository\DBALCity as CityRepository;
use OpenTribes\Core\Silex\Repository\DBALMap as MapRepository;
use OpenTribes\Core\Silex\Repository\DBALMapTiles as MapTilesRepository;
use OpenTribes\Core\Silex\Repository\DBALUser as UserRepository;
use OpenTribes\Core\Silex\Service;
use OpenTribes\Core\Silex\Service\CodeGenerator;
use OpenTribes\Core\Silex\Service\PasswordHasher;
use OpenTribes\Core\Silex\Validator;
use OpenTribes\Core\Silex\Validator\Registration as RegistrationValidator;
use OpenTribes\Core\ValidationDto\ActivateUser as ActivateUserValidatorDto;
use OpenTribes\Core\ValidationDto\Registration as RegistrationValidatorDto;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\ServiceProviderInterface;
use stdClass;
use Swift_Message;
use Swift_NullTransport;
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
        $this->loadConfigurations($app);
        $this->createDependencies($app);
        $this->createRoutes($app);
    }

    private function createDependencies(Application &$app) {
        $this->createRepositories($app);
        $this->createServices($app);
        $this->createValidators($app);
        $this->createControllers($app);

        if ($this->env === 'test') {
            $app['swiftmailer.transport'] = $app->share(function() {
                return new Swift_NullTransport();
            });
        }
    }

    private function createControllers(Application &$app) {
        $app[Controller::ACCOUNT] = $app->share(function() use($app) {
            return new Account($app[Repository::USER], $app[Service::PASSWORD_HASHER], $app[Validator::REGISTRATION], $app[Service::ACTIVATION_CODE_GENERATOR], $app[Validator::ACTIVATE]);
        });
        $app[Controller::ASSETS] = $app->share(function() use($app) {
            return new Assets($app['mustache.assets']);
        });

        $app[Controller::CITY] = $app->share(function() use($app) {
            return new City($app[Repository::USER], $app[Repository::CITY], $app[Repository::MAP_TILES], $app[Service::LOCATION_CALCULATOR]);
        });
    }

    private function createServices(Application &$app) {

        $app[Service::PASSWORD_HASHER] = $app->share(function() {
            return new PasswordHasher();
        });
        $app[Service::ACTIVATION_CODE_GENERATOR] = $app->share(function() use($app) {
            return new CodeGenerator($app['activationCodeLength']);
        });
        $app[Service::LOCATION_CALCULATOR] = $app->share(function() use($app) {
            return new LocationCalculator;
        });
    }

    private function createRepositories(Application &$app) {
        $app[Repository::USER] = $app->share(function() use($app) {
            return new UserRepository($app['db']);
        });
        $app[Repository::CITY] = $app->share(function() use($app) {
            return new CityRepository($app['db']);
        });
        $app[Repository::MAP] = $app->share(function() use($app) {
            return new MapRepository($app['db']);
        });
        $app[Repository::MAP_TILES] = $app->share(function() use($app) {
            return new MapTilesRepository($app['db']);
        });
    }

    private function createValidators(Application &$app) {
        $app['validationDto.registration'] = $app->share(function() {
            return new RegistrationValidatorDto;
        });
        $app['validationDto.activate'] = $app->share(function() use($app) {
            return new ActivateUserValidatorDto;
        });
        $app[Validator::REGISTRATION] = $app->share(function() use($app) {
            return new RegistrationValidator($app['validationDto.registration'], $app['validator']);
        });

        $app[Validator::ACTIVATE] = $app->share(function() use($app) {
            return new ActivateUserValidator($app['validationDto.activate']);
        });
    }

    /**
     * @param Application $app
     */
    private function registerProviders(Application &$app) {

        $app->register(new ValidatorServiceProvider);
        $app->register(new ServiceControllerServiceProvider());
        $app->register(new SessionServiceProvider());
        $app->register(new DoctrineServiceProvider());
        $app->register(new MustacheServiceProvider());
        $app->register(new TranslationServiceProvider());
        $app->register(new SwiftmailerServiceProvider());
    }

    /**
     * @param Application $app
     */
    private function loadConfigurations(Application &$app) {
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

    /**
     * @param Application $app
     */
    private function createRoutes(Application &$app) {

        $app->get('/', function() use($app) {

                    $response          = new stdClass();
                    $response->failed  = false;
                    $response->proceed = false;
                    return $response;
                })->value(RouteValue::TEMPLATE, 'pages/landing')
                ->before(function(Request $request) use($app) {
                    if ($request->getSession()->get('username')) {
                        $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
                        return new RedirectResponse($baseUrl . 'game');
                    }
                });

        $app->mount('/assets', $this->getAssetsRoutes($app));
        $app->mount('/account', $this->getAccountRoutes($app));
        $app->mount('/game', $this->getGameRoutes($app));
        $app->mount('/city', $this->getCityRoutes($app));
        $app->on(KernelEvents::VIEW, function($event) use($app) {
            $appResponse = $event->getControllerResult();
            $request     = $event->getRequest();
            $requestType = $event->getRequestType();
            $response    = $appResponse;
            if ($requestType === HttpKernelInterface::SUB_REQUEST) {
                $response = new JsonResponse($appResponse);
            }
            if ($request->attributes->has(RouteValue::SUB_REQUESTS)) {
                $subRequests = $request->attributes->get(RouteValue::SUB_REQUESTS);
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
                if ($request->attributes->has(RouteValue::TEMPLATE)) {
                    $template = $request->attributes->get(RouteValue::TEMPLATE);
                    $body     = $app['mustache']->render($template, $appResponse);
                    $response = new Response($body);
                }

                if (is_object($appResponse) && $appResponse->proceed && !$appResponse->failed && $request->attributes->has(RouteValue::SUCCESS_HANDLER)) {
                    $handler = $request->attributes->get(RouteValue::SUCCESS_HANDLER);
                    $result  = $handler($appResponse);
                    if ($result) {
                        $response = $result;
                    }
                }
                if (is_object($appResponse) && $appResponse->proceed && $appResponse->failed && $request->attributes->has(RouteValue::ERROR_HANDLER)) {
                    $handler = $request->attributes->get(RouteValue::ERROR_HANDLER);
                    $result  = $handler($appResponse);
                    if ($result) {
                        $response = $result;
                    }
                }
            }

            if (!$response->getExpires()) {
                $response->setExpires(new DateTime());
            }

            $event->setResponse($response);
        });
    }

    /**
     * @param Application $app
     * @return ControllerCollection
     */
    private function getCityRoutes(Application &$app) {
        $city = $app['controllers_factory'];
        $city->get('/list', Controller::CITY . ':listAction')
                ->value(RouteValue::TEMPLATE, 'pages/game/citylist');
        return $city;
    }

    /**
     * @param Application $app
     * @return ControllerCollection
     */
    private function getGameRoutes(Application &$app) {
        $game = $app['controllers_factory'];

        $game->get('/', function(Request $request) {
            $response           = new stdClass();
            $response->proceed  = false;
            $response->username = $request->getSession()->get('username');
            return $response;
        })->value(RouteValue::TEMPLATE, 'pages/game/landing');

        $game->get('/city/list/{username}', Controller::CITY . ':listAction')
                ->value('username', null)
                ->value(RouteValue::ERROR_HANDLER, function() use($app) {
                    $baseUrl = $app['mustache.options']['helpers']['baseUrl'];

                    return new RedirectResponse($baseUrl . 'game/start');
                })
                ->value(RouteValue::TEMPLATE, 'pages/game/citylist');




        $game->match('/start', Controller::CITY . ':newAction')
                ->value(RouteValue::SUCCESS_HANDLER, function() use($app) {
                    $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
                    return new RedirectResponse($baseUrl . 'game/city/list');
                })
                ->method('POST|GET')
                ->value(RouteValue::TEMPLATE, 'pages/game/newcity');
        $game->after(function() use($app) {
            $app[Repository::CITY]->sync();
        });
        return $game;
    }

    /**
     * @param Application $app
     * @return ControllerCollection
     */
    private function getAssetsRoutes(Application &$app) {
        $assets = $app['controllers_factory'];

        $assets->assert('file', '.+');
        $assets->get('{type}/{file}', Controller::ASSETS . ':load');

        return $assets;
    }

    /**
     * 
     * @param Application $app
     * @return ControllerCollection
     */
    private function getAccountRoutes(Application &$app) {
        $account = $app['controllers_factory'];
        $account->get('/logout', function()use($app) {
            $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
            $app['session']->remove('username');

            return new RedirectResponse($baseUrl);
        });
        $account->post('/login', Controller::ACCOUNT . ':loginAction')
                ->value(RouteValue::TEMPLATE, 'pages/landing')
                ->value(RouteValue::SUCCESS_HANDLER, function($appResponse) use ($app) {
                    $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
                    $app['session']->set('username', $appResponse->username);

                    return new RedirectResponse($baseUrl);
                })
                ->value(RouteValue::SUB_REQUESTS, array(
                    array(
                        'url'    => '/',
                        'method' => 'GET',
                        'param'  => array())
        ));
        $account->get('/registration_successfull', function() {
            return '';
        })->value(RouteValue::TEMPLATE, 'pages/registration_successfull');

        $account->match('/create', Controller::ACCOUNT . ':createAction')
                ->method('GET|POST')
                ->value(RouteValue::SUCCESS_HANDLER, function($appResponse) use ($app) {
                    $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
                    $request = $app['request'];

                    $appResponse->url = $request->getHttpHost();

                    $htmlBody = $app['mustache']->render('mails/html/register', $appResponse);
                    $textBody = $app['mustache']->render('mails/text/register', $appResponse);
                    $message  = Swift_Message::newInstance($app['subjects']['registration'])
                            ->setFrom($app['fromMails']['registration'])
                            ->setTo($appResponse->email)
                            ->setBody($htmlBody, 'text/html')
                            ->addPart($textBody, 'text/plain');

                    if ($app['mailer']->send($message)) {
                        $target = $baseUrl . 'account/registration_successfull';
                    } else {
                        $target = $baseUrl . 'account/registration_failed';
                    }
                    return new RedirectResponse($target);
                })
                ->value(RouteValue::TEMPLATE, 'pages/registration');


        $account->match('/activate', Controller::ACCOUNT . ':activateAction')
                ->method('GET|POST')
                ->value(RouteValue::TEMPLATE, 'pages/activation');

        $account->get('/activate/{username}/{activationKey}', Controller::ACCOUNT . ':activateAction')
                ->value(RouteValue::TEMPLATE, 'pages/activation');

        $account->after(function() use($app) {

            return $app[Controller::ACCOUNT]->after();
        });

        return $account;
    }

}
