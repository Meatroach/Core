<?php

namespace OpenTribes\Core\Domain\Validator;
use OpenTribes\Core\Domain\ValidationDto\ActivateUser as ActivateUserDto;
/**
 * Description of ActivateUser
 *
 * @author BlackScorp<witalimik@web.de>
 * @method \OpenTribes\Core\Domain\ValidationDto\ActivateUser getObject() Returns validation object
 */
abstract class ActivateUser extends Validator{
    public function __construct(ActivateUserDto $validationDto) {
        $this->setObject($validationDto);
    }
}
