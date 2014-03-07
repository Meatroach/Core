<?php

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use OpenTribes\Core\Domain\Interactor\ActivateUser as ActivateUserInteractor;
use OpenTribes\Core\Domain\Interactor\Login as LoginInteractor;
use OpenTribes\Core\Domain\Request\ActivateUser as ActivateUserRequest;
use OpenTribes\Core\Domain\Request\Login as LoginRequest;
use OpenTribes\Core\Domain\Response\ActivateUser as ActivateUserResponse;
use OpenTribes\Core\Domain\Response\Login as LoginResponse;
use OpenTribes\Core\Domain\ValidationDto\ActivateUser as ActivateUserValidatorDto;
use OpenTribes\Core\Domain\ValidationDto\Registration as RegistrationValidatorDto;
use OpenTribes\Core\Mock\Repository\User as UserRepository;
use OpenTribes\Core\Mock\Service\PlainHash as PasswordHasher;
use OpenTribes\Core\Mock\Service\TestGenerator as ActivationCodeGenerator;
use OpenTribes\Core\Mock\Validator\ActivateUser as ActivateUserValidator;
use OpenTribes\Core\Mock\Validator\Registration as RegistrationValidator;

require_once 'vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';

/**
 * Behat context class.
 */
class FeatureContext extends BehatContext {

    private $interactorResult;
    protected $userRepository;
    protected $userHelper;
    protected $messageHelper;



    /**
     * @var ActivateUserResponse
     */
    private $activateUserResponse;

    /**
     * @var LoginResponse 
     */
    private $loginResponse;
    protected $registrationValidator;
    private $activateUserValidator;
    protected $passwordHasher;
    protected $activationCodeGenerator;
    protected $mink;

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters) {
        $this->userRepository = new UserRepository;

        $this->passwordHasher          = new PasswordHasher;
        $this->activationCodeGenerator = new ActivationCodeGenerator;
        $this->registrationValidator   = new RegistrationValidator(new RegistrationValidatorDto);
        $this->activateUserValidator   = new ActivateUserValidator(new ActivateUserValidatorDto);

        $this->userHelper = new DomainUserHelper($this->userRepository, $this->registrationValidator, $this->passwordHasher, $this->activationCodeGenerator);


        $this->messageHelper = new MessageHelper();
    }

 

    /**
     * @Given /^following users:$/
     */
    public function followingUsers(TableNode $table) {
        foreach ($table->getHash() as $row) {
            $username       = $row['username'];
            $password       = $row['password'];
            $email          = $row['email'];
            $activationCode = null;
            if (isset($row['activationCode'])) {
                $activationCode = $row['activationCode'];
            }
            $this->userHelper->createDummyAccount($username, $password, $email, $activationCode);
        }
    }

    /**
     * @Given /^I\'m not registered user$/
     */
    public function iMNotRegisteredUser() {
        
    }

    /**
     * @When /^I register with following informations:$/
     */
    public function iRegisterWithFollowingInformations(TableNode $table) {
        foreach ($table->getHash() as $row) {
            $username           = $row['username'];
            $password           = $row['password'];
            $passwordConfirm    = $row['passwordConfirm'];
            $email              = $row['email'];
            $emailConfirm       = $row['emailConfirm'];
            $termsAndConditions = (bool) $row['termsAndConditions'];
        }
        $this->userHelper->processRegistration($username, $email, $emailConfirm, $password, $passwordConfirm, $termsAndConditions);
    }

    /**
     * @Then /^I should be registered$/
     */
    public function iShouldBeRegistered() {
        $this->userHelper->assertRegistrationSucceed();
    }

    /**
     * @Given /^I should have an activation code$/
     */
    public function iShouldHaveAnActivationCode() {
        // assertNotNull($this->userHelper->getRegistrationResponse()->activationCode);
    }

    /**
     * @Then /^I should not be registered$/
     */
    public function iShouldNotBeRegistered() {
        $this->userHelper->assertRegistrationFailed();
        $this->messageHelper->setMessages($this->userHelper->getRegistrationResponse()->errors);
    }

    /**
     * @Given /^I should see following messages "([^"]*)"$/
     */
    public function iShouldSeeFollowingMessages($message) {
        $this->messageHelper->hasMessage($message);
    }

    /**
     * @Given /^I\'am not logged in$/
     */
    public function iAmNotLoggedIn() {
        
    }

    /**
     * @When /^I activate account with following informations:$/
     */
    public function iActivateAccountWithFollowingInformations(TableNode $table) {
        foreach ($table->getHash() as $row) {
            $username       = $row['username'];
            $activationCode = $row['activationCode'];
        }
        $request                    = new ActivateUserRequest($username, $activationCode);
        $interactor                 = new ActivateUserInteractor($this->userRepository, $this->activateUserValidator);
        $this->activateUserResponse = new ActivateUserResponse;
        $this->interactorResult     = $interactor->process($request, $this->activateUserResponse);
    }

    /**
     * @Given /^I\'am on site "([^"]*)"$/
     */
    public function iAmOnSite($uri) {
        if ($this->mink)
            $this->mink->getSession()->visit($uri);
    }

    /**
     * @Then /^I should be activated$/
     */
    public function iShouldBeActivated() {
        assertTrue($this->interactorResult);
    }

    /**
     * @Then /^I should not be activated$/
     */
    public function iShouldNotBeActivated() {
        assertFalse($this->interactorResult);
        $this->messageHelper->setMessages($this->activateUserResponse->errors);
    }

    /**
     * @Given /^"([^"]*)" is activated$/
     */
    public function isActivated($username) {
        $this->userHelper->activateUser($username);
    }

    /**
     * @When /^I login with following informations:$/
     */
    public function iLoginWithFollowingInformations(TableNode $table) {
        foreach ($table->getHash() as $row) {
            $username = $row['username'];
            $password = $row['password'];
        }
        $request                = new LoginRequest($username, $password);
        $interactor             = new LoginInteractor($this->userRepository, $this->passwordHasher);
        $this->loginResponse    = new LoginResponse;
        $this->interactorResult = $interactor->process($request, $this->loginResponse);
    }

    /**
     * @Then /^I should be logged in$/
     */
    public function iShouldBeLoggedIn() {
        assertTrue($this->interactorResult);
    }

    /**
     * @Then /^I should not be logged in$/
     */
    public function iShouldNotBeLoggedIn() {
        assertFalse($this->interactorResult);
    }

}
