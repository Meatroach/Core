<?php

namespace OpenTribes\Core\User\Create;

use OpenTribes\Core\User\Create\Validation\Response as ValidationResponse;
use OpenTribes\Core\User\UserValue;

class Request {

    protected $userValue;
    protected $roleName;

    public function __construct(ValidationResponse $response, $roleName) {
        $this->setUserValue($response->getUserValue())
                ->setRoleName($roleName);
    }

    public function setUserValue(UserValue $userValue) {
        $this->userValue = $userValue;
        return $this;
    }

    public function setRoleName($rolename) {
        $this->roleName = $rolename;
        return $this;
    }

    public function getUserValue() {
        return $this->userValue;
    }

    public function getRoleName() {
        return $this->roleName;
    }

}
