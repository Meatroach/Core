<?php

namespace OpenTribes\Core\Domain\Validator;

use OpenTribes\Core\Domain\ValidationDto\Registration as RegistrationDto;

/**
 * Description of Registration
 *
 * @author BlackScorp<witalimik@web.de>
 * @method \OpenTribes\Core\Domain\ValidationDto\Registration getObject() Returns validation object
 */
abstract class Registration extends Validator {

    public function __construct(RegistrationDto $object) {
        $this->setObject($object);
    }

}
