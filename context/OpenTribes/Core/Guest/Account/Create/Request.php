<?php

namespace OpenTribes\Core\Guest\Account\Create;

class Request {

    protected $username;
    protected $password;
    protected $passwordConfirm;
    protected $email;
    protected $emailConfirm;
    protected $acceptTermsAndConditions;
    protected $defaultRolename;

    public function __construct($username, $password, $passwordConfirm, $email, $emailConfirm, $acceptTermsAndConditions, $defaultRolename) {
        $this->setUsername($username)
                ->setPassword($password)
                ->setEmail($email)
                ->setEmaiConfirm($emailConfirm)
                ->setPasswordConfirm($passwordConfirm)
                ->setAcceptTermsAndConditions($acceptTermsAndConditions)
                ->setDefaultRolename($defaultRolename);
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function setPasswordConfirm($passwordConfirm) {
        $this->passwordConfirm = $passwordConfirm;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setEmailConfirm($emailConfirm) {
        $this->emailConfirm = $emailConfirm;
        return $this;
    }

    public function setAcceptTermsAndConditions($acceptTermsAndConditions) {
        $this->acceptTermsAndConditions = $acceptTermsAndConditions;
        return $this;
    }

    public function setDefaultRolename($defaultRolename) {
        $this->defaultRolename = $defaultRolename;
        return $this;
    }
    
    public function getUsername(){
        return $this->username;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPasswordConfirm(){
        return $this->passwordConfirm;
    }
    public function getEmailConfirm(){
        return $this->emailConfirm;
    }
    public function getAcceptTermsAndConditions(){
        return $this->acceptTermsAndConditions;
    }
    public function getDefaultRolename(){
        return $this->defaultRolename;
    }
}

