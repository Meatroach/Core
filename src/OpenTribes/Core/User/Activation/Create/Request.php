<?php

namespace OpenTribes\Core\User\ActivationMail\Create;
use OpenTribes\Core\User\Create\Response as UserCreateResponse;
use OpenTribes\Core\User;
class Request{
    protected $user;
    public function __construct(UserCreateResponse $response) {
        $this->setUser($response->getUser());
    }
    public function setUser(User $response){
        $this->user = $response;
        return $this;
    }
    public function getUser(){
        return $this->user;
    }
}
