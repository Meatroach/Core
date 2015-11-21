<?php

namespace OpenTribes\Core\Test\Mock\Validator;

use OpenTribes\Core\Validator\LoginValidator;

class MockLoginValidator extends LoginValidator{

    protected function validate()
    {
        if ((bool)preg_match('/^[-a-z0-9_]++$/iD', $this->username) === false) {
            $this->addError("Username contains invalid character");
        }
       if($this->verified === false){
           $this->addError('Invalid login');
       }
    }

} 