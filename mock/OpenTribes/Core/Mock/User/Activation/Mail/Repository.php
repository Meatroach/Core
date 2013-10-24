<?php

namespace OpenTribes\Core\Mock\User\Activation\Mail;

use OpenTribes\Core\User\Activation\Mail as ActivationMail;
use OpenTribes\Core\User\Activation\Mail\Repository as ActivationMailRepositoryInterface;

class Repository implements ActivationMailRepositoryInterface{
    private $activationMails = array();
    public function add(ActivationMail $activationMail) {
        $this->activationMails[]=$activationMail;
    }
}
