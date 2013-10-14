<?php

namespace OpenTribes\Core\User\Create\Validation;
use OpenTribes\Core\User\UserValue;
class Response{
    private $userValue;
    public function __construct(UserValue $userValue){
        $this->setUserValue($userValue);
        return $this;
    }
    public function setUserValue(UserValue $userValue){
        $this->userValue = $userValue;
        return $this;
    }
    public function getUserValue(){
        return $this->userValue;
    }
}
