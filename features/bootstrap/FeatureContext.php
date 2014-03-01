<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    \Behat\Behat\Event\FeatureEvent;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Symfony\Component\HttpKernel\Client;
use Behat\Mink\Mink;
use Behat\Mink\Session;
use Behat\Mink\Driver\BrowserKitDriver;
use OpenTribes\Core\Mock\Repository\User as UserRepository;
use OpenTribes\Core\Domain\Context\Guest\Registration as RegistrationContext;
use OpenTribes\Core\Domain\Interactor\ActivateUser as ActivateUserInteractor;
use OpenTribes\Core\Domain\Request\Registration as RegistrationRequest,
    OpenTribes\Core\Domain\Request\ActivateUser as ActivateUserRequest;
use OpenTribes\Core\Domain\Response\Registration as RegistrationResponse,
    OpenTribes\Core\Domain\Response\ActivateUser as ActivateUserResponse;
use OpenTribes\Core\Mock\Validator\Registration as RegistrationValidator,
    OpenTribes\Core\Mock\Validator\ActivateUser as ActivateUserValidator;
use OpenTribes\Core\Domain\ValidationDto\Registration as RegistrationValidatorDto,
    OpenTribes\Core\Domain\ValidationDto\ActivateUser as ActivateUserValidatorDto;
use OpenTribes\Core\Mock\Service\PlainHash as PasswordHasher;
use OpenTribes\Core\Mock\Service\TestGenerator as ActivationCodeGenerator;

require_once 'vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';

/**
 * Behat context class.
 */
class FeatureContext extends BehatContext {

    private $interactorResult;
    private $userRepository;
    private $userHelper;
    private $messageHelper;

    /**
     * @var \OpenTribes\Core\Domain\Response\Registration;
     */
    private $registrationResponse;
    private $registrationValidator;
    /**
     *
     * @var ActivateUserResponse
     */
    private $activateUserResponse;
    private $activateUserValidator;
    private $passwordHasher;
    private $activationCodeGenerator;

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters) {
        $this->userRepository          = new UserRepository;
        $this->userHelper              = new UserHelper($this->userRepository);
        $this->passwordHasher          = new PasswordHasher;
        $this->activationCodeGenerator = new ActivationCodeGenerator;
        $this->registrationValidator   = new RegistrationValidator(new RegistrationValidatorDto);
        $this->activateUserValidator   = new ActivateUserValidator(new ActivateUserValidatorDto);
        $this->messageHelper           = new MessageHelper();
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
        $request                    = new RegistrationRequest($username, $email, $emailConfirm, $password, $passwordConfirm, $termsAndConditions);
        $interaction                = new RegistrationContext($this->userRepository, $this->registrationValidator, $this->passwordHasher, $this->activationCodeGenerator);
        $this->registrationResponse = new RegistrationResponse;
        $this->interactorResult     = $interaction->process($request, $this->registrationResponse);
    }

    /**
     * @Then /^I should be registered$/
     */
    public function iShouldBeRegistered() {
        assertTrue($this->interactorResult);
    }

    /**
     * @Given /^I should have an activation code$/
     */
    public function iShouldHaveAnActivationCode() {
        assertNotNull($this->registrationResponse->activationCode);
    }

    /**
     * @Then /^I should not be registered$/
     */
    public function iShouldNotBeRegistered() {
        assertFalse($this->interactorResult);
        $this->messageHelper->setMessages($this->registrationResponse->errors);
    }

    /**
     * @Given /^I should see following messages "([^"]*)"$/
     */
    public function iShouldSeeFollowingMessages($message) {
        assertTrue($this->messageHelper->hasMessage($message));
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
        $request = new ActivateUserRequest($username, $activationCode);
        $interactor = new ActivateUserInteractor($this->userRepository, $this->activateUserValidator);
        $this->activateUserResponse = new ActivateUserResponse;
        $this->interactorResult = $interactor->process($request, $this->activateUserResponse);
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

}
