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
    private $user;

    /**
     * @var \Behat\Mink\Element\DocumentElement
     */
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
        $userId     = $this->userRepository->getUniqueId();
        $password   = $this->passwordHasher->hash($password);
        $this->user = $this->userRepository->create($userId, $username, $password, $email);
        if ($activationCode) {
            $this->user->setActivationCode($activationCode);
        }

        $this->userRepository->add($this->user);
    }

    public function clear() {
        $this->userRepository->delete($this->user);
        $this->userRepository->sync();
    }

    public function assertRegistrationSucceed() {
        $this->mink->assertSession()->statusCodeEquals(200);
        $this->mink->assertSession()->elementNotExists('css', '.alert-danger');
        file_put_contents(__DIR__ . '/../../../debugHTML/account_create.html', $this->page->getContent());
    }

    public function processActivateAccount($username, $activationCode) {
        $this->page = $this->mink->getSession()->getPage();
        $url        = sprintf('account/activate/%s/%s', $username, $activationCode);
        $this->mink->getSession()->visit($url);
    }

    public function getActivateAccountResponse() {
        $response         = new stdClass;
        $response->errors = array();
        return $response;
    }

    public function assertActivationSucceed() {
        
    }

    public function assertActivationFailed() {
        $this->mink->assertSession()->elementExists('css', '.alert-danger');
    }

    public function assertRegistrationFailed() {
        //  file_put_contents(__DIR__.'/../../../debugHTML/'.md5($this->page->getContent()).'.html',   $this->page->getContent());
        $this->mink->assertSession()->elementExists('css', '.alert-danger');
    }

    public function getRegistrationResponse() {
        $response         = new stdClass();
        $response->errors = array();
        return $response;
    }

    public function activateUser($username) {
        $user = $this->userRepository->findOneByUsername($username);
        $user->setActivationCode(null);
        $this->userRepository->replace($user);
    }

}
