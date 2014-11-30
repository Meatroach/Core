<?php

namespace OpenTribes\Core\Response;


use OpenTribes\Core\Request\LoginRequest;

interface LoginResponse extends ErrorResponse{
    public function setLoginRequest(LoginRequest $request);
} 