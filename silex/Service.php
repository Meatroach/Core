<?php

namespace OpenTribes\Core\Silex;

use OpenTribes\Core\Mock\Service\LocationCalculator;
use OpenTribes\Core\Silex\Service\CodeGenerator;
use OpenTribes\Core\Silex\Service\PasswordHasher;
use OpenTribes\Core\Silex\Service\IsometricMapCalculator;
use Silex\Application;

/**
 * Description of Service
 *
 * @author BlackScorp<witalimik@web.de>
 */
abstract class Service {

    const PASSWORD_HASHER           = 'service.core.passwordHasher';
    const ACTIVATION_CODE_GENERATOR = 'service.core.activationCodeGenerator';
    const LOCATION_CALCULATOR       = 'service.core.locationCalculator';
    const MAP_CALCULATOR            = 'service.core.mapCalculator';

    public static function create(Application &$app) {

        $app[Service::PASSWORD_HASHER] = $app->share(function() {
            return new PasswordHasher();
        });
        $app[Service::ACTIVATION_CODE_GENERATOR] = $app->share(function() use($app) {
            return new CodeGenerator($app['activationCodeLength']);
        });
        $app[Service::LOCATION_CALCULATOR] = $app->share(function() use($app) {
            return new LocationCalculator;
        });
        $app[Service::MAP_CALCULATOR] = $app->share(function() use($app) {
            return new IsometricMapCalculator($app['map.options']['height'], $app['map.options']['width']);
        });
    }

}
