<?php

namespace OpenTribes\Core\Silex;

use OpenTribes\Core\Silex\Validator\Registration as RegistrationValidator;
use OpenTribes\Core\ValidationDto\ActivateUser as ActivateUserValidatorDto;
use OpenTribes\Core\ValidationDto\Registration as RegistrationValidatorDto;
use OpenTribes\Core\Mock\Validator\ActivateUser as ActivateUserValidator;
use Silex\Application;

/**
 * Description of Validator
 *
 * @author BlackScorp<witalimik@web.de>
 */
abstract class Validator {

    const ACTIVATE     = 'validator.core.activate';
    const REGISTRATION = 'validator.core.registration';

    public static function create(Application &$app) {
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

}
