<?php

namespace OpenTribes\Core\User;

use OpenTribes\Core\Validator as BaseValidator;
use OpenTribes\Core\UserValue;
abstract class Validator extends BaseValidator{
    protected $userValue;
    public function __construct(UserValue $userValue) {
        $this->userValue = $userValue;
    }
    public function getUserValue(){
        return $this->userValue;
    }
    
}
