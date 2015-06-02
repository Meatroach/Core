<?php


namespace OpenTribes\Core\Silex\Provider;


use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\Context\ExecutionContextFactory;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class CommonServiceProvider implements ServiceProviderInterface{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {
        $app['validator'] = $app->share(function ($app) {
            if (isset($app['translator'])) {
                $r = new \ReflectionClass('Symfony\Component\Validator\Validator');
                $file = dirname($r->getFilename()).'/Resources/translations/validators.'.$app['locale'].'.xlf';
                if (file_exists($file)) {
                    $app['translator']->addResource('xliff', $file, $app['locale'], 'validators');
                }
            }
            $translator = isset($app['translator']) ? $app['translator'] : new IdentityTranslator();

            $executionContext = new ExecutionContextFactory($translator);
            $metaDataFactory = new LazyLoadingMetadataFactory();
            $constrainValidator = new ConstraintValidatorFactory();
            return new RecursiveValidator($executionContext,$metaDataFactory,$constrainValidator);


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

    }

}