<?php

namespace OpenTribes\Core\Mock\Repository;


use OpenTribes\Core\Entity\CityEntity;
use OpenTribes\Core\Repository\UserCityRepository;

class MockUserCityRepository implements UserCityRepository{
    /**
     * @var CityEntity[]
     */
    private $cities = [];
    /**
     * @param $username
     * @return CityEntity[]| null
     */
    public function findAllByUsername($username)
    {
        foreach($this->cities as $city){

        }
    }

}