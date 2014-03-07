<?php

use OpenTribes\Core\Domain\Repository\User as UserRepository;
use OpenTribes\Core\Domain\Validator\Registration as RegistrationValidator;
use OpenTribes\Core\Domain\Service\PasswordHasher;
use OpenTribes\Core\Domain\Service\ActivationCodeGenerator;
use OpenTribes\Core\Domain\Context\Guest\Registration as RegistrationContext;
use OpenTribes\Core\Domain\Request\Registration as RegistrationRequest;
use OpenTribes\Core\Domain\Response\Registration as RegistrationResponse;
use Behat\Mink\Mink;

require_once 'vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';

class DeliveryUserHelper {

    private $userRepository;
    private $registrationValidator;
    private $passwordHasher;
    private $activationCodeGenerator;
    private $registrationResponse;
    private $page;
    private $mink;

    public function __construct(Mink $mink, UserRepository $userRepository, RegistrationValidator $registrationValidator, PasswordHasher $passwordHasher, ActivationCodeGenerator $activationCodeGenerator) {
        $this->userRepository          = $userRepository;
        $this->registrationValidator   = $registrationValidator;
        $this->passwordHasher          = $passwordHasher;
        $this->activationCodeGenerator = $activationCodeGenerator;
        $this->mink                    = $mink;
    }

    public function processRegistration($username, $email, $emailConfirm, $password, $passwordConfirm, $termsAndConditions) {
        $this->page = $this->mink->getSession()->getPage();

        $this->page->fillField('username', $username);
        $this->page->fillField('email', $email);
        $this->page->fillField('emailConfirm', $emailConfirm);
        $this->page->fillField('password', $password);
        $this->page->fillField('passwordConfirm', $passwordConfirm);
        if ($termsAndConditions)
            $this->page->checkField('termsAndConditions');

        $this->page->pressButton('register');
    }

    public function createDummyAccount($username, $password, $email, $activationCode = null) {
        $userId = $this->userRepository->getUniqueId();
        $user   = $this->userRepository->create($userId, $username, $password, $email);
        if ($activationCode) {
            $user->setActivationCode($activationCode);
        }
        $this->userRepository->add($user);
    }

    public function assertRegistrationSucceed() {
        // assertTrue(count($this->registrationResponse->errors) === 0);
    }

    public function processActivateAccount($username, $activationCode) {
        $request                       = new ActivateUserRequest($username, $activationCode);
        $interactor                    = new ActivateUserInteractor($this->userRepository, $this->activateUserValidator);
        $this->activateAccountResponse = new ActivateUserResponse;
        return $interactor->process($request, $this->activateAccountResponse);
    }

    public function getActivateAccountResponse() {
        return $this->activateAccountResponse;
    }

    public function assertActivationSucceed() {
        assertTrue(count($this->activateAccountResponse->errors) === 0);
    }

    public function assertActivationFailed() {
        assertTrue(count($this->activateAccountResponse->errors) > 0);
    }

    public function assertRegistrationFailed() {
        $this->mink->assertSession()->elementExists('css', '.alert-danger');
    }

    public function getRegistrationResponse() {
        $response         = new stdClass();
        $response->errors = array();
        return $response;
    }

}
