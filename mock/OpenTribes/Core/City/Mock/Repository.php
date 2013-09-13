<?php

namespace OpenTribes\Core\City\Mock;
use OpenTribes\Core\City\Repository as CityRepositoryInterface;
use OpenTribes\Core\City;
use OpenTribes\Core\User;
class Repository implements CityRepositoryInterface{
    private $data;
    public function add(City $city) {
        $this->data[$city->getId()] = $city;
    }
    public function findById($id) {
       return isset($this->data[$id])?$this->data[$id]:null ;
    }
    public function findByLocation($x, $y) {
        foreach($this->data as $city){
            if($city->getX() == $x && $city->getY()== $y){
                return $city;
            }
        }
        return null;
    }
    public function findByName($name) {
        ;
    }
    public function findByUser(User $user) {
        ;
    }
    public function create() {
        return new City;
    }
}
