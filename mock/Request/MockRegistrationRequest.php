<?php

namespace OpenTribes\Core\Mock\Request;

use OpenTribes\Core\Request\RegistrationRequest;

/**
 * Description of Registration
 *
 * @author BlackScorp<witalimik@web.de>
 */
class MockRegistrationRequest implements RegistrationRequest
{

    private $username = '';
    private $email = '';
    private $emailConfirm = '';
    private $password = '';
    private $passwordConfirm = '';
    private $termsAndConditions =false;

    /**
     * @param $username
     * @param $email
     * @param $emailConfirm
     * @param $password
     * @param $passwordConfirm
     */
    public function __construct($username, $password, $passwordConfirm, $email, $emailConfirm)
    {
        $this->username = $username;
        $this->email = $email;
        $this->emailConfirm = $emailConfirm;
        $this->password = $password;
        $this->passwordConfirm = $passwordConfirm;

    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getEmailConfirm()
    {
        return $this->emailConfirm;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }

    public function acceptTerms()
    {
        return $this->termsAndConditions = true;
    }

    public function hasAcceptedTerms()
    {
        return $this->termsAndConditions === true;
    }

}
