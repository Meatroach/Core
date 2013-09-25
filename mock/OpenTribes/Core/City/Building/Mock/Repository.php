<?php
namespace OpenTribes\Core\City\Building\Mock;
use OpenTribes\Core\City\Building\Repository as CityBuildingInterface;
use OpenTribes\Core\City\Building as CityBuilding;
use OpenTribes\Core\City;
class Repository implements CityBuildingInterface{
    private $data = array();
    public function add(CityBuilding $building) {
        $this->data[$building->getName()]=$building;
    }
    public function findByBuildingName($name) {
      foreach($this->data as $cityBuilding){
          $building = $cityBuilding->getBuilding();
          if($building->getName() === $name){
              return $cityBuilding;
          }
      }
      return null;
    }
    public function findByCityName($name) {
        ;
    }
    public function findBuildingsByCity(City $city) {
        $found = array();
        foreach($this->data as $cityBuilding){
            if($cityBuilding->getCity() === $city) $found[]= $cityBuilding;
        }
        return count($found)>0?$found:null;
    }
    public function findAll() {
        return $this->data;
    }
}
