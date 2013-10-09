<?php
namespace OpenTribes\Core\User;

use OpenTribes\Core\Entity;

class ActivationMail extends Entity{
    protected $email;
    protected $activationCode;
    protected $username;
    
    public function setEmail($email){
        $this->email = $email;
        return $this;
    }
    public function setActivationCode($code){
        $this->activationCode = $code;
        return $this;
    }
    public function setUsername($username){
        $this->username = $username;
        return $this;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getActivationCode(){
        return $this->activationCode;
    }
    public function getUsername(){
        return $this->username;
    }
}
