<?php

namespace OpenTribes\Core\User\Create\Validation;

use OpenTribes\Core\Validator as BaseValidator;

abstract class Validator extends BaseValidator{
   
    public function __construct() {
        $this->validationObject = new Object();
    }
   
}
