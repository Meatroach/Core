<?php

namespace OpenTribes\Core\User\ActivationMail\Send;


class Request{
    protected $user;

    public function __construct(User $user) {
        $this->setUser($user);
        return $this;
    }
    public function setUser(User $user){
        $this->user = $user;
        return $this;
    }
    public function getUser(){
        return $this->user;
    }

   
}
