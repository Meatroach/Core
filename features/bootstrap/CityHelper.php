<?php

use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Repository\Map as MapRepository;
use OpenTribes\Core\Interactor\CreateCity as CreateCityInteractor;
use OpenTribes\Core\Interactor\SelectLocation as SelectLocationInteractor;
use OpenTribes\Core\Request\SelectLocation as SelectLocationRequest;
use OpenTribes\Core\Response\SelectLocation as SelectLocationResponse;
use OpenTribes\Core\Request\CreateCity as CreateCityRequest;
use OpenTribes\Core\Response\CreateCity as CreateCityResponse;
use OpenTribes\Core\Service\LocationCalculator;

class CityHelper {

    private $userRepository;
    private $cityRepository;
    private $mapRepository;
    private $interactorResult;
    private $locationCalculator;
    private $x;
    private $y;

    function __construct(CityRepository $cityRepository, MapRepository $mapRepository, UserRepository $userRepository, LocationCalculator $locationCalculator) {
        $this->userRepository     = $userRepository;
        $this->cityRepository     = $cityRepository;
        $this->mapRepository      = $mapRepository;
        $this->locationCalculator = $locationCalculator;
    }

    public function createDummyCity($name, $owner, $y, $x) {
        $cityId = $this->cityRepository->getUniqueId();
        $user   = $this->userRepository->findOneByUsername($owner);

        $city = $this->cityRepository->create($cityId, $name, $user, $y, $x);
        $this->cityRepository->add($city);
    }

    public function createCityAsUser($y, $x, $username) {
        $request                = new CreateCityRequest($y, $x, $username);
        $response               = new CreateCityResponse;
        $interactor             = new CreateCityInteractor($this->cityRepository, $this->mapRepository, $this->userRepository);
        $this->interactorResult = $interactor->process($request, $response);
    }

    public function assertCityCreated() {
        assertTrue($this->interactorResult);
    }

    public function assertCityNotCreated() {
        assertFalse($this->interactorResult);
    }

    public function assertCityIsInArea($minX, $maxX, $minY, $maxY) {
        assertGreaterThanOrEqual((int) $minX, $this->x);
        assertLessThanOrEqual((int) $maxX, $this->x);
        assertGreaterThanOrEqual((int) $minY, $this->y);
        assertLessThanOrEqual((int) $maxY, $this->y);
    }

    public function assertCityIsNotAtLocations(array $locations) {
        foreach ($locations as $location) {
            $x = $location['x'];
            $y = $location['y'];
            assertNotEquals($this->x, $x);
            assertNotEquals($this->y, $y);
        }
    }

    public function selectLocation($direction, $username) {
        $request    = new SelectLocationRequest($direction);
        $interactor = new SelectLocationInteractor($this->locationCalculator);
        $response   = new SelectLocationResponse;
        $interactor->process($request, $response);
        $this->x    = $response->x;
        $this->y    = $response->y;
    }

}
