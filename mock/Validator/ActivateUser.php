<?php

namespace OpenTribes\Core\Mock\Validator;
use OpenTribes\Core\Domain\Validator\ActivateUser as AbstractActivateUserValidator;
/**
 * Description of ActivateUser
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ActivateUser extends AbstractActivateUserValidator{
    public function validate() {
        if(!$this->getObject()->codeIsValid){
            $this->attachError("Activation code is invalid");
        }
    }

}
