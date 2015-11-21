<?php

namespace OpenTribes\Core\Test\Mock\Response;


use OpenTribes\Core\Request\LoginRequest;
use OpenTribes\Core\Response\LoginResponse;
use OpenTribes\Core\Traits\ErrorTrait;

class MockLoginResponse implements LoginResponse{
    use ErrorTrait;
    public $username= '';
    public $password = '';
    public function setLoginRequest(LoginRequest $request)
    {
        $this->username = $request->getUsername();
        $this->password = $request->getPassword();
    }

} 