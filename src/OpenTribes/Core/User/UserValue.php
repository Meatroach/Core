<?php

namespace OpenTribes\Core\User;

abstract class UserValue {

    protected $errors;
    protected $username;
    protected $email;
    protected $password;
    protected $isUniqueUsername;
    protected $isUniqueEmail;
    protected $passwordConfirmed;
    protected $emailConfirmed;

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function setIsUniqueUsername($isUniqueUsername) {
        $this->isUniqueUsername = $isUniqueUsername;
        return $this;
    }

    public function setIsUniqueEmail($isUniqueEmail) {
        $this->isUniqueEmail = $isUniqueEmail;
        return $this;
    }

    public function setPasswordConfirmed($passwordConfirmed) {
        $this->passwordConfirmed = $passwordConfirmed;
        return $this;
    }

    public function setEmailConfirmed($emailConfirmed) {
        $this->emailConfirmed = $emailConfirmed;
        return $this;
    }
    
    public function getUsername(){
        return $this->username;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getIsUniqueUsername(){
        return $this->isUniqueUsername;
    }
    public function getIsUniqueEmail(){
        return $this->isUniqueEmail;
    }
    public function getIsConfirmedPassword(){
        return $this->passwordConfirmed;
    }
    public function getIsConfirmedEmail(){
        return $this->emailConfirmed;
    }
}
