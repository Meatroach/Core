<?php

namespace OpenTribes\Core\Silex\Response;

use OpenTribes\Core\Request\RegistrationRequest;
use OpenTribes\Core\Response\RegistrationResponse;
use OpenTribes\Core\Traits\ErrorTrait;

class AccountResponse extends SymfonyBaseResponse implements RegistrationResponse{
    use ErrorTrait;
    public $username = '';
    public $password = '';
    public $passwordConfirm = '';
    public $email = '';
    public $emailConfirm = '';
    public $acceptedTermsAndConditions = false;
    public function setRegistrationRequest(RegistrationRequest $request)
    {
        $this->username = $request->getUsername();
        $this->password = $request->getPassword();
        $this->passwordConfirm = $request->getPasswordConfirm();
        $this->email = $request->getEmail();
        $this->emailConfirm = $request->getEmailConfirm();
        $this->acceptedTermsAndConditions = $request->hasAcceptedTerms();
    }

} 