<?php

namespace OpenTribes\Core\Mock\Validator;

use OpenTribes\Core\Validator\Registration as AbstractRegistration;

/**
 * Description of Registration
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Registration extends AbstractRegistration {

    private $userObject;

    public function validate() {
        $this->userObject = $this->getObject();
        $this->checkUsername();
        $this->checkPassword();
        $this->checkEmail();
        $this->checkTermsAndConditions();
    }

    private function checkUsername() {
        $username = $this->userObject->username;
        if (in_array($username, array(null, false, '', array()), true)) {
            $this->attachError("Username is empty");
        }
        if (strlen($username) < 4) {
            $this->attachError("Username is too short");
        }
        if (strlen($username) > 24) {
            $this->attachError("Username is too long");
        }
        if ((bool) preg_match('/^[-a-z0-9_]++$/iD', $username) === false) {
            $this->attachError("Username contains invalid character");
        }
        if (!$this->userObject->isUniqueUsername) {
            $this->attachError("Username exists");
        }
    }

    private function checkPassword() {
        $password        = $this->userObject->password;
        $passwordConfirm = $this->userObject->passwordConfirm;
        if (in_array($password, array(null, false, '', array()), true)) {
            $this->attachError("Password is empty");
        }
        if (strlen($password) < 6) {
            $this->attachError("Password is too short");
        }
        if ($password !== $passwordConfirm) {
            $this->attachError("Password confirm not match");
        }
    }

    private function checkEmail() {
        $email        = $this->userObject->email;
        $emailConfirm = $this->userObject->emailConfirm;
        if (in_array($email, array(null, false, '', array()), true)) {
            $this->attachError("Email is empty");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->attachError("Email is invalid");
        }
        if($email !== $emailConfirm){
            $this->attachError("Email confirm not match");
        }
        if(!$this->userObject->isUniqueEmail){
            $this->attachError("Email exists");
        }
    }

    private function checkTermsAndConditions() {
        if(!$this->userObject->termsAndConditions){
            $this->attachError("Terms and Conditions are not accepted");
        }
    }

}
