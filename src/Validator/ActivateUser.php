<?php

namespace OpenTribes\Core\Validator;

use OpenTribes\Core\ValidationDto\ActivateUser as ActivateUserDto;

/**
 * Description of ActivateUser
 *
 * @author BlackScorp<witalimik@web.de>
 * @method \OpenTribes\Core\ValidationDto\ActivateUser getObject() Returns validation object
 */
abstract class ActivateUser extends Validator
{
    public function __construct(ActivateUserDto $validationDto)
    {
        $this->setObject($validationDto);
    }
}
