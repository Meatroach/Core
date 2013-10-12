<?php
namespace OpenTribes\Core\User;

use OpenTribes\Core\Mail;

class ActivationMail extends Mail{
    
    protected $activationCode;
    protected $username;
    
    
    public function setActivationCode($code){
        $this->activationCode = $code;
        return $this;
    }
    public function setUsername($username){
        $this->username = $username;
        return $this;
    }
   
    public function getActivationCode(){
        return $this->activationCode;
    }
    public function getUsername(){
        return $this->username;
    }
}
