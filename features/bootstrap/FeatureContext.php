<?php

use Behat\Behat\Exception\PendingException;
use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use OpenTribes\Core\ValidationDto\ActivateUser as ActivateUserValidatorDto;
use OpenTribes\Core\ValidationDto\Registration as RegistrationValidatorDto;
use OpenTribes\Core\Mock\Repository\User as UserRepository;
use OpenTribes\Core\Mock\Service\PlainHash as PasswordHasher;
use OpenTribes\Core\Mock\Service\TestGenerator as ActivationCodeGenerator;
use OpenTribes\Core\Mock\Validator\ActivateUser as ActivateUserValidator;
use OpenTribes\Core\Mock\Validator\Registration as RegistrationValidator;
use OpenTribes\Core\Mock\Repository\Tile as TileRepository;

require_once 'vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';

/**
 * Behat context class.
 */
class FeatureContext extends BehatContext {

    protected $userRepository;
    protected $userHelper;
    protected $messageHelper;
    protected $registrationValidator;
    protected $activateUserValidator;
    protected $passwordHasher;
    protected $activationCodeGenerator;
    protected $mink;
    protected $tileRepository;
    protected $tileHelper;

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters) {
        $this->userRepository          = new UserRepository;
        $this->tileRepository          = new TileRepository();
        $this->passwordHasher          = new PasswordHasher;
        $this->activationCodeGenerator = new ActivationCodeGenerator;
        $this->registrationValidator   = new RegistrationValidator(new RegistrationValidatorDto);
        $this->activateUserValidator   = new ActivateUserValidator(new ActivateUserValidatorDto);
        $this->tileHelper              = new TileHelper($this->tileRepository);
        $this->userHelper              = new DomainUserHelper($this->userRepository, $this->registrationValidator, $this->passwordHasher, $this->activationCodeGenerator, $this->activateUserValidator);
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
        $this->userHelper->processRegistration($username, $email, $emailConfirm, $password, $passwordConfirm, $termsAndConditions);
    }

    /**
     * @Then /^I should be registered$/
     */
    public function iShouldBeRegistered() {
        $this->userHelper->assertRegistrationSucceed();
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
        $this->userHelper->processActivateAccount($username, $activationCode);
    }

    /**
     * @When /^I visit "([^"]*)"$/
     */
    public function iVisit($url) {
        $url            = str_replace('account/activate/', '', $url);
        $values         = explode('/', $url);
        $username       = $values[0];
        $activationCode = $values[1];
        $this->userHelper->processActivateAccount($username, $activationCode);
    }

    /**
     * @Then /^I should get (\d+) errorpage$/
     */
    public function iShouldGetErrorpage($code) {
        if ($this->mink) {
            $this->mink->assertSession()->statusCodeEquals($code);
        }
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
        $this->userHelper->assertActivationSucceed();
    }

    /**
     * @Then /^I should not be activated$/
     */
    public function iShouldNotBeActivated() {
        $this->userHelper->assertActivationFailed();
        $this->messageHelper->setMessages($this->userHelper->getActivateAccountResponse()->errors);
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
        $this->userHelper->processLogin($username, $password);
    }

    /**
     * @Then /^I should be logged in$/
     */
    public function iShouldBeLoggedIn() {
        $this->userHelper->assertLoginSucceed();
    }

    /**
     * @Then /^I should not be logged in$/
     */
    public function iShouldNotBeLoggedIn() {
        $this->userHelper->assertLoginFailed();
    }

    /**
     * @Given /^following tiles:$/
     */
    public function followingTiles(TableNode $table) {
        foreach ($table->getHash() as $row) {
            $name       = $row['name'];
            $accessable = (bool) $row['accessable'];
            $this->tileHelper->createDummyTile($name, $accessable);
        }
    }

    /**
     * @Given /^a map "([^"]*)" with following tiles:$/
     */
    public function aMapWithFollowingTiles($mapName, TableNode $table) {
        $map       = array(
            array()
        );
        $positionX = 0;
        $positionY = 0;
        foreach ($table->getRows() as $number => $rows) {


            //var_dump($rows[0]);
            foreach ($rows as $row) {

                //var_dump($row);
            }
        }


        throw new PendingException();
    }

    /**
     * @Given /^user with follwoing informations:$/
     */
    public function userWithFollwoingInformations(TableNode $table) {
        throw new PendingException();
    }

    /**
     * @Given /^following cities:$/
     */
    public function followingCities(TableNode $table) {
        throw new PendingException();
    }

    /**
     * @Given /^I\'m logged in as user "([^"]*)"$/
     */
    public function iMLoggedInAsUser($arg1) {
        throw new PendingException();
    }

    /**
     * @When /^I create a city at location x=(\d+) and y=(\d+)$/
     */
    public function iCreateACityAtLocationXAndY($arg1, $arg2) {
        throw new PendingException();
    }

    /**
     * @Then /^I should have a city$/
     */
    public function iShouldHaveACity() {
        throw new PendingException();
    }

    /**
     * @Then /^I should see "([^"]*)"$/
     */
    public function iShouldSee($arg1) {
        throw new PendingException();
    }

}
