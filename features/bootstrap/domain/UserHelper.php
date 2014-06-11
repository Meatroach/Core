<?php

use OpenTribes\Core\Context\Guest\Registration as RegistrationContext;
use OpenTribes\Core\Interactor\ActivateUser as ActivateUserInteractor;
use OpenTribes\Core\Interactor\Login as LoginInteractor;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Request\ActivateUser as ActivateUserRequest;
use OpenTribes\Core\Request\Login as LoginRequest;
use OpenTribes\Core\Request\Registration as RegistrationRequest;
use OpenTribes\Core\Response\ActivateUser as ActivateUserResponse;
use OpenTribes\Core\Response\Login as LoginResponse;
use OpenTribes\Core\Response\Registration as RegistrationResponse;
use OpenTribes\Core\Service\ActivationCodeGenerator;
use OpenTribes\Core\Service\PasswordHasher;
use OpenTribes\Core\Validator\ActivateUser as ActivateUserValidator;
use OpenTribes\Core\Validator\Registration as RegistrationValidator;
use PHPUnit_Framework_Assert as Test;

class DomainUserHelper
{

    private $userRepository;
    private $registrationValidator;
    private $passwordHasher;
    private $activationCodeGenerator;
    private $registrationResponse;
    private $activateAccountResponse;
    private $activateUserValidator;
    private $loginResponse;

    /**
     * @var boolean
     */
    private $interactorResult;
    protected $loggedInUsername;

    public function __construct(
        UserRepository $userRepository,
        RegistrationValidator $registrationValidator,
        PasswordHasher $passwordHasher,
        ActivationCodeGenerator $activationCodeGenerator,
        ActivateUserValidator $activateUserValidator
    ) {
        $this->userRepository          = $userRepository;
        $this->registrationValidator   = $registrationValidator;
        $this->passwordHasher          = $passwordHasher;
        $this->activationCodeGenerator = $activationCodeGenerator;
        $this->activateUserValidator   = $activateUserValidator;
    }

    /**
     * @param boolean $termsAndConditions
     */
    public function processRegistration(
        $username,
        $email,
        $emailConfirm,
        $password,
        $passwordConfirm,
        $termsAndConditions
    ) {
        $request                    = new RegistrationRequest($username, $email, $emailConfirm, $password, $passwordConfirm, $termsAndConditions);
        $interaction                = new RegistrationContext($this->userRepository, $this->registrationValidator, $this->passwordHasher, $this->activationCodeGenerator);
        $this->registrationResponse = new RegistrationResponse;
        return $interaction->process($request, $this->registrationResponse);
    }

    public function assertRegistrationSucceed()
    {
        Test::assertTrue(count($this->registrationResponse->errors) === 0);
    }

    public function assertRegistrationFailed()
    {
        Test::assertTrue(count($this->registrationResponse->errors) > 0);
    }

    public function getRegistrationResponse()
    {
        return $this->registrationResponse;
    }

    public function processActivateAccount($username, $activationCode)
    {
        $request                       = new ActivateUserRequest($username, $activationCode);
        $interactor                    = new ActivateUserInteractor($this->userRepository, $this->activateUserValidator);
        $this->activateAccountResponse = new ActivateUserResponse;
        return $interactor->process($request, $this->activateAccountResponse);
    }

    public function getActivateAccountResponse()
    {
        return $this->activateAccountResponse;
    }

    public function assertActivationSucceed()
    {

        Test::assertTrue(count($this->activateAccountResponse->errors) === 0);
    }

    public function assertActivationFailed()
    {
        Test::assertTrue(count($this->activateAccountResponse->errors) > 0);
    }

    public function processLogin($username, $password)
    {
        $request                = new LoginRequest($username, $password);
        $interactor             = new LoginInteractor($this->userRepository, $this->passwordHasher);
        $this->loginResponse    = new LoginResponse;
        $this->interactorResult = $interactor->process($request, $this->loginResponse);
    }

    public function assertLoginSucceed()
    {

        Test::assertTrue($this->interactorResult);
    }

    public function assertLoginFailed()
    {
        Test::assertFalse($this->interactorResult);
    }

    public function createDummyAccount($username, $password, $email, $activationCode = null)
    {
        $userId   = $this->userRepository->getUniqueId();
        $password = $this->passwordHasher->hash($password);
        $user     = $this->userRepository->create($userId, $username, $password, $email);
        if ($activationCode) {
            $user->setActivationCode($activationCode);
        }

        $this->userRepository->add($user);
    }

    public function activateUser($username)
    {
        $user = $this->userRepository->findOneByUsername($username);
        if (!$user) {
            throw new Exception("could not activate user,user not found");
        }
        $user->setActivationCode(null);
        $this->userRepository->replace($user);
    }

    public function loginAs($username)
    {
        $this->loggedInUsername = $username;
    }

    public function getLoggedInUsername()
    {
        return $this->loggedInUsername;
    }

}
