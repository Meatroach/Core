<?php

namespace OpenTribes\Core\Silex\Request;


use OpenTribes\Core\Request\RegistrationRequest;

use Symfony\Component\HttpFoundation\Request;

class AccountRequest implements RegistrationRequest{

    private $request;
    public function __construct(Request $request){
        $this->request = $request;
    }
    public function getUsername()
    {
        return $this->request->get('username','');
    }

    public function getPassword()
    {
       return $this->request->get('password','');
    }

    public function getPasswordConfirm()
    {
       return $this->request->get('passwordConfirm','');
    }

    public function getEmail()
    {
       return $this->request->get('email','');
    }

    public function getEmailConfirm()
    {
        return $this->request->get('emailConfirm','');
    }

    public function hasAcceptedTerms()
    {
       return (bool)$this->request->get('termsAndConditions',false);
    }

} 