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
use OpenTribes\Core\Domain\Request\Registration as RegistrationRequest;
use OpenTribes\Core\Domain\Response\Registration as RegistrationResponse;
use OpenTribes\Core\Mock\Validator\Registration as RegistrationValidator;
use OpenTribes\Core\Domain\ValidationDto\Registration as RegistrationValidatorDto;

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
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters) {
        $this->userRepository        = new UserRepository;
        $this->userHelper            = new UserHelper($this->userRepository);
        $this->registrationValidator = new RegistrationValidator(new RegistrationValidatorDto);
        $this->messageHelper         = new MessageHelper();
    }

    /**
     * @Given /^following users:$/
     */
    public function followingUsers(TableNode $table) {
        foreach ($table->getHash() as $row) {
            $username = $row['username'];
            $password = $row['password'];
            $email    = $row['email'];
            $this->userHelper->createDummyAccount($username, $password, $email);
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
        $request                    = new RegistrationRequest($username, $password, $passwordConfirm, $email, $emailConfirm, $termsAndConditions);
        $interaction                = new RegistrationContext($this->userRepository, $this->registrationValidator);
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
        throw new PendingException();
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

}
