<?php

namespace OpenTribes\Core\Test\Mock\Response;

use OpenTribes\Core\Request\RegistrationRequest;
use OpenTribes\Core\Response\RegistrationResponse;
use OpenTribes\Core\Traits\ErrorTrait;

/**
 * Description of Registration
 *
 * @author BlackScorp<witalimik@web.de>
 */
class MockRegistrationResponse implements RegistrationResponse
{
    use ErrorTrait;
    public $username;
    public $email;
    public $emailConfirm;
    public $password;
    public $passwordConfirm;
    public $activationCode;
    public $termsAndConditions;

    public function setRegistrationRequest(RegistrationRequest $request)
    {
        $this->username = $request->getUsername();
        $this->email = $request->getEmail();
        $this->emailConfirm = $request->getEmailConfirm();
        $this->password =  $request->getPassword();
        $this->passwordConfirm = $request->getPasswordConfirm();

    }

}
