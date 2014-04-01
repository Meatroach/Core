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
       
        assertGreaterThanOrEqual((int) $minX, $this->x);
        assertLessThanOrEqual((int) $maxX, $this->x);
        assertGreaterThanOrEqual((int) $minY, $this->y);
        assertLessThanOrEqual((int) $maxY, $this->y);
    }

}
