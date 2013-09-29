<?php

namespace OpenTribes\Core\Mock\City\Building;
use OpenTribes\Core\City\Building\Repository as CityBuildingRepositoryInterface;
use OpenTribes\Core\City\Building as CityBuilding;

class Repository implements CityBuildingRepositoryInterface{
    private $cityBuildings = array();
    public function findByBuildingName($name) {
        ;
    }
    public function findByCity(\OpenTribes\Core\City $city) {
        ;
    }
    public function findByCityName($name) {
        ;
    }
    public function add(CityBuilding $building) {
        $this->cityBuildings[]=$building;
    }
    public function findAll() {
        ;
    }
    public function findBuildingsByCity(\OpenTribes\Core\City $city) {
        ;
    }
}
