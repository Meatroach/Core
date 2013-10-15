<?php

namespace OpenTribes\Core\User\Create\Validation;

class Request {

    protected $username;
    protected $passwordConfirm;
    protected $password;
    protected $email;
    protected $emailConfirm;
    protected $termsAndConditions;

    public function __construct($username, $password, $email, $passwordConfirm, $emailConfirm, $termsAndConditions) {
        $this->setUsername($username)
                ->setEmail($email)
                ->setPassword($password)
                ->setEmailConfirm($emailConfirm)
                ->setPasswordConfirm($passwordConfirm)
                ->setTermsAndConditions($termsAndConditions);
        return $this;
    }

    public function setTermsAndConditions($termsAndConditions) {
        $this->termsAndConditions = $termsAndConditions;
        return $this;
    }

    public function setPasswordConfirm($passwordConfirm) {
        $this->passwordConfirm = $passwordConfirm;
        return $this;
    }

    public function setEmailConfirm($emailConfirm) {
        $this->emailConfirm = $emailConfirm;
        return $this;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPasswordConfirm() {
        return $this->passwordConfirm;
    }

    public function getEmailConfirm() {
        return $this->emailConfirm;
    }

    public function getTermsAndConditions() {
        return $this->termsAndConditions;
    }

}
