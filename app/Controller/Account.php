<?php

namespace OpenTribes\Core\Controller;

use Mustache_Engine as Renderer;
use OpenTribes\Core\Domain\Context\Guest\Registration as RegistrationContext;
use OpenTribes\Core\Domain\Interactor\Login as LoginInteractor;
use OpenTribes\Core\Domain\Repository\User as UserRepository;
use OpenTribes\Core\Domain\Request\Login as LoginRequest;
use OpenTribes\Core\Domain\Request\Registration as RegistrationRequest;
use OpenTribes\Core\Domain\Response\Login as LoginResponse;
use OpenTribes\Core\Domain\Response\Registration as RegistrationResponse;
use OpenTribes\Core\Domain\Service\ActivationCodeGenerator;
use OpenTribes\Core\Domain\Service\PasswordHasher;
use OpenTribes\Core\Domain\Validator\Registration as RegistrationValidator;
use Symfony\Component\HttpFoundation\Request;

class Account {

    private $renderer;
    private $userRepository;
    private $passwordHasher;
    private $registrationValidator;
    private $activationCodeGenerator;

    public function __construct(Renderer $renderer, UserRepository $userRepository, PasswordHasher $passwordHasher,
            RegistrationValidator $registrationValidator, ActivationCodeGenerator $activationCodeGenerator) {
        $this->renderer                = $renderer;
        $this->userRepository          = $userRepository;
        $this->passwordHasher          = $passwordHasher;
        $this->registrationValidator   = $registrationValidator;
        $this->activationCodeGenerator = $activationCodeGenerator;
    }

    public function createAction(Request $httpRequest) {
        $username                = $httpRequest->get('username');
        $email                   = $httpRequest->get('email');
        $emailConfirm            = $httpRequest->get('emailConfirm');
        $password                = $httpRequest->get('password');
        $passwordConfirm         = $httpRequest->get('passwordConfirm');
        $termsAndConditions      = (bool) $httpRequest->get('termsAndConditions');
        $response                = new RegistrationResponse;
        $request                 = new RegistrationRequest($username, $email, $emailConfirm, $password, $passwordConfirm, $termsAndConditions);
        $context                 = new RegistrationContext($this->userRepository, $this->registrationValidator, $this->passwordHasher,
                $this->activationCodeGenerator);
        $response->isSuccessfull = true;
        if ($httpRequest->getMethod() === 'POST') {
            $response->isSuccessfull = $context->process($request, $response);
        }
        return $this->renderer->render('pages/registration', $response);
    }

    public function loginAction(Request $httpRequest) {
        $username = $httpRequest->get('username');
        $password = $httpRequest->get('password');

        $response                = new LoginResponse;
        $request                 = new LoginRequest($username, $password);
        $interactor              = new LoginInteractor($this->userRepository, $this->passwordHasher);
        $response->isSuccessfull = true;
        if ($httpRequest->getMethod() === 'POST') {
            $response->isSuccessfull = $interactor->process($request, $response);
        }
        return $this->renderer->render('pages/login', $response);
    }

}
