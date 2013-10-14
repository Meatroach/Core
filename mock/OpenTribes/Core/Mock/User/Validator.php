<?php

namespace OpenTribes\Core\Mock\User;

use OpenTribes\Core\User\Validator as BaseUserValidator;

class Validator extends BaseUserValidator {

    private $isValid = true;

    public function isValid() {
        $this->check();
        return $this->isValid;
    }

    private function check() {
        $this->checkUsername()
                ->checkEmail()
                ->checkPassword();


        return $this->isValid;
    }

    private function checkUsername() {
        $username = $this->userValue->getUsername();
        $isUniqueUsername = $this->userValue->getIsUniqueUsername();
        if (in_array($username, array(null, false, '', array()), true)) {
            $this->errors[] = 'Username is empty';
            $this->isValid = false;
        }
        if ((bool) preg_match('/^[-a-z0-9_]++$/iD', $username) === false) {
            $this->errors[] = 'Username has invalid characters';
            $this->isValid = false;
        }

        if (strlen($username) < 4) {
            $this->errors[] = 'Username must contain at least 4 characters';
            $this->isValid = false;
        }

        if (strlen($username) > 32) {
            $this->errors[] = 'Username can not be longer than 32 characters';
            $this->isValid = false;
        }

        if (!$isUniqueUsername) {
            $this->errors[] = 'Username already exists';
            $this->isValid = false;
        }
        return $this;
    }

    private function checkEmail() {
        $email = $this->userValue->getEmail();
        $isUniqueEmail = $this->userValue->getIsUniqueEmail();
        $isConfirmedEmail = $this->userValue->getIsConfirmedEmail();
        if (in_array($email, array(null, false, '', array()), true)) {
            $this->errors[] = 'email is empty';
            $this->isValid = false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'email is invalid';
            $this->isValid = false;
        }

        if (!$isConfirmedEmail) {
            $this->errors[] = 'email confirm does not match the email';
            $this->isValid = false;
        }
        if (!$isUniqueEmail) {
            $this->errors[] = 'email already exists';
            $this->isValid = false;
        }
        return $this;
    }

    private function checkPassword() {
        $password = $this->userValue->getPassword();
        $isConfirmedPassword = $this->userValue->getIsConfirmedPassword();
        if (in_array($password, array(null, false, '', array()), true)) {
            $this->errors[] = 'Password is empty';
            $this->isValid = false;
        }
        if (strlen($password) < 6) {
            $this->errors[] = 'Password must contain at least 6 characters';
            $this->isValid = false;
        }
        if (!$isConfirmedPassword) {
            $this->errors[] = 'password confirm does not match the password';
            $this->isValid = false;
        }
        return $this;
    }

}
