<?php

namespace OpenTribes\Core\Silex;

use DateTime;
use Igorw\Silex\ConfigServiceProvider;
use Mustache\Silex\Provider\MustacheServiceProvider;
use OpenTribes\Core\Silex\Controller;
use OpenTribes\Core\Silex\Repository;
use OpenTribes\Core\Silex\Service;
use OpenTribes\Core\Silex\Validator;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\ServiceProviderInterface;
use stdClass;
use Swift_NullTransport;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use OpenTribes\Core\Silex\Provider\Assets as AssetsProvider;
use OpenTribes\Core\Silex\Provider\Account as AccountProvider;
use OpenTribes\Core\Silex\Provider\Game as GameProvider;

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

    public function boot(Application $app) {}

    public function register(Application $app) {

        $this->registerProviders($app);
        $this->loadConfigurations($app);
        $this->createDependencies($app);
        $this->setupRoutes($app);
    }

    private function createDependencies(Application &$app) {
        Repository::create($app);
        Service::create($app);
        Validator::create($app);
        Controller::create($app);

        if ($this->env === 'test') {
            $app['swiftmailer.transport'] = $app->share(function() {
                return new Swift_NullTransport();
            });
        }
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
    protected function attachRoutesOnContainer(Application &$app) {
        $app->mount('/assets', new AssetsProvider());
        $app->mount('/account', new AccountProvider());
        $app->mount('/game', new GameProvider());
    }

    /**
     * @param Application $app
     * @return void
     */
    protected function setupRoutes(Application &$app) {
        $app->on(KernelEvents::REQUEST, function($event) use($app) {
            $request         = $event->getRequest();
            $session         = $request->getSession();
            $token           = $request->get('csrfToken');
            $defaultToken    = $app[Service::PASSWORD_HASHER]->hash($session->getId());
            $realToken       = $session->get('csrfToken', $defaultToken);
            $isNotGETRequest = $request->getMethod() !== 'GET';
            $isValidToken    = $realToken === $token;

            if ($isNotGETRequest && !$isValidToken) {
                $event->setResponse(new Response('Access denied, invalid token', 500));
            }
            $session->set('csrfToken', $realToken);
        });

        $app->get('/', function() use($app) {
            $response          = new stdClass();
            $response->failed  = false;
            $response->proceed = false;
            return $response;
        })->before(function(Request $request) use($app) {
            $session = $request->getSession();
            if (!$session) {
                return '';
            }
            if ($session->get('username')) {
                $baseUrl = $app['mustache.options']['helpers']['baseUrl'];
                return new RedirectResponse($baseUrl . 'game');
            }
        })->value(RouteValue::TEMPLATE, 'pages/landing');
        $app->after(function(Request $request) use($app) {
              $session = $request->getSession();
            if ($session->get('username')) {
                $app[Controller::ACCOUNT]->updateLastAction($session->get('username'));
                 $app[Controller::ACCOUNT]->after();
            }
        });
        
        $this->attachRoutesOnContainer($app);
        
        $module = $this;
        $app->on(KernelEvents::VIEW, function($event) use($app, $module) {
            $appResponse = $event->getControllerResult();
            $request     = $event->getRequest();
            $requestType = $event->getRequestType();
            $response    = $appResponse;

            if ($requestType === HttpKernelInterface::SUB_REQUEST) {
                $response = new JsonResponse($appResponse);
            }
            if ($request->attributes->has(RouteValue::SUB_REQUESTS)) {
                $subRequests = $request->attributes->get(RouteValue::SUB_REQUESTS);
                $appResponse = $module->handleSubRequests($subRequests, $appResponse, $app);
            }
            if ($requestType === HttpKernelInterface::MASTER_REQUEST) {
                $appResponse->csrfToken = $request->getSession()->get('csrfToken');
                $response               = $module->createResponse($request, $appResponse, $app);
            }

            $event->setResponse($response);
        });
    }

    /**
     * 
     * @param Request $request
     * @param mixed $appResponse
     * @param Application $app
     * @return Response
     */
    public function createResponse(Request $request, $appResponse, Application $app) {
        $response = new Response();
        if ($request->attributes->has(RouteValue::TEMPLATE)) {
            $template = $request->attributes->get(RouteValue::TEMPLATE);

            $body = $app['mustache']->render($template, $appResponse);
            $response->setContent($body);
            $response->setExpires(new DateTime());
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

        return $response;
    }

    /**
     * @param Application $app
     */
    public function handleSubRequests(array $subRequests, $appResponse, $app) {
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
        return $appResponse;
    }
}
