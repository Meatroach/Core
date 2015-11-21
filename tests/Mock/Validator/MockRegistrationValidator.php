<?php

namespace OpenTribes\Core\Test\Mock\Validator;


use OpenTribes\Core\Validator\RegistrationValidator;

/**
 * Description of Registration
 *
 * @author BlackScorp<witalimik@web.de>
 */
class MockRegistrationValidator extends RegistrationValidator
{


    public function validate()
    {

        $this->checkUsername();
        $this->checkPassword();
        $this->checkEmail();
        $this->checkTermsAndConditions();
    }

    private function checkUsername()
    {
        $username = $this->username;
        if (in_array($username, array(null, false, '', array()), true)) {
            $this->addError("Username is empty");
        }
        if (strlen($username) < 4) {
            $this->addError("Username is too short");
        }
        if (strlen($username) > 24) {
            $this->addError("Username is too long");
        }
        if ((bool)preg_match('/^[-a-z0-9_]++$/iD', $username) === false) {
            $this->addError("Username contains invalid character");
        }
        if ($this->usernameExists === true) {
            $this->addError("Username exists");
        }
    }

    private function checkPassword()
    {
        $password = $this->password;
        $passwordConfirm = $this->passwordConfirm;
        if (in_array($password, array(null, false, '', array()), true)) {
            $this->addError("Password is empty");
        }

        if (strlen($password) < 6) {
            $this->addError("Password is too short");
        }
        if ($password !== $passwordConfirm) {
            $this->addError("Password confirm not match");
        }
    }

    private function checkEmail()
    {
        $email = $this->email;
        $emailConfirm = $this->emailConfirm;
        if (in_array($email, array(null, false, '', array()), true)) {
            $this->addError("Email is empty");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError("Email is invalid");
        }
        if ($email !== $emailConfirm) {
            $this->addError("Email confirm not match");
        }
        if ($this->emailExists === true) {
            $this->addError("Email exists");
        }
    }

    private function checkTermsAndConditions()
    {
        if (!$this->acceptedTerms) {
            $this->addError("Terms and Conditions are not accepted");
        }
    }
}
