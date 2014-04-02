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

    public function __construct(Mink $mink, CityRepository $cityRepository, UserRepository $userRepository, $mapRepository) {
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
        $this->page->selectFieldOption('direction', $direction);
        $this->page->pressButton('select');
    }

    public function assertCityIsInArea($minX, $maxX, $minY, $maxY) {
        $this->loadPage();
        
        assertGreaterThanOrEqual((int) $minX, $x);
        assertLessThanOrEqual((int) $maxX, $x);
        assertGreaterThanOrEqual((int) $minY, $y);
        assertLessThanOrEqual((int) $maxY, $y);
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
