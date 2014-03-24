<?php

use OpenTribes\Core\Context\Player\CreateNewCity as CreateNewCityInteractor;
use OpenTribes\Core\Interactor\CreateCity as CreateCityInteractor;
use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\Map as MapRepository;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Request\CreateCity as CreateCityRequest;
use OpenTribes\Core\Request\CreateNewCity as CreateNewCityRequest;
use OpenTribes\Core\Response\CreateCity as CreateCityResponse;
use OpenTribes\Core\Response\CreateNewCity as CreateNewCityResponse;
use OpenTribes\Core\Service\LocationCalculator;

class CityHelper {

    private $userRepository;
    private $cityRepository;
    private $mapRepository;
    private $interactorResult;
    private $locationCalculator;
    private $x = 0;
    private $y = 0;

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
        $request                = new CreateCityRequest($y, $x, $username, $username . '\'s Village');
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
            $x = $location[1];
            $y = $location[0];
            $expectedKey = sprintf('%d/%d',$y,$x);
            $currentKey = sprintf('%d/%d',$this->y,$this->x);
            assertNotSame($currentKey, $expectedKey,  sprintf("%s is not %s",$expectedKey,$currentKey));
        }
    }

    private function getDefaultCityName($username) {
        return sprintf("%s's City", $username);
    }

    public function selectLocation($direction, $username) {
        $request    = new CreateNewCityRequest($username, $direction, $this->getDefaultCityName($username));
        $interactor = new CreateNewCityInteractor($this->cityRepository, $this->mapRepository, $this->userRepository, $this->locationCalculator);
        $response   = new CreateNewCityResponse;
        $interactor->process($request, $response);
        $this->x    = $response->city->x;
        $this->y    = $response->city->y;
    }

}
