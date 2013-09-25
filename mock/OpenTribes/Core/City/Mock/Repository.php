<?php

namespace OpenTribes\Core\City\Mock;
use OpenTribes\Core\City\Repository as CityRepositoryInterface;
use OpenTribes\Core\City;
use OpenTribes\Core\User;
class Repository implements CityRepositoryInterface{
    private $data;
    public function add(City $city) {
        $this->data[$city->getName()] = $city;
    }
    public function findById($id) {
       
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
        return isset($this->data[$name])?$this->data[$name]:null;
    }
    public function findByUser(User $user) {
        foreach($this->data as $city){
            if($city->getOwner() === $user) return $city;
        }
        return null;
    }
    public function create() {
        return new City;
    }
}
