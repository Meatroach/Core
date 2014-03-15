<?php

use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Interactor\CreateCity as CreateCityInteractor;
use OpenTribes\Core\Request\CreateCity as CreateCityRequest;
use OpenTribes\Core\Response\CreateCity as CreateCityResponse;
class CityHelper {

    private $userRepository;
    private $cityRepository;

    function __construct(CityRepository $cityRepository, UserRepository $userRepository) {
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
    }

    public function createDummyCity($name, $owner, $y, $x) {
        $cityId = $this->cityRepository->getUniqueId();
        $user = $this->userRepository->findOneByUsername($owner);
        $city = $this->cityRepository->create($cityId, $name, $user, $x, $y);
        $this->cityRepository->add($city);
    }
    public function createCity($y,$x,$username){
        $request = new CreateCityRequest($username, $x, $y);
        $interactor = new CreateCityInteractor($cityRepository, $mapRepository, $userRepository);
    }
}
