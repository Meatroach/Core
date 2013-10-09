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

    protected $userHelper;
    protected $cityHelper;
    protected $exceptionHelper;
    protected $buildingHelper;

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters) {
        // Initialize your context here
        $this->parameters = $parameters;
        $this->exceptionHelper = new ExceptionHelper();
        $this->userHelper = new UserHelper($this->exceptionHelper);
        $this->cityHelper = new CityHelper($this->exceptionHelper);
        $this->buildingHelper = new BuildingHelper($this->exceptionHelper);
    }

    /** @BeforeScenario */
    public function before($event) {
        $this->startProfile();
    }

    /** @AfterScenario */
    public function after($event) {

        $stepName = $event->getScenario()->getTitle();
        $featureName = $event->getScenario()->getFeature()->getTitle();
        $name = str_replace(' ', '-', $featureName . '::' . $stepName);
        $this->endProfile($name);
    }

    private function startProfile() {
        if (extension_loaded('xhprof')) {

            include_once '/usr/share/php/xhprof_lib/utils/xhprof_lib.php';
            include_once '/usr/share/php/xhprof_lib/utils/xhprof_runs.php';
            xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY + XHPROF_FLAGS_NO_BUILTINS);
        }
    }

    private function endProfile($name = 'OpenTribes-Core') {
        if (extension_loaded('xhprof')) {

            $xhprof_data = xhprof_disable();
            if (!is_dir('/tmp/xhprof'))
                mkdir('/tmp/xhprof');
            $xhprof_runs = new XHProfRuns_Default();

            $xhprof_runs->save_run($xhprof_data, $name);
        }
    }

