<?php

namespace OpenTribes\Core\Silex\Controller;


use OpenTribes\Core\Silex\Repository\WritableRepository;
use OpenTribes\Core\Silex\Request\AccountRequest;
use OpenTribes\Core\Silex\Response\AccountResponse;
use OpenTribes\Core\UseCase\RegistrationUseCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AccountController {
    private $registrationUseCase;
    private $userRepository;
    public function __construct(RegistrationUseCase $registrationUseCase,WritableRepository $userRepository){
        $this->registrationUseCase = $registrationUseCase;
        $this->userRepository = $userRepository;
    }
    public function indexAction(Request $httpRequest){
        $request = new AccountRequest($httpRequest);
        $response = new AccountResponse();
        if($httpRequest->isMethod('POST')){
            $this->registrationUseCase->process($request,$response);
            if(!$response->hasErrors()){
                $this->userRepository->sync();
                return new RedirectResponse('/cities');
            }
        }

        return $response;
    }

} 