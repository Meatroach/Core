<?php

namespace OpenTribes\Core\Request;

/**
 * Description of Registration
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Registration
{

    private $username = '';
    private $email = '';
    private $emailConfirm = '';
    private $password = '';
    private $passwordConfirm = '';
    private $termsAndConditions = '';

    /**
     * @param boolean $termsAndConditions
     */
    public function __construct($username, $email, $emailConfirm, $password, $passwordConfirm, $termsAndConditions)
    {
        $this->username           = $username;
        $this->email              = $email;
        $this->emailConfirm       = $emailConfirm;
        $this->password           = $password;
        $this->passwordConfirm    = $passwordConfirm;
        $this->termsAndConditions = $termsAndConditions;
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

    public function getTermsAndConditions()
    {
        return $this->termsAndConditions;
    }

}
