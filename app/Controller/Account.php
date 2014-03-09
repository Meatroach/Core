<?php

namespace OpenTribes\Core\Controller;

use Mustache_Engine as Renderer;
use OpenTribes\Core\Domain\Context\Guest\Registration as RegistrationContext;
use OpenTribes\Core\Domain\Interactor\Login as LoginInteractor;
use OpenTribes\Core\Domain\Repository\User as UserRepository;
use OpenTribes\Core\Domain\Request\Login as LoginRequest;
use OpenTribes\Core\Domain\Request\Registration as RegistrationRequest;
use OpenTribes\Core\Domain\Request\ActivateUser as ActivateUserRequest;
use OpenTribes\Core\Domain\Response\ActivateUser as ActivateUserResponse;
use OpenTribes\Core\Domain\Interactor\ActivateUser as ActivateUserInteractor;
use OpenTribes\Core\Domain\Validator\ActivateUser as ActivateUserValidator;
use OpenTribes\Core\Domain\Response\Login as LoginResponse;
use OpenTribes\Core\Domain\Response\Registration as RegistrationResponse;
use OpenTribes\Core\Domain\Service\ActivationCodeGenerator;
use OpenTribes\Core\Domain\Service\PasswordHasher;
use OpenTribes\Core\Domain\Validator\Registration as RegistrationValidator;
use Symfony\Component\HttpFoundation\Request;

class Account {

    private $userRepository;
    private $passwordHasher;
    private $registrationValidator;
    private $activationCodeGenerator;
    private $activateUserValidator;

    public function __construct(UserRepository $userRepository, PasswordHasher $passwordHasher, RegistrationValidator $registrationValidator, ActivationCodeGenerator $activationCodeGenerator, ActivateUserValidator $activateUserValidator) {
        $this->userRepository          = $userRepository;
        $this->passwordHasher          = $passwordHasher;
        $this->registrationValidator   = $registrationValidator;
        $this->activationCodeGenerator = $activationCodeGenerator;
        $this->activateUserValidator   = $activateUserValidator;
    }

    public function createAction(Request $httpRequest) {
        $username           = $httpRequest->get('username');
        $email              = $httpRequest->get('email');
        $emailConfirm       = $httpRequest->get('emailConfirm');
        $password           = $httpRequest->get('password');
        $passwordConfirm    = $httpRequest->get('passwordConfirm');
        $termsAndConditions = (bool) $httpRequest->get('termsAndConditions');
        $response           = new RegistrationResponse;
        $request            = new RegistrationRequest($username, $email, $emailConfirm, $password, $passwordConfirm, $termsAndConditions);
        $context            = new RegistrationContext($this->userRepository, $this->registrationValidator, $this->passwordHasher, $this->activationCodeGenerator);
        if ($httpRequest->getMethod() === 'POST') {
            $response->proceed = true;
            $response->failed    = !$context->process($request, $response);
        }

        return $response;
    }

    public function loginAction(Request $httpRequest) {
        $username = $httpRequest->get('username');
        $password = $httpRequest->get('password');

        $response                = new LoginResponse;
        $request                 = new LoginRequest($username, $password);
        $interactor              = new LoginInteractor($this->userRepository, $this->passwordHasher);
        if ($httpRequest->getMethod() === 'POST') {
            $response->proceed     = true;
            $response->failed = !$interactor->process($request, $response);
        }
        return $response;
    }

    public function activateAction(Request $httpRequest) {

        $username                = $httpRequest->get('username');
        $activationCode          = $httpRequest->get('activationKey');
        $request                 = new ActivateUserRequest($username, $activationCode);
        $response                = new ActivateUserResponse;
        $interactor              = new ActivateUserInteractor($this->userRepository, $this->activateUserValidator);
        $response->proceed = true;
        $response->failed = !$interactor->process($request, $response);
        return $response;
    }

}
