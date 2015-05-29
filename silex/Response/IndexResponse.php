<?php

namespace OpenTribes\Core\Silex\Response;

use OpenTribes\Core\Request\LoginRequest;
use OpenTribes\Core\Response\LoginResponse;
use OpenTribes\Core\Traits\ErrorTrait;

class IndexResponse extends SymfonyBaseResponse implements LoginResponse{

    use ErrorTrait;
    public $username = '';
    public $password = '';
    public function setLoginRequest(LoginRequest $request)
    {

        $this->username = $request->getUsername();
        $this->password = $request->getPassword();
    }


} 