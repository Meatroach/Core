<?php

namespace OpenTribes\Core\Mock\User;

use OpenTribes\Core\User\Validator as UserValidator;

class Validator extends UserValidator {

    private $isValid = true;

    public function check() {
        $this->checkUsername()
                ->checkEmail()
                ->checkPassword();


        return $this->isValid;
    }

    private function checkUsername() {

        if (in_array($this->username, array(null, false, '', array()), true)) {
            $this->errors[] = 'Username is empty';
            $this->isValid = false;
        }
        if ((bool) preg_match('/^[-a-z0-9_]++$/iD', $this->username) === false) {
            $this->errors[] = 'Username has invalid characters';
            $this->isValid = false;
        }

        if (strlen($this->username) < 4) {
            $this->errors[] = 'Username must contain at least 4 characters';
            $this->isValid = false;
        }

        if (strlen($this->username) > 32) {
            $this->errors[] = 'Username can not be longer than 32 characters';
            $this->isValid = false;
        }

        if (!$this->isUniqueUsername) {
            $this->errors[] = 'Username already exists';
            $this->isValid = false;
        }
        return $this;
    }

    private function checkEmail() {
        if (in_array($this->email, array(null, false, '', array()), true)) {
            $this->errors[] = 'email is empty';
            $this->isValid = false;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'email is invalid';
            $this->isValid = false;
        }

        if (!$this->emailConfirmed) {
            $this->errors[] = 'email confirm does not match the email';
            $this->isValid = false;
        }
        if (!$this->isUniqueEmail) {
            $this->errors[] = 'email already exists';
            $this->isValid = false;
        }
        return $this;
    }

    private function checkPassword() {
        if (in_array($this->password, array(null, false, '', array()), true)) {
            $this->errors[] = 'Password is empty';
            $this->isValid = false;
        }
        if (strlen($this->password) < 6) {
            $this->errors[] = 'Password must contain at least 6 characters';
            $this->isValid = false;
        }
        if (!$this->passwordConfirmed) {
            $this->errors[] = 'password confirm does not match the password';
            $this->isValid = false;
        }
        return $this;
    }

}
