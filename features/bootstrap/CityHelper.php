<?php

use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Repository\Map as MapRepository;
use OpenTribes\Core\Interactor\CreateCity as CreateCityInteractor;
use OpenTribes\Core\Request\CreateCity as CreateCityRequest;
use OpenTribes\Core\Response\CreateCity as CreateCityResponse;

class CityHelper {

    private $userRepository;
    private $cityRepository;
    private $mapRepository;
    private $interactorResult;

    function __construct(CityRepository $cityRepository, MapRepository $mapRepository, UserRepository $userRepository) {
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
        $this->mapRepository  = $mapRepository;
    }

    public function createDummyCity($name, $owner, $y, $x) {
        $cityId = $this->cityRepository->getUniqueId();
        $user   = $this->userRepository->findOneByUsername($owner);
        $city   = $this->cityRepository->create($cityId, $name, $user, $y, $x);
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

}
