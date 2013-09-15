<?php
namespace OpenTribes\Core\City\Building\Mock;
use OpenTribes\Core\City\Building\Repository as CityBuildingInterface;
use OpenTribes\Core\City\Building as CityBuilding;
class Repository implements CityBuildingInterface{
    private $data = array();
    public function add(CityBuilding $building) {
        $this->data[$building->getId()]=$building;
    }
    public function findByBuildingName($name) {
      foreach($this->data as $cityBuilding){
          $building = $cityBuilding->getBuilding();
          if($building->getName() === $name){
              return $cityBuilding;
          }
      }
    }
    public function findByCityName($name) {
        ;
    }
}
