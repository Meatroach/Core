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

require_once 'vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';

/**
 * Behat context class.
 */
class FeatureContext extends BehatContext {

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters) {
        
    }

    /**
     * @Given /^following users:$/
     */
    public function followingUsers(TableNode $table) {
        throw new PendingException();
    }

    /**
     * @Given /^I\'m not registered user$/
     */
    public function iMNotRegisteredUser() {
        throw new PendingException();
    }

    /**
     * @When /^I register with following informations:$/
     */
    public function iRegisterWithFollowingInformations(TableNode $table) {
        throw new PendingException();
    }

    /**
     * @Then /^I should be registered$/
     */
    public function iShouldBeRegistered() {
        throw new PendingException();
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
        throw new PendingException();
    }

    /**
     * @Given /^I should see following messages "([^"]*)"$/
     */
    public function iShouldSeeFollowingMessages($arg1) {
        throw new PendingException();
    }

}
