<?php

namespace OpenTribes\Core\Response;


use OpenTribes\Core\Request\RegistrationRequest;

interface RegistrationResponse extends ErrorResponse{
    public function setRegistrationRequest(RegistrationRequest $request);
} 