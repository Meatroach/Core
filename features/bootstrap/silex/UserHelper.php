<?php

use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Mink;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Service\ActivationCodeGenerator;
use OpenTribes\Core\Service\PasswordHasher;
use OpenTribes\Core\Validator\Registration as RegistrationValidator;
use OpenTribes\Core\Validator\ActivateUser as ActivateUserValidator;

class SilexUserHelper extends DomainUserHelper {

    /**
     * @var DocumentElement
     */
    private $page;
    private $mink;
    private $sessionName;
   

    public function __construct(Mink $mink, UserRepository $userRepository, RegistrationValidator $registrationValidator, PasswordHasher $passwordHasher, ActivationCodeGenerator $activationCodeGenerator, ActivateUserValidator $activateUserValidator) {

        parent::__construct($userRepository, $registrationValidator, $passwordHasher, $activationCodeGenerator, $activateUserValidator);
        $this->mink        = $mink;
        $this->sessionName = $this->mink->getDefaultSessionName();
    }

    private function loadPage() {
        $this->page = $this->mink->getSession($this->sessionName)->getPage();
    }

    /**
     * @param boolean $termsAndConditions
     */
    public function processRegistration($username, $email, $emailConfirm, $password, $passwordConfirm, $termsAndConditions) {
        $this->loadPage();
        $this->page->fillField('username', $username);
        $this->page->fillField('email', $email);
        $this->page->fillField('emailConfirm', $emailConfirm);
        $this->page->fillField('password', $password);
        $this->page->fillField('passwordConfirm', $passwordConfirm);
        if ($termsAndConditions)
            $this->page->checkField('termsAndConditions');

        $this->page->pressButton('register');
    }

    public function assertRegistrationSucceed() {
        $this->loadPage();
        $this->mink->assertSession()->statusCodeEquals(200);
        $this->mink->assertSession()->elementNotExists('css', '.alert-danger');
    }

    public function getActivateAccountResponse() {
        $response         = new stdClass;
        $response->errors = array();
        return $response;
    }

    public function processLogin($username, $password) {
        $this->loadPage();
        $this->page->fillField('username', $username);
        $this->page->fillField('password', $password);
        $this->page->pressButton('login');
    }

    public function assertLoginSucceed() {
        $this->mink->assertSession()->statusCodeEquals(200);
        $this->mink->assertSession()->elementNotExists('css', '.alert-danger');
    }

    public function assertLoginFailed() {
        $this->mink->assertSession()->elementExists('css', '.alert-danger');
    }

    public function assertActivationSucceed() {
        $this->mink->assertSession()->statusCodeEquals(200);
        $this->mink->assertSession()->elementNotExists('css', '.alert-danger');
    }

    public function assertActivationFailed() {
        $this->mink->assertSession()->elementExists('css', '.alert-danger');
    }

    public function assertRegistrationFailed() {
        $this->mink->assertSession()->elementExists('css', '.alert-danger');
    }

    public function getRegistrationResponse() {
        $response         = new stdClass();
        $response->errors = array();
        return $response;
    }

    public function loginAs($username) {

        $this->mink->getSession()->setCookie('username', $username);
        $this->loggedInUsername = $username;
    }

    public function getLoggedInUsername() {
        return $this->loggedInUsername;
    }

}
