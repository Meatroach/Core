<?php

namespace OpenTribes\Core\Mock\User\ActivationMail;

use OpenTribes\Core\User\ActivationMail;
use OpenTribes\Core\User\ActivationMail\Repository as ActivationMailRepositoryInterface;

class Repository implements ActivationMailRepositoryInterface{
    private $activationMails = array();
    public function add(ActivationMail $activationMail) {
        $this->activationMails[]=$activationMail;
    }
}
