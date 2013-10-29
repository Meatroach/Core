<?php

namespace OpenTribes\Core\Guest\Account\Create;

use OpenTribes\Core\User\Activation\Create\Response as ActivationCreateResponse;

class Response {

    protected $email;

    public function __construct(ActivationCreateResponse $activationCreateResponse) {
        $this->setEmail($activationCreateResponse->getEmail());
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

}