<?php

use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\User as UserRepository;

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

}
