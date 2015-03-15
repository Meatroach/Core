<?php

namespace OpenTribes\Core\Silex\Controller;


use OpenTribes\Core\Silex\Request\AccountRequest;
use OpenTribes\Core\Silex\Response\AccountResponse;
use OpenTribes\Core\UseCase\RegistrationUseCase;
use Symfony\Component\HttpFoundation\Request;

class AccountController {
    private $registrationUseCase;
    public function __construct(RegistrationUseCase $registrationUseCase){
        $this->registrationUseCase = $registrationUseCase;
    }
    public function indexAction(Request $httpRequest){
        $request = new AccountRequest($httpRequest);
        $response = new AccountResponse();
        if($httpRequest->isMethod('POST')){
            $this->registrationUseCase->process($request,$response);
        }

        return $response;
    }

} 