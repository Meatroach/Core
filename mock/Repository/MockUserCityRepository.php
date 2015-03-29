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
     * @return CityEntity[]| array
     */
    public function findAllByUsername($username)
    {
        $found = [];
        foreach($this->cities as $city){
            if($city->getOwner()->getUsername() === $username){
                $found []= $city;
            }
        }
        return $found;
    }

    public function add(CityEntity $city)
    {
        $this->cities[]=$city;
    }

}