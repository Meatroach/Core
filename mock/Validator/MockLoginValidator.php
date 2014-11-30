<?php

namespace OpenTribes\Core\Mock\Validator;

use OpenTribes\Core\Validator\LoginValidator;

class MockLoginValidator extends LoginValidator{

    protected function validate()
    {
       if($this->verified === false){
           $this->addError('Invalid login');
       }
    }

} 