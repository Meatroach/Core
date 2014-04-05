<?php

namespace OpenTribes\Core\Silex;

/**
 * Description of Service
 *
 * @author BlackScorp<witalimik@web.de>
 */
abstract class Service {
 const PASSWORD_HASHER = 'service.core.passwordHasher';
 const ACTIVATION_CODE_GENERATOR = 'service.core.activationCodeGenerator';
 const LOCATION_CALCULATOR = 'service.core.locationCalculator';
 const MAP_CALCULATOR = 'service.core.mapCalculator';
}
