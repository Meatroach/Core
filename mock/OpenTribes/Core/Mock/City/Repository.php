<?php
namespace OpenTribes\Core\Mock\City;
use OpenTribes\Core\City\Repository as CityRepositoryInterface;
use OpenTribes\Core\User;
use OpenTribes\Core\City;
class Repository implements CityRepositoryInterface{
    private $cities = array();
    public function add(City $city) {
        $this->cities[$city->getName()] = $city;
    }
    public function create() {
        return new City();
    }
    public function findByName($name) {
        return isset($this->cities[$name])?$this->cities[$name]:null;
    }
    public function findByUser(User $user) {
        foreach($this->cities as $city){
            if($city->getOwner() === $user) return $city;
        }
    }
}
