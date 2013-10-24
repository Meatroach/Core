<?php

namespace OpenTribes\Core\User\ActivationMail\Create;

use OpenTribes\Core\User\ActivationMail;

class Response {

    protected $activationMail;

    public function __construct(ActivationMail $activationMail) {
        $this->setActivationMail($activationMail);
    }

    public function setActivationMail(ActivationMail $activationMail) {
        $this->activationMail = $activationMail;
        return $this;
    }

    public function getActivationMail() {
        return $this->activationMail;
    }

}