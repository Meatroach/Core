<?php

namespace OpenTribes\Core\Test\Mock\Repository;


use OpenTribes\Core\Entity\CityEntity;
use OpenTribes\Core\Repository\CityRepository;

class MockCityRepository implements CityRepository{
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

    public function countUserCities($username)
    {
       $counter = 0;
        foreach($this->cities as $city){
            if($city->getOwner()->getUsername() === $username){
                $counter ++;
            }
        }
        return $counter;
    }

}