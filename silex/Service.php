<?php

namespace OpenTribes\Core\Silex;

use OpenTribes\Core\Mock\Service\LocationCalculator;
use OpenTribes\Core\Silex\Provider\CSRFTokenHasher;
use OpenTribes\Core\Silex\Service\CodeGenerator;
use OpenTribes\Core\Silex\Service\IsometricMapCalculator;
use OpenTribes\Core\Silex\Service\PasswordHasher;
use Silex\Application;

/**
 * Description of Service
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Service
{

    const PASSWORD_HASHER = 'service.core.passwordHasher';
    const ACTIVATION_CODE_GENERATOR = 'service.core.activationCodeGenerator';
    const LOCATION_CALCULATOR = 'service.core.locationCalculator';
    const MAP_CALCULATOR = 'service.core.mapCalculator';
    const CSRF_TOKEN_HASHER = 'service.core.csrfHasher';

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function create()
    {
        $app = $this->app;
        $app[self::PASSWORD_HASHER] = $app->share(
            function () {
                return new PasswordHasher();
            }
        );
        $app[self::ACTIVATION_CODE_GENERATOR] = $app->share(
            function () use ($app) {
                return new CodeGenerator($app['activationCodeLength']);
            }
        );
        $app[self::LOCATION_CALCULATOR] = $app->share(
            function () use ($app) {
                return new LocationCalculator;
            }
        );
        $app[self::MAP_CALCULATOR] = $app->share(
            function () use ($app) {
                $options = $app['map.options'];
                return new IsometricMapCalculator(
                    $options['height'],
                    $options['width'],
                    $options['viewportHeight'],
                    $options['viewportWidth'],
                    $options['tileHeight'],
                    $options['tileWidth']
                );
            }
        );
        $app[self::CSRF_TOKEN_HASHER] = $app->share(
            function () use ($app) {
                return new CSRFTokenHasher($app['session']);
            }
        );
    }
}