//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        doSomethingWith($argument);
//    }
//
    /**
     * @Given /^I\'m not registered user$/
     */
    public function iamNotRegisteredUser() {

        $this->userHelper->newUser();
    }

    /**
     * @Given /^I have "([^"]*)" roles$/
     */
    public function iHaveRoles($arg1) {
        $this->userHelper->addRole($arg1);
    }

    /**
     * @When /^I register with following informations:$/
     */
    public function iRegisterWithFollowingInformations(TableNode $table) {
        $this->userHelper->create($table->getHash());
    }

    /**
     * @Then /^I should be registered$/
     */
    public function iShouldBeRegistered() {
        $this->userHelper->assertIsCreateResponse();
    }

    /**
     * @When /^I login with following informations:$/
     */
    public function iLoginWithFollowingInformations(TableNode $table) {
        $this->userHelper->login($table->getHash());
    }

    /**
     * @Then /^I should be logged in$/
     */
    public function iShouldBeLoggedIn() {
        $this->userHelper->assertIsLoginResponse();
    }

    /**
     * @Given /^I should get an activation code$/
     */
    public function iShouldGetAnActivationCode() {
        $this->userHelper->assertHasActivationCode();
    }

    /**
     * @Given /^I should get an email with activation code$/
     */
    public function iShouldGetAnEmailWithActivationCode() {
        $this->userHelper->sendActivationCode();
    }

    /**
     * @Then /^I should see "([^"]*)"$/
     */
    public function iShouldSee($arg1) {
        $this->exceptionHelper->assertException($arg1);
    }

    /**
     * @Given /^user with follwoing informations:$/
     */
    public function userWithFollwoingInformations(TableNode $table) {

        $this->userHelper->createDumpUser($table->getHash());
    }

    /**
     * @When /^I activate account with following informations:$/
     */
    public function iActivateAccountWithFollowingInformations(TableNode $table) {
        $this->userHelper->activateAccount($table->getHash());
    }

    /**
     * @Then /^I should be activated$/
     */
    public function iShouldBeActivated() {
        $this->userHelper->assertActivated();
    }

    /**
     * @Given /^I\'m not logged in$/
     */
    public function iamNotLoggedIn() {
        $this->userHelper->newUser();
    }

    /**
     * @Given /^I should have "([^"]*)" roles$/
     */
    public function iShouldHaveRoles($arg1) {
        $this->userHelper->assertHasRole($arg1);
    }

    /**
     * @Given /^following tiles:$/
     */
    public function followingTiles(TableNode $table) {
        $this->cityHelper->getMapHelper()->createTiles($table->getHash());
    }

    /**
     * @Given /^a map "([^"]*)" with following tiles:$/
     */
    public function aMapWithFollowingTiles($arg1, TableNode $table) {
        $this->cityHelper->getMapHelper()->createMapWithTiles($arg1, $table->getRowsHash());
    }

    /**
     * @Given /^following cities:$/
     */
    public function followingCities(TableNode $table) {
        $this->cityHelper->setUserRepository($this->userHelper->getUserRepository());
        $this->cityHelper->setBuildingRepo($this->buildingHelper->getBuildingRepository());
        $this->cityHelper->createCities($table->getHash());
    }

    /**
     * @Given /^I\'m logged in as user "([^"]*)"$/
     */
    public function iMLoggedInAsUser($arg1) {
        $this->cityHelper->iamUser($arg1);
    }

    /**
     * @When /^I create a city at location x=(\d+) and y=(\d+)$/
     */
    public function iCreateACityAtLocationXAndY($arg1, $arg2) {
        $this->cityHelper->create($arg1, $arg2);
    }

    /**
     * @Then /^I should have a city$/
     */
    public function iShouldHaveACity() {
        $this->cityHelper->assertHasCity();
    }

    /**
     * @Given /^following Buildings:$/
     */
    public function followingBuildings(TableNode $table) {
        $this->buildingHelper->createDumbBuildings($table->getHash());
    }

    /**
     * @Given /^I have a city$/
     */
    public function iHaveACity() {
        $this->cityHelper->assignDumpCity();
    }

    /**
     * @Given /^following techtree:$/
     */
    public function followingTechtree(TableNode $table) {

        $this->buildingHelper->createTechtree($table->getHash());
    }

    /**
     * @Given /^following resources:$/
     */
    public function followingResources(TableNode $table) {
        $this->buildingHelper->createResources($table->getHash());
    }

    /**
     * @Given /^the city have following buildings:$/
     */
    public function theCityHaveFollowingBuildings(TableNode $table) {
        $this->cityHelper->setBuildingRepo($this->buildingHelper->getBuildingRepository());
        $this->cityHelper->assignBuildingsToCity($table->getHash());
    }

    /**
     * @Given /^the city have following resources:$/
     */
    public function theCityHaveFollowingResources(TableNode $table) {
        $this->cityHelper->setResourceRepo($this->buildingHelper->getResourceRepository());
        $this->cityHelper->assignResourcesToCity($table->getHash());
    }

    /**
     * @When /^I build "([^"]*)"$/
     */
    public function iBuild($arg1) {
        $this->cityHelper->setTechTree($this->buildingHelper->getTechTree());
        $this->cityHelper->build($arg1);
    }

    /**
     * @Then /^I should have "([^"]*)" in building Queue$/
     */
    public function iShouldHaveInBuildingQueue($arg1) {
        throw new PendingException();
    }

    /**
     * @Given /^city should have less resources$/
     */
    public function cityShouldHaveLessResources() {
        throw new PendingException();
    }

    /**
     * @Given /^following building costs:$/
     */
    public function followingBuildingCosts(TableNode $table) {
        $this->buildingHelper->setBuildingCosts($table->getHash());
    }

    /**
     * @Given /^following building times:$/
     */
    public function followingBuildingTimes(TableNode $table) {
        $this->buildingHelper->setBuildingBuildTimes($table->getHash());
    }

    /**
     * @Given /^building queue has (\d+) actions$/
     */
    public function buildingQueueHasActions($arg1) {
        throw new PendingException();
    }

    /**
     * @Given /^city should have following resources:$/
     */
    public function cityShouldHaveFollowingResources(TableNode $table) {
        throw new PendingException();
    }

    /**
     * @Given /^I have a total of (\d+) aldermen$/
     */
    public function citiesHaveAldermen($arg1) {
        throw new PendingException();
    }

}
