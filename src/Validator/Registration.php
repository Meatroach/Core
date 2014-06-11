<?php

namespace OpenTribes\Core\Validator;

use OpenTribes\Core\ValidationDto\Registration as RegistrationDto;

/**
 * Description of Registration
 *
 * @author BlackScorp<witalimik@web.de>
 * @method \OpenTribes\Core\ValidationDto\Registration getObject() Returns validation object
 */
abstract class Registration extends Validator
{

    public function __construct(RegistrationDto $object)
    {
        $this->setObject($object);
    }

}
