<?php

namespace OpenTribes\Core\User;

use OpenTribes\Core\User\Validator as BaseValidator;
use OpenTribes\Core\User\Create\UserValue;
abstract class Validator extends BaseValidator{
   
    public function __construct(UserValue $userValue) {
        $this->userValue = $userValue;
    }
   
}
