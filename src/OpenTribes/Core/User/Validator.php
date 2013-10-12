<?php

namespace OpenTribes\Core\User;

abstract class Validator {

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

    abstract public function check();

    public function isValid() {
        return $this->check();
    }

    public function getErrors() {
        return $this->errors;
    }

}
