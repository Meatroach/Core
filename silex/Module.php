<?php

namespace OpenTribes\Core\Silex;


use Igorw\Silex\ConfigServiceProvider;
use Mustache\Silex\Provider\MustacheServiceProvider;
use OpenTribes\Core\Silex\EventListener\BeforeAfterListener;
use OpenTribes\Core\Silex\EventListener\MustacheListener;
use OpenTribes\Core\Silex\Provider\CommonServiceProvider;
use OpenTribes\Core\Silex\Provider\ControllerServiceProvider;
use OpenTribes\Core\Silex\Provider\RepositoryServiceProvider;
use OpenTribes\Core\Silex\Provider\RouteServiceProvider;
use OpenTribes\Core\Silex\Provider\ServiceProvider;
use OpenTribes\Core\Silex\Provider\UseCaseServiceProvide;
use OpenTribes\Core\Silex\Provider\ValidatorServiceProvider;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\ServiceProviderInterface;
use RecursiveDirectoryIterator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Module implements ServiceProviderInterface{

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
        $this->loadConfigurations($app);
        $this->registerServices($app);
        $this->registerEventListener($app);
    }


    private function registerServices(Application $app)
    {
        $app->register(new ServiceControllerServiceProvider());
        $app->register(new DoctrineServiceProvider());
        $app->register(new SessionServiceProvider());
        $app->register(new ValidatorServiceProvider());
        $app->register(new MustacheServiceProvider());
        $app->register(new ServiceProvider());
        $app->register(new RepositoryServiceProvider());
        $app->register(new UseCaseServiceProvide());
        $app->register(new ControllerServiceProvider());
        $app->register(new CommonServiceProvider());
        $app->mount('/', new RouteServiceProvider());

    }
    private function loadConfigurations(Application $app)
    {
        $environment = $app['env'];
        $configDir = realpath(__DIR__.'/../config/'.$environment);
        if(!$configDir){
            throw new \Exception('Config folder for environment '.$environment.' not exists');
        }
        $iterator = new RecursiveDirectoryIterator($configDir, RecursiveDirectoryIterator::SKIP_DOTS);
        /**
         * @var \SplFileInfo $object
         */
        foreach ($iterator as $path => $object) {
            if ($object->isFile()) {
                $app->register(new ConfigServiceProvider($path));
            }
        }
    }
    private function registerEventListener(Application $app){
        /**
         * @var EventDispatcherInterface $dispatcher
         */
        $dispatcher = $app['dispatcher'];
        $dispatcher->addSubscriber(new MustacheListener($app['mustache']));
        $dispatcher->addSubscriber(new BeforeAfterListener($app,$app['callback_resolver']));
    }
} 