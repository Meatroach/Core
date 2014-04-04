<?php

use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Repository\Map as MapRepository;
use Behat\Mink\Mink;

/**
 * Description of CityHelper
 *
 * @author BlackScorp<witalimik@web.de>
 */
class SilexCityHelper {

    private $cityRepository;
    private $userRepository;
    private $mapRepository;
    private $mink;
    private $sessionName;

    /**
     * @var \Behat\Mink\Element\DocumentElement
     */
    private $page;
    private $x;
    private $y;

    public function __construct(Mink $mink, CityRepository $cityRepository, UserRepository $userRepository, MapRepository $mapRepository) {
        $this->cityRepository = $cityRepository;
        $this->userRepository = $userRepository;
        $this->mapRepository  = $mapRepository;
        $this->mink           = $mink;
        $this->sessionName    = $this->mink->getDefaultSessionName();
    }

    public function createDummyCity($name, $owner, $y, $x) {
        $cityId = $this->cityRepository->getUniqueId();
        $user   = $this->userRepository->findOneByUsername($owner);

        $city = $this->cityRepository->create($cityId, $name, $user, $y, $x);
        $this->cityRepository->add($city);
    }

    private function loadPage() {
        $this->page = $this->mink->getSession($this->sessionName)->getPage();
    }

    public function selectLocation($direction, $username) {
        $this->loadPage();
        $this->mink->getSession()->setCookie('username', $username);
        $this->page->selectFieldOption('direction', $direction);
        $this->page->pressButton('select');
    }

    public function assertCityIsInArea($minX, $maxX, $minY, $maxY) {
        $this->loadPage();
        $spanX = $this->page->find('css', 'span.x');
        $spanY = $this->page->find('css', 'span.y');

        $this->mink->assertSession()->statusCodeEquals(200);
        assertNotNull($spanY, 'span class="y" not found');
        assertNotNull($spanX, 'span class="x" not found');
        $this->x = (int) $spanX->getText();
        $this->y = (int) $spanY->getText();

        assertGreaterThanOrEqual((int) $minX, $this->x);
        assertLessThanOrEqual((int) $maxX, $this->x);
        assertGreaterThanOrEqual((int) $minY, $this->y);
        assertLessThanOrEqual((int) $maxY, $this->y);
    }

    public function assertCityIsNotAtLocations(array $locations) {

        foreach ($locations as $location) {
            $x           = $location[1];
            $y           = $location[0];
            $expectedKey = sprintf('Y%d/X%d', $y, $x);
            $currentKey  = sprintf('Y%d/X%d', $this->y, $this->x);
            assertNotSame($currentKey, $expectedKey, sprintf("%s is not %s", $expectedKey, $currentKey));
        }
    }

    public function assertCityCreated() {
        $this->mink->assertSession()->statusCodeEquals(200);
    }

    public function assertCityNotCreated() {
        throw new Behat\Behat\Exception\PendingException;
    }

    /**
     * @param integer $y
     * @param integer $x
     */
    public function assertCityExists($name, $owner, $y, $x) {
        throw new Behat\Behat\Exception\PendingException;
    }

    public function selectPosition($y, $x) {
        throw new Behat\Behat\Exception\PendingException;
    }

    public function assertCityHasBuilding($name, $level) {
        throw new Behat\Behat\Exception\PendingException;
    }

    public function createCityAsUser($y, $x, $username) {
        throw new Behat\Behat\Exception\PendingException;
    }

    public function listUsersCities($username) {
        throw new Behat\Behat\Exception\PendingException;
    }

}
