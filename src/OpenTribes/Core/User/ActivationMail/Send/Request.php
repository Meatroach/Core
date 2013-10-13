<?php

namespace OpenTribes\Core\User\ActivationMail\Send;
use OpenTribes\Core\User\ActivationMail\Create\Response as ActivationMailCreateResponse;
use OpenTribes\Core\User\ActivationMail;
class Request{
    protected $activationMail;

    public function __construct(ActivationMailCreateResponse $response) {
        $this->setActivationMail($response->getActivationMail());
        return $this;
    }
    public function setActivationMail(ActivationMail $activationMail){
        $this->activationMail = $activationMail;
        return $this;
    }
    public function getActivationMail(){
        return $this->activationMail;
    }

   
}
